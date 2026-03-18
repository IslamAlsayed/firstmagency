<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\Department;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketAssignedDepartmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public Department $department;

    public function __construct(Ticket $ticket, Department $department)
    {
        $this->ticket = $ticket;
        $this->department = $department;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: __('main.ticket_assigned_to_department', ['subject' => $this->ticket->subject, 'department' => $this->department->name]),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-assigned-department',
            with: [
                'ticket' => $this->ticket,
                'department' => $this->department,
                'ticketLink' => route('dashboard.tickets.show', $this->ticket->id),
            ],
        );
    }
}
