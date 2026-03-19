<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreMessageRequest;
use App\Http\Requests\Ticket\StoreRequest;
use App\Http\Requests\Ticket\UpdateRequest;
use App\Mail\TicketAssignedDepartmentMail;
use App\Mail\TicketCopyMail;
use App\Mail\TicketCreatedMail;
use App\Mail\TicketRepliedMail;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\AblyService;
use App\Traits\GlobalDestroyTrait;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait, AblyService;

    public function index()
    {
        $this->authorize('viewAny', Ticket::class);
        $tickets = Ticket::with(['assignedTo']);
        if (getActiveUser()->role == 'support' && getActiveUser()->department) {
            $tickets = $tickets->where('department_id', getActiveUser()->department->id);
        }
        $tickets = $tickets->latest()->paginate(15);
        return view('dashboard.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $this->authorize('create', Ticket::class);
        $users = User::whereIn('role', ['superadmin', 'admin', 'support'])->get();
        $departments = Department::where('is_active', true)->get(['id', 'name']);

        $a = rand(1, 9);
        $b = rand(1, 9);
        session(['ticket_verification' => $a + $b]);
        return view('dashboard.tickets.create', compact('users', 'departments', 'a', 'b'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Ticket::class);
        $validated = $request->validated();
        $message = $validated['message'] ?? null;
        unset($validated['verification'], $validated['attachments'], $validated['message']);
        $validated['user_id'] = getActiveUserId();
        $ticket = Ticket::create($validated);

        // Create initial message
        if ($message) {
            $ticket->messages()->create([
                'user_id' => getActiveUserId(),
                'department_id' => $ticket->department_id,
                'message' => $message,
                'sender_type' => 'support',
            ]);
        }

        // upload new attachments
        if ($request->hasFile('attachments')) {
            $this->uploadFiles($request, $ticket, 'attachments', 'tickets-dashboard');
        }

        // Send email to customer
        Mail::to($ticket->email)->send(new TicketCreatedMail($ticket));

        // Send email to department user
        $department = Department::find($ticket->department_id);
        if ($department && $department->user) {
            Mail::to($department->user->email)->send(new TicketAssignedDepartmentMail($ticket, $department));
        }

        session()->forget('ticket_verification');
        return redirect()->route('dashboard.tickets.index')->withSuccess(__('messages.type_created_successfully', ['type' => __('main.ticket')]));
    }

    public function show($id)
    {
        // $ticket = Ticket::with(['assignedTo', 'messages.department', 'messages.user', 'department.supportUser'])->find($id);
        $ticket = Ticket::with(['assignedTo', 'department.user'])->find($id);
        $departments = Department::get(['id', 'name', 'user_id']);
        $this->authorize('view', $ticket);
        if (!$ticket)
            return redirect()->route('dashboard.tickets.index')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));
        return view('dashboard.tickets.show', compact('ticket', 'departments'));
    }

    public function edit($id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket)
            return redirect()->route('dashboard.tickets.index')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));
        $this->authorize('update', $ticket);
        $users = User::get(['id', 'name', 'role']);
        $departments = Department::where('is_active', true)->get(['id', 'name']);
        return view('dashboard.tickets.edit', compact('ticket', 'users', 'departments'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket)
            return redirect()->route('dashboard.tickets.index')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));
        $this->authorize('update', $ticket);

        $validated = $request->validated();
        unset($validated['attachments'], $validated['removed_attachments']);

        // Store old values for comparison
        $oldDepartmentId = $ticket->department_id;
        $oldStatus = $ticket->status;

        $ticket->update($validated);

        // upload new attachments
        if ($request->hasFile('attachments')) {
            $this->uploadFiles($request, $ticket, 'attachments', 'tickets');
        }

        // remove selected files
        if ($request->filled('removed_attachments')) {
            $removedIndexes = json_decode($request->removed_attachments, true);
            $this->deleteFiles($ticket, $removedIndexes, 'attachments');
        }

        // Send email to new department user if department changed
        if ($oldDepartmentId != $ticket->department_id) {
            $newDepartment = Department::find($ticket->department_id);
            if ($newDepartment && $newDepartment->user) {
                Mail::to($newDepartment->user->email)->send(new TicketAssignedDepartmentMail($ticket, $newDepartment));
            }
        }

        return redirect()->route('dashboard.tickets.index')->withSuccess(__('messages.type_updated_successfully', ['type' => __('main.ticket')]));
    }

    public function supportReply($ticketId)
    {
        $ticket = Ticket::with(['messages', 'messages.user.department'])->find($ticketId);

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

        $this->authorize('view', $ticket);
        if (!$ticket)
            return redirect()->route('dashboard.tickets.index')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));
        return view('dashboard.tickets.supportReply', compact('ticket', 'ticketData'));
    }

    public function postSupportReply(StoreMessageRequest $request, $ticketId)
    {
        // Get ticket by ID
        $ticket = Ticket::find($ticketId);
        if (!$ticket)
            return redirect()->route('dashboard.tickets.index')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));

        // Check authorization
        if (!Auth::check() || !in_array(getActiveUser()->role, ['superadmin', 'admin', 'support'])) {
            return redirect()->route('dashboard.tickets.index')->withError(__('messages.unauthorized_action'));
        }

        $validated = $request->validated();
        $messageText = $validated['your_reply'] ?? null;

        // Create new support reply
        if ($messageText) {
            $messageRow = $ticket->messages()->create([
                'user_id' => getActiveUserId(),
                'message' => $messageText,
                'sender_type' => 'support',
            ]);

            // Upload attachments if any
            if ($request->hasFile('attachments')) {
                $this->uploadFiles($request, $messageRow, 'attachments', 'tickets-support');
            }

            // Prepare comprehensive data for Ably with user info and formatted dates
            $department = getActiveUser()->department;
            $supportUser = getActiveUser(); // The user who is replying
            $messageData = array_merge($messageRow->toArray(), [
                'ticket_uuid' => $ticket->uuid,
                'created_at' => $messageRow->created_at->format('d/m/Y H:i'),
                'human_readable_date' => $messageRow->created_at->diffForHumans(),
                'user' => [
                    'name' => $supportUser->name,
                    'photo' => $supportUser->photo ? asset('assets/images/avatars/' . $supportUser->photo) : asset('assets/images/avatars/avatar.png'),
                ],
                'department' => $department ? [
                    'name' => __('main.' . str_replace('-', '_', $department?->name ?? 'support')),
                    'bg_color' => $department->bg_color,
                    'border_color' => $department->border_color,
                    'border_main_color' => $department->border_main_color,
                    'badge_color' => $department->badge_color,
                ] : null,
                'attachments' => $messageRow->attachments ?? [],
            ]);

            // Publish update to Ably channel (you can customize the channel name and event as needed)
            $this->publishToAbly('ticket-updates', 'new-support-reply', $messageData);

            // Send email to customer
            Mail::to($ticket->email)->send(new TicketRepliedMail($ticket, $messageRow));
        }

        return redirect()->back()->withSuccess(__('messages.type_sended_successfully', ['type' => __('main.message')]));
    }

    // send copy from ticket to customer email
    public function sendCopyToCustomer($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if (!$ticket)
            return redirect()->route('dashboard.tickets.index')->withError(__('messages.type_not_found', ['type' => __('main.ticket')]));
        $this->authorize('view', $ticket);
        Mail::to($ticket->email)->send(new TicketCopyMail($ticket));
        return redirect()->back()->withSuccess(__('messages.email_sent_successfully'));
    }
}
