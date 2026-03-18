<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f5f5f5;">
    <div style="background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="border-bottom: 3px solid #f39c12; margin-bottom: 20px; padding-bottom: 15px;">
            <h1 style="color: #f39c12; margin: 0; font-size: 24px;">{{ config('app.name') }}</h1>
        </div>

        <!-- Greeting -->
        <p style="font-size: 16px; color: #333; margin-bottom: 15px;">
            {{ __('main.hello') }} {{ $ticket->department->user->name }},
        </p>

        <!-- Main Message -->
        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #f39c12; margin-bottom: 20px;">
            <p style="font-size: 14px; color: #555; margin: 0;">
                <strong>{{ __('main.customer_replied_on_ticket_notification') }}</strong>
            </p>
            <p style="font-size: 13px; color: #777; margin-top: 10px;">
                {{ $ticket->name }} {{ __('main.has_replied_on_your_ticket') }}
            </p>
        </div>

        <!-- Ticket Details -->
        <div style="margin-bottom: 25px;">
            <h3 style="color: #333; margin-bottom: 15px;">{{ __('main.ticket_details') }}</h3>

            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; background-color: #f0f0f0; font-weight: bold; color: #333; width: 30%;">{{ __('main.ticket_uuid') }}:</td>
                    <td style="padding: 8px; color: #555;">{{ $ticket->uuid }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.customer') }}:</td>
                    <td style="padding: 8px; color: #555;">{{ $ticket->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.subject') }}:</td>
                    <td style="padding: 8px; color: #555;">{{ $ticket->subject }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.priority') }}:</td>
                    <td style="padding: 8px; color: #555;">{{ __('main.' . $ticket->priority) }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.status') }}:</td>
                    <td style="padding: 8px; color: #555;">{{ __('main.' . $ticket->status) }}</td>
                </tr>
            </table>
        </div>

        <!-- Customer Reply -->
        <div style="margin-bottom: 25px;">
            <h3 style="color: #333; margin-bottom: 15px;">{{ __('main.customer_message') }}</h3>

            <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #27ae60; border-radius: 5px;">
                <p style="font-size: 13px; color: #555; line-height: 1.6; margin: 0; white-space: pre-wrap;">{{ $messageRow->message }}</p>
            </div>

            @if ($messageRow->attachments)
                <div style="margin-top: 15px;">
                    <p style="font-size: 12px; color: #888; margin-bottom: 10px;">
                        <strong>{{ __('main.attachments') }}:</strong>
                    </p>
                    <ul style="margin: 0; padding-left: 20px; font-size: 12px;">
                        @foreach ($messageRow->attachments as $attachment)
                            <li style="color: #666; margin-bottom: 5px;">{{ basename($attachment) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Action Button -->
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $ticketLink }}"
                style="display: inline-block; background-color: #f39c12; color: white; text-decoration: none; padding: 12px 30px; border-radius: 5px; font-weight: bold; font-size: 14px;">
                {{ __('main.view_ticket') }}
            </a>
        </div>

        <!-- Message -->
        <div style="background-color: #fef5e7; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <p style="font-size: 13px; color: #666; margin: 0;">
                {{ __('main.customer_needs_response') }}
            </p>
        </div>

        <!-- Footer -->
        <div style="border-top: 1px solid #ddd; margin-top: 30px; padding-top: 20px; font-size: 12px; color: #888; text-align: center;">
            <p style="margin: 0;">{{ __('main.automated_email_notice') }}</p>
            <p style="margin: 5px 0 0 0;">{{ config('app.name') }} - {{ date('Y') }}</p>
        </div>

    </div>
</div>
