<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerReplyOnTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public TicketMessage $messageRow;

    public function __construct(Ticket $ticket, TicketMessage $messageRow)
    {
        $this->ticket = $ticket;
        $this->messageRow = $messageRow;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: __('main.customer_replied_on_ticket', ['uuid' => $this->ticket->uuid, 'name' => $this->ticket->name]),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer-reply-on-ticket',
            with: [
                'ticket' => $this->ticket,
                'messageRow' => $this->messageRow,
                'ticketLink' => route('dashboard.tickets.show', $this->ticket->id),
            ],
        );
    }
}
