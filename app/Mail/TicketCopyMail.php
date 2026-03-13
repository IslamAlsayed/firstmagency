<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCopyMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: __('main.ticket_received_mail_subject', ['uuid' => $this->ticket->uuid]),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-copy',
            with: [
                'ticket' => $this->ticket,
                'viewLink' => route('tickets.show', $this->ticket->uuid),
            ],
        );
    }
}
