<?php

namespace App\Mail;

use App\Models\TicketMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketRepliedMail extends Mailable
{
    use Queueable, SerializesModels;

    public TicketMessage $messageRow;

    public function __construct(TicketMessage $messageRow)
    {
        $this->messageRow = $messageRow;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'تم استلام تذكرتك - ' . $this->messageRow->ticket->uuid,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-replied',
            with: [
                'messageRow' => $this->messageRow,
                'viewLink' => route('tickets.show', $this->messageRow->ticket->uuid),
            ],
        );
    }
}
