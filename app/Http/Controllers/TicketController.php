<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\StoreMessageRequest;
use App\Http\Requests\Ticket\StoreRequest;
use App\Http\Requests\Ticket\UpdateMessageRequest;
use App\Mail\CustomerReplyOnTicketMail;
use App\Mail\TicketAssignedDepartmentMail;
use App\Mail\TicketCreatedMail;
use App\Mail\TicketThankForRatingMail;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TicketRating;
use App\Models\User;
use App\Notifications\TicketActivityNotification;
use App\Support\SafeMail;
use App\Traits\AblyService;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use PhotoUploadTrait, AblyService;

    public function index()
    {
        $a = rand(1, 9);
        $b = rand(1, 9);
        $departments = Department::get(['id', 'name']);
        session(['ticket_verification' => $a + $b]);
        return view('website.tickets.index', compact('a', 'b', 'departments'));
    }

    public function inquiry(Request $request)
    {
        $tickets = Ticket::where('email', $request->input('email'))->orWhere('uuid', $request->input('email'))->get() ?? [];
        return view('website.tickets.inquiry', compact('tickets'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $message = $validated['message'] ?? null;
        unset($validated['verification'], $validated['attachments'], $validated['message']);
        $ticket = Ticket::create($validated);

        // Create initial message
        if ($message) {
            $messageRow = $ticket->messages()->create([
                'message' => $message,
                'sender_type' => 'customer',
            ]);

            if ($request->hasFile('attachments')) {
                $this->uploadFiles($request, $messageRow, 'attachments', 'tickets-customers');
            }
        }

        // Send email to customer
        SafeMail::send($ticket->email, new TicketCreatedMail($ticket), [
            'source' => __CLASS__ . '@store',
            'ticket_id' => $ticket->id,
        ]);

        // Send email to department user
        $department = Department::find($ticket->department_id);
        if ($department && $department->user) {
            SafeMail::send($department->user->email, new TicketAssignedDepartmentMail($ticket, $department), [
                'source' => __CLASS__ . '@store',
                'ticket_id' => $ticket->id,
                'department_id' => $department->id,
            ]);
        }

        // Notify all admins/superadmins about new ticket
        $notification = new TicketActivityNotification(
            ticket: $ticket,
            type: 'new_ticket',
            body: __('main.customer') . ': ' . $ticket->name,
        );
        $users = User::whereIn('role', ['superadmin', 'admin'])->get();
        foreach ($users as $user) {
            $user->notify($notification);
        }

        $this->publishToAbly('dashboard-notifications', 'ticket-notification', [
            'type' => 'new_ticket',
            'subject' => $ticket->subject,
            'body' => __('main.customer') . ': ' . $ticket->name,
            'url' => route('dashboard.tickets.show', $ticket->id),
            'created_at' => now()->toIso8601String(),
            'created_at_human' => now()->diffForHumans(),
        ]);

        // Publish new ticket event to Ably
        $ticketData = [
            'id' => $ticket->id,
            'uuid' => $ticket->uuid,
            'name' => $ticket->name,
            'email' => $ticket->email,
            'subject' => $ticket->subject,
            'department_id' => $ticket->department_id,
            'status' => $ticket->status,
            'priority' => $ticket->priority,
            'created_at' => $ticket->created_at->format('Y-m-d H:i:s'),
            'created_at_human' => $ticket->created_at->diffForHumans(),
        ];
        $this->publishToAbly('dashboard-tickets', 'new-ticket-created', $ticketData);

        // Send tickets counts to Ably channel for real-time updates
        $ticketsCount = Ticket::count();
        $this->publishToAbly('ticket-updates', 'tickets-count', ['tickets_count' => $ticketsCount]);

        session()->forget('ticket_verification');
        return redirect()->route('tickets.show', $ticket->uuid)->withSuccess(__('messages.type_created_successfully', ['type' => __('main.ticket')]));
    }

    public function message(StoreMessageRequest $request, $uuid)
    {
        $ticket = Ticket::with(['messages', 'department'])->where('uuid', $uuid)->first();
        if (!$ticket)
            return redirect()->route('tickets.inquiry')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));

        $validated = $request->validated();
        $messageText = $validated['your_reply'] ?? null;

        // Create new message
        if ($messageText) {
            $messageRow = $ticket->messages()->create([
                'message' => $messageText,
                'sender_type' => 'customer',
            ]);

            // Upload attachments if any
            if ($request->hasFile('attachments')) {
                $this->uploadFiles($request, $messageRow, 'attachments', 'tickets-customers');
            }

            // Send email to department user
            $department = $ticket->department;
            if ($department && $department->user) {
                SafeMail::send($department->user->email, new CustomerReplyOnTicketMail($ticket, $messageRow), [
                    'source' => __CLASS__ . '@message',
                    'ticket_id' => $ticket->id,
                    'message_id' => $messageRow->id,
                ]);
            }

            $messageData = array_merge($messageRow->toArray(), [
                'customer_name' => $ticket->name,
                'ticket_uuid' => $ticket->uuid,
                'created_at' => $messageRow->created_at->format('d/m/Y H:i'),
                'human_readable_date' => $messageRow->created_at->diffForHumans(),
                'user' => [
                    'name' => $ticket->name,
                    'photo' => asset('assets/images/avatars/avatar.png'),
                ],
                'department' => $department ? [
                    'name' => __('main.' . str_replace('-', '_', $department?->name ?? 'support_')),
                    'bg_color' => $department->bg_color,
                    'border_color' => $department->border_color,
                    'border_main_color' => $department->border_main_color,
                    'badge_color' => $department->badge_color,
                ] : null,
                'attachments' => $messageRow->attachments ?? [],
            ]);

            // Publish update to Ably channel (you can customize the channel name and event as needed)
            $this->publishToAbly('ticket-updates', 'new-customer-reply', $messageData);

            // Notify all admins/superadmins about customer reply
            $replyNotification = new TicketActivityNotification(
                ticket: $ticket,
                type: 'customer_reply',
                body: __('main.customer') . ': ' . $ticket->name,
            );
            $users = User::whereIn('role', ['superadmin', 'admin'])->get();
            foreach ($users as $user) {
                $user->notify($replyNotification);
            }

            $this->publishToAbly('dashboard-notifications', 'ticket-notification', [
                'type' => 'customer_reply',
                'subject' => $ticket->subject,
                'body' => __('main.customer') . ': ' . $ticket->name,
                'url' => route('dashboard.tickets.show', $ticket->id),
                'created_at' => now()->toIso8601String(),
                'created_at_human' => now()->diffForHumans(),
            ]);
        }

        return redirect()->back()->withSuccess(__('messages.type_created_successfully', ['type' => __('main.message')]));
    }

    public function show(Request $request, $uuid)
    {
        $ticket = Ticket::with(['messages', 'messages.user.department'])->where('uuid', $uuid)->first();
        if (!$ticket)
            return redirect()->route('tickets.inquiry')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));

        $ticket['department'] = $ticket->department;

        $messagesData = $ticket->messages->map(function ($message) {
            $user = $message->user;
            $department = $user?->department;

            return [
                'id' => $message->id,
                'message' => $message->message,
                'sender_type' => $message->sender_type,
                'created_at' => $message->created_at->format('d/m/Y H:i'),
                'human_readable_date' => $message->created_at->diffForHumans(),

                'user' => [
                    'name' => $user?->name ?? __('main.customer'),
                    'photo' => $user?->photo ? asset('assets/images/avatars/' . $user->photo) : asset('assets/images/avatars/avatar.png'),
                ],

                'department' => [
                    'name' => __('main.' . str_replace('-', '_', $department?->name ?? 'support_')),
                    'bg_color' => $department?->bg_color,
                    'border_color' => $department?->border_color,
                    'border_main_color' => $department?->border_main_color,
                    'badge_color' => $department?->badge_color,
                ],

                'attachments' => $message->attachments ?? [],
            ];
        });

        $ticketData = $ticket->toArray();
        $ticketData['messages'] = $messagesData;

        return view('website.tickets.show', compact('ticket', 'ticketData'));
    }

    public function updateMessage(UpdateMessageRequest $request, $messageId)
    {
        $message = TicketMessage::find($messageId);
        if (!$message)
            return response()->json(['success' => false, 'status' => 'error', 'message' => __('main.msg_not_found')], 404);

        $validated = $request->validated();
        $message->update($validated);

        // Prepare data for Ably with formatted dates
        $messageData = array_merge($message->toArray(), [
            'created_at' => $message->created_at->format('d/m/Y H:i'),
            'human_readable_date' => $message->created_at->diffForHumans(),
            'ticket_uuid' => $message->ticket->uuid,
        ]);

        // Publish update notification to Ably
        $this->publishToAbly('ticket-updates', 'message-updated', $messageData);

        return response()->json(['success' => true, 'status' => 'success', 'message' => __('main.success_updated')]);
    }

    public function deleteMessage($messageId)
    {
        $message = TicketMessage::find($messageId);
        if (!$message)
            return response()->json(['success' => false, 'status' => 'error', 'message' => __('main.msg_not_found')], 404);

        $ticket = $message->ticket;
        $message->delete();

        // Prepare data for Ably with ticket info
        $messageData = [
            'id' => $messageId,
            'ticket_uuid' => $ticket->uuid,
        ];

        // Publish deletion notification to Ably
        $this->publishToAbly('ticket-updates', 'message-deleted', $messageData);

        return response()->json(['success' => true, 'status' => 'success', 'message' => __('main.success_deleted')]);
    }

    public function generateNewVerification()
    {
        $a = rand(1, 9);
        $b = rand(1, 9);
        session(['ticket_verification' => $a + $b]);
        return response()->json(['success' => true, 'a' => $a, 'b' => $b]);
    }

    public function supportProRating($ticketId, $token)
    {
        $ticket = Ticket::where('uuid', $ticketId)->where('token', $token)->first();
        if (!$ticket)
            return view('website.tickets.invalid-rating-link');

        // Check if already rated
        $existingRating = $ticket->rating;
        if ($existingRating)
            return view('website.tickets.rating-already-submitted', compact('ticket', 'existingRating'));

        return view('website.tickets.rating-form', compact('ticket'));
    }

    public function storeRating(Request $request, $ticketId, $token)
    {
        $ticket = Ticket::where('uuid', $ticketId)->where('token', $token)->first();
        if (!$ticket)
            return redirect()->route('tickets.index')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));

        // Check if already rated
        if ($ticket->rating)
            return redirect()->route('tickets.show', $ticket->uuid)->withError(__('messages.ticket_already_rated'));

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Create rating
        $rating = $ticket->ratings()->create([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'email' => $ticket->email,
            'token' => TicketRating::generateToken(),
            'rated_at' => now(),
        ]);

        // Send confirmation email
        // Mail::to($ticket->email)->send(new TicketRatingMail($ticket, $rating));
        SafeMail::send($ticket->email, new TicketThankForRatingMail($ticket, $rating), [
            'source' => __CLASS__ . '@storeRating',
            'ticket_id' => $ticket->id,
            'rating_id' => $rating->id,
        ]);

        // Notify all admins/superadmins about new rating
        $ratingNotification = new TicketActivityNotification(
            ticket: $ticket,
            type: 'ticket_rated',
            body: str_repeat('★', $validated['rating']) . ' - ' . $ticket->name,
        );
        $users = User::whereIn('role', ['superadmin', 'admin'])->get();
        foreach ($users as $user) {
            $user->notify($ratingNotification);
        }

        $this->publishToAbly('dashboard-notifications', 'ticket-notification', [
            'type' => 'ticket_rated',
            'subject' => $ticket->subject,
            'body' => str_repeat('★', $validated['rating']) . ' - ' . $ticket->name,
            'url' => route('dashboard.tickets.show', $ticket->id),
            'created_at' => now()->toIso8601String(),
            'created_at_human' => now()->diffForHumans(),
        ]);

        return redirect()->route('tickets.support_pro_rating', [$ticket->uuid, $ticket->token])->withSuccess(__('messages.rating_submitted_successfully'));
        // return redirect()->route('tickets.show', $ticket->uuid)->withSuccess(__('messages.rating_submitted_successfully'));
    }
}
