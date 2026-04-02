<?php

namespace App\Http\Controllers\Api\V1\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Ticket\StoreRequest;
use App\Http\Requests\Api\Ticket\StoreMessageRequest;
use App\Http\Resources\Api\TicketMessageResource;
use App\Http\Resources\Api\TicketResource;
use App\Mail\TicketCreatedMail;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TicketRating;
use App\Traits\AblyService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    use ApiResponseTrait, AblyService;

    public function store(StoreRequest $request): JsonResponse
    {
        $ticket = Ticket::create($request->safe()->except('message'));

        TicketMessage::create([
            'ticket_id'   => $ticket->id,
            'message'     => $request->message,
            'sender_type' => 'customer',
        ]);

        Mail::to($ticket->email)->queue(new TicketCreatedMail($ticket));

        return $this->successResponse(new TicketResource($ticket), 'Ticket created successfully.', 201);
    }

    public function show(string $uuid, Request $request): JsonResponse
    {
        $ticket = Ticket::where('uuid', $uuid)->with(['messages', 'department'])->first();

        if (! $ticket) {
            return $this->notFoundResponse('Ticket not found.');
        }

        if ($request->query('token') !== $ticket->token) {
            return $this->errorResponse('Invalid token.', 403);
        }

        return $this->successResponse(new TicketResource($ticket));
    }

    public function storeMessage(string $uuid, StoreMessageRequest $request): JsonResponse
    {
        $ticket = Ticket::where('uuid', $uuid)->first();

        if (! $ticket) {
            return $this->notFoundResponse('Ticket not found.');
        }

        if ($request->token !== $ticket->token) {
            return $this->errorResponse('Invalid token.', 403);
        }

        $message = TicketMessage::create([
            'ticket_id'   => $ticket->id,
            'message'     => $request->your_reply,
            'sender_type' => 'customer',
        ]);

        $this->publishToAbly("ticket-{$ticket->uuid}", 'new-customer-reply', [
            'ticket_uuid' => $ticket->uuid,
            'message_id'  => $message->id,
        ]);

        return $this->successResponse(new TicketMessageResource($message), 'Message sent.', 201);
    }

    public function updateMessage(int $messageId, Request $request): JsonResponse
    {
        $message = TicketMessage::with('ticket')->find($messageId);

        if (! $message) {
            return $this->notFoundResponse('Message not found.');
        }

        if ($request->token !== $message->ticket->token) {
            return $this->errorResponse('Invalid token.', 403);
        }

        $validated = $request->validate(['your_reply' => 'required|string|min:5']);
        $message->update(['message' => $validated['your_reply']]);

        $this->publishToAbly("ticket-{$message->ticket->uuid}", 'message-updated', [
            'ticket_uuid' => $message->ticket->uuid,
            'message_id'  => $message->id,
        ]);

        return $this->successResponse(new TicketMessageResource($message), 'Message updated.');
    }

    public function deleteMessage(int $messageId, Request $request): JsonResponse
    {
        $message = TicketMessage::with('ticket')->find($messageId);

        if (! $message) {
            return $this->notFoundResponse('Message not found.');
        }

        if ($request->token !== $message->ticket->token) {
            return $this->errorResponse('Invalid token.', 403);
        }

        $ticketUuid = $message->ticket->uuid;
        $message->delete();

        $this->publishToAbly("ticket-{$ticketUuid}", 'message-deleted', [
            'ticket_uuid' => $ticketUuid,
            'message_id'  => $messageId,
        ]);

        return $this->successResponse(null, 'Message deleted.');
    }

    public function showRating(int $ticketId, string $token): JsonResponse
    {
        $ticket = Ticket::where('id', $ticketId)->where('token', $token)->first();

        if (! $ticket) {
            return $this->notFoundResponse('Invalid rating link.');
        }

        if ($ticket->rating) {
            return $this->errorResponse('This ticket has already been rated.', 409);
        }

        return $this->successResponse([
            'ticket' => [
                'id'      => $ticket->id,
                'subject' => $ticket->subject,
                'status'  => $ticket->status,
            ],
        ]);
    }

    public function storeRating(int $ticketId, string $token, Request $request): JsonResponse
    {
        $ticket = Ticket::where('id', $ticketId)->where('token', $token)->first();

        if (! $ticket) {
            return $this->notFoundResponse('Invalid rating link.');
        }

        if ($ticket->rating) {
            return $this->errorResponse('This ticket has already been rated.', 409);
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        TicketRating::create([
            'ticket_id' => $ticket->id,
            'rating'    => $validated['rating'],
            'comment'   => $validated['comment'] ?? null,
            'email'     => $ticket->email,
            'token'     => TicketRating::generateToken(),
            'rated_at'  => now(),
        ]);

        return $this->successResponse(null, 'Rating submitted. Thank you!', 201);
    }
}
