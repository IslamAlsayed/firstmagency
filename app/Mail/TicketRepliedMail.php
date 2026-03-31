<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TicketRepliedMail extends Mailable
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
            subject: __('main.ticket_replied', ['uuid' => $this->ticket->uuid]),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-replied',
            with: [
                'ticket' => $this->ticket,
                'messageRow' => $this->messageRow,
                'viewLink' => route('tickets.show', $this->ticket->uuid),
            ],
        );
    }

    public function attachments(): array
    {
        return collect($this->messageRow->attachments ?? [])
            ->filter(fn($path) => is_string($path) && Storage::disk('public')->exists($path))
            ->map(fn($path) => Attachment::fromStorageDisk('public', $path)->as(basename($path)))
            ->all();
    }
}