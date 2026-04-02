<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TicketMessageResource;
use App\Http\Resources\Api\TicketResource;
use App\Mail\TicketCopyMail;
use App\Mail\TicketRepliedMail;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Traits\AblyService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    use ApiResponseTrait, AblyService;

    public function index(Request $request): JsonResponse
    {
        $user  = $request->user();
        $query = Ticket::with(['department', 'assignedTo']);

        if ($user->role === 'support' && $user->department) {
            $query->where('department_id', $user->department->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->integer('department_id'));
        }

        if ($request->filled('search')) {
            $s = $request->string('search')->toString();
            $query->where(
                fn($q) => $q
                    ->where('subject', 'like', "%{$s}%")
                    ->orWhere('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
            );
        }

        $perPage = min($request->integer('per_page', 20), 100);
        $tickets = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse($tickets, fn($t) => new TicketResource($t));
    }

    public function show(int $id): JsonResponse
    {
        $ticket = Ticket::with(['messages', 'department', 'assignedTo'])->find($id);

        if (! $ticket) {
            return $this->notFoundResponse('Ticket not found.');
        }

        return $this->successResponse(new TicketResource($ticket));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'subject'       => ['required', 'string', 'max:255'],
            'message'       => ['required', 'string'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'priority'      => ['nullable', 'string', 'max:50'],
            'assigned_to'   => ['nullable', 'exists:users,id'],
        ]);

        $ticket = Ticket::create($validated);

        TicketMessage::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => $request->user()->id,
            'message'     => $validated['message'],
            'sender_type' => 'support',
        ]);

        return $this->successResponse(new TicketResource($ticket), 'Ticket created.', 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $ticket = Ticket::find($id);

        if (! $ticket) {
            return $this->notFoundResponse('Ticket not found.');
        }

        $validated = $request->validate([
            'status'        => ['nullable', 'string'],
            'priority'      => ['nullable', 'string'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'assigned_to'   => ['nullable', 'exists:users,id'],
            'is_active'     => ['nullable', 'boolean'],
        ]);

        $ticket->update($validated);

        return $this->successResponse(new TicketResource($ticket), 'Ticket updated.');
    }

    public function destroy(int $id): JsonResponse
    {
        $ticket = Ticket::find($id);

        if (! $ticket) {
            return $this->notFoundResponse('Ticket not found.');
        }

        $ticket->delete();

        return $this->successResponse(null, 'Ticket deleted.');
    }

    public function deleted(Request $request): JsonResponse
    {
        $perPage = min($request->integer('per_page', 20), 100);
        $tickets = Ticket::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse($tickets, fn($t) => new TicketResource($t));
    }

    public function restore(int $id): JsonResponse
    {
        $ticket = Ticket::onlyTrashed()->find($id);

        if (! $ticket) {
            return $this->notFoundResponse('Deleted ticket not found.');
        }

        $ticket->restore();

        return $this->successResponse(new TicketResource($ticket), 'Ticket restored.');
    }

    public function reply(int $id, Request $request): JsonResponse
    {
        $ticket = Ticket::find($id);

        if (! $ticket) {
            return $this->notFoundResponse('Ticket not found.');
        }

        $validated = $request->validate([
            'message'       => ['required', 'string', 'min:5'],
            'attachments'   => ['nullable', 'array'],
            'attachments.*' => ['file', 'mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx', 'max:5120'],
        ]);

        $message = TicketMessage::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => $request->user()->id,
            'message'     => $validated['message'],
            'sender_type' => 'support',
        ]);

        Mail::to($ticket->email)->queue(new TicketRepliedMail($ticket, $message));

        $this->publishToAbly('ticket-updates', 'new-support-reply', [
            'ticket_uuid' => $ticket->uuid,
            'message_id'  => $message->id,
        ]);

        return $this->successResponse(new TicketMessageResource($message), 'Reply sent.', 201);
    }

    public function sendCopy(int $id): JsonResponse
    {
        $ticket = Ticket::find($id);

        if (! $ticket) {
            return $this->notFoundResponse('Ticket not found.');
        }

        Mail::to($ticket->email)->queue(new TicketCopyMail($ticket));

        return $this->successResponse(null, 'Copy sent to customer.');
    }
}
