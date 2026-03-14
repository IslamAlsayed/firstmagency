<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\StoreMessageRequest;
use App\Http\Requests\Ticket\StoreRequest;
use App\Http\Requests\Ticket\UpdateMessageRequest;
use App\Mail\TicketCreatedMail;
use App\Mail\TicketThankForRatingMail;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TicketRating;
use App\Traits\AblyService;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    use PhotoUploadTrait, AblyService;

    public function index()
    {
        $a = rand(1, 9);
        $b = rand(1, 9);
        session(['ticket_verification' => $a + $b]);
        return view('website.tickets.index', compact('a', 'b'));
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
        $validated['user_id'] = getActiveUserId() ?? 1;
        $ticket = Ticket::create($validated);

        // Create initial message
        if ($message) {
            $messageRow = $ticket->messages()->create([
                'user_id' => $ticket->user_id,
                'message' => $message,
                'sender_type' => 'customer',
            ]);

            if ($request->hasFile('attachments')) {
                $this->uploadFiles($request, $messageRow, 'attachments', 'tickets-users');
            }
        }

        // Send email to customer
        Mail::to($ticket->email)->send(new TicketCreatedMail($ticket));

        // Publish new ticket event to Ably
        $ticketData = [
            'id' => $ticket->id,
            'uuid' => $ticket->uuid,
            'name' => $ticket->name,
            'email' => $ticket->email,
            'subject' => $ticket->subject,
            'department' => $ticket->department,
            'status' => $ticket->status,
            'priority' => $ticket->priority,
            'created_at' => $ticket->created_at->format('Y-m-d H:i:s'),
            'created_at_human' => $ticket->created_at->diffForHumans(),
        ];
        $this->publishToAbly('dashboard-tickets', 'new-ticket-created', $ticketData);

        session()->forget('ticket_verification');
        return redirect()->route('tickets.show', $ticket->uuid)->withSuccess(__('messages.type_created_successfully', ['type' => __('main.ticket')]));
    }

    public function message(StoreMessageRequest $request, $uuid)
    {
        $ticket = Ticket::with(['user', 'messages'])->where('uuid', $uuid)->first();
        if (!$ticket)
            return redirect()->route('tickets.inquiry')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));

        $validated = $request->validated();
        $messageText = $validated['your_reply'] ?? null;

        // Create new message
        if ($messageText) {
            $messageRow = $ticket->messages()->create([
                'user_id' => $ticket->user_id,
                'message' => $messageText,
                'sender_type' => 'customer',
            ]);

            // Upload attachments if any
            if ($request->hasFile('attachments')) {
                $this->uploadFiles($request, $messageRow, 'attachments', 'tickets-users');
            }

            // Prepare comprehensive data for Ably with user info and formatted dates
            $messageData = array_merge($messageRow->toArray(), [
                'user_name' => $ticket->name ?? 'عميل',
                'ticket_name' => $ticket->name,
                'formatted_date' => $messageRow->created_at->format('d/m/Y H:i'),
                'human_readable_date' => $messageRow->created_at->diffForHumans(),
                'ticket_uuid' => $ticket->uuid,
            ]);

            // Publish update to Ably channel (you can customize the channel name and event as needed)
            $this->publishToAbly('ticket-updates', 'new-customer-reply', $messageData);
        }

        return redirect()->back()->withSuccess(__('messages.type_created_successfully', ['type' => __('main.message')]));
    }

    public function show(Request $request, $uuid)
    {
        $ticket = Ticket::with(['user', 'messages'])->where('uuid', $uuid)->first();
        if (!$ticket)
            return redirect()->route('tickets.inquiry')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));
        return view('website.tickets.show', compact('ticket'));
    }

    public function updateMessage(UpdateMessageRequest $request, $messageId)
    {
        $message = TicketMessage::find($messageId);
        if (!$message)
            return response()->json(['success' => false, 'status' => 'error', 'message' => 'الرسالة غير موجودة'], 404);

        // Check authorization
        // $isOwner = $message->user_id === getActiveUserId();
        // $isSupport = Auth::check() && in_array(getActiveUser()->role, ['superadmin', 'admin', 'support']);

        // if (!$isOwner && !$isSupport) {
        // if (!$isOwner) {
        // return response()->json(['success' => false, 'status' => 'error', 'message' => 'غير مصرح لك بتعديل هذه الرسالة'], 403);
        // }

        $validated = $request->validated();
        $message->update($validated);

        // Prepare data for Ably with formatted dates
        $messageData = array_merge($message->toArray(), [
            'formatted_date' => $message->created_at->format('d/m/Y H:i'),
            'human_readable_date' => $message->created_at->diffForHumans(),
            'ticket_uuid' => $message->ticket->uuid,
        ]);

        // Publish update notification to Ably
        $this->publishToAbly('ticket-updates', 'message-updated', $messageData);

        return response()->json(['success' => true, 'status' => 'success', 'message' => 'تم تحديث الرسالة بنجاح']);
    }

    public function deleteMessage($messageId)
    {
        $message = TicketMessage::find($messageId);
        if (!$message)
            return response()->json(['success' => false, 'status' => 'error', 'message' => 'الرسالة غير موجودة'], 404);

        // Check authorization
        $isOwner = $message->user_id === getActiveUserId();
        $isSupport = Auth::check() && in_array(getActiveUser()->role, ['superadmin', 'admin', 'support']);

        if (!$isOwner && !$isSupport) {
            return response()->json(['success' => false, 'status' => 'error', 'message' => 'غير مصرح لك بحذف هذه الرسالة'], 403);
        }

        $ticket = $message->ticket;
        $message->delete();

        // Prepare data for Ably with ticket info
        $messageData = [
            'id' => $messageId,
            'ticket_uuid' => $ticket->uuid,
        ];

        // Publish deletion notification to Ably
        $this->publishToAbly('ticket-updates', 'message-deleted', $messageData);

        return response()->json(['success' => true, 'status' => 'success', 'message' => 'تم حذف الرسالة بنجاح']);
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
        Mail::to($ticket->email)->send(new TicketThankForRatingMail($ticket, $rating));

        return redirect()->route('tickets.support_pro_rating', [$ticket->uuid, $ticket->token])->withSuccess(__('messages.rating_submitted_successfully'));
        // return redirect()->route('tickets.show', $ticket->uuid)->withSuccess(__('messages.rating_submitted_successfully'));
    }
}
