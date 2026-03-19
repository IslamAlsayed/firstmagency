<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Notifications\Notification;

class TicketActivityNotification extends Notification
{
    // Types: new_ticket | customer_reply | ticket_rated
    public function __construct(
        public Ticket $ticket,
        public string $type,
        public string $body,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => $this->type,
            'ticket_id'  => $this->ticket->id,
            'ticket_uuid' => $this->ticket->uuid,
            'subject'    => $this->ticket->subject,
            'body'       => $this->body,
            'url'        => route('dashboard.tickets.show', $this->ticket->id),
        ];
    }
}
