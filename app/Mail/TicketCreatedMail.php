<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCreatedMail extends Mailable
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
            subject: 'تم استلام تذكرتك - ' . $this->ticket->uuid,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-created',
            with: [
                'ticket' => $this->ticket,
                'viewLink' => route('tickets.show', $this->ticket->uuid),
            ],
        );
    }
}
