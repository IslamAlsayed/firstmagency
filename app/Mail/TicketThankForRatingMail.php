<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\TicketRating;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketThankForRatingMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public ?TicketRating $rating;

    public function __construct(Ticket $ticket, ?TicketRating $rating = null)
    {
        $this->ticket = $ticket;
        $this->rating = $rating;
    }

    public function envelope(): Envelope
    {
        $subject = $this->rating
            ? __('main.rating_thank_you_subject', ['uuid' => $this->ticket->uuid])
            : __('main.ticket_received_mail_subject', ['uuid' => $this->ticket->uuid]);

        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-thank-for-rating',
            with: [
                'ticket' => $this->ticket,
                'rating' => $this->rating,
                'ticketLink' => route('tickets.show', $this->ticket->uuid),
                'ratingLink' => route('tickets.support_pro_rating', [$this->ticket->uuid, $this->ticket->token]),
            ],
        );
    }
}
