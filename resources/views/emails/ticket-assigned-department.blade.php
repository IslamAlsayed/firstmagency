<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f5f5f5;">
    <div style="background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="border-bottom: 3px solid #007bff; margin-bottom: 20px; padding-bottom: 15px;">
            <h1 style="color: #007bff; margin: 0; font-size: 24px;">{{ config('app.name') }}</h1>
        </div>

        <!-- Greeting -->
        <p style="font-size: 16px; color: #333; margin-bottom: 15px;">
            {{ __('main.hello') }} {{ $department->user->name }},
        </p>

        <!-- Main Message -->
        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #007bff; margin-bottom: 20px;">
            <p style="font-size: 14px; color: #555; margin: 0;">
                <strong>{{ __('main.ticket_assigned_to_department_notification') }}</strong>
            </p>
            <p style="font-size: 13px; color: #777; margin-top: 10px;">
                {!! __('main.new_ticket_in_department', ['department' => app()->getLocale() == 'ar' ? $department->name_ar : $department->name]) !!}
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
                    <td style="padding: 8px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.email') }}:</td>
                    <td style="padding: 8px; color: #555;">{{ $ticket->email }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.phone') }}:</td>
                    <td style="padding: 8px; color: #555;">{{ $ticket->phone }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.subject') }}:</td>
                    <td style="padding: 8px; color: #555;">{{ $ticket->subject }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.department') }}:</td>
                    <td style="padding: 8px; color: #555;">{{ $department->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.priority') }}:</td>
                    <td style="padding: 8px; color: #555;">{{ __('main.' . $ticket->priority) }}</td>
                </tr>
            </table>
        </div>

        <!-- Action Button -->
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $ticketLink }}"
                style="display: inline-block; background-color: #007bff; color: white; text-decoration: none; padding: 12px 30px; border-radius: 5px; font-weight: bold; font-size: 14px;">
                {{ __('main.view_ticket') }}
            </a>
        </div>

        <!-- Message -->
        <div style="background-color: #e8f4f8; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <p style="font-size: 13px; color: #555; margin: 0;">
                {{ __('main.ticket_please_respond_soon') }}
            </p>
        </div>

        <!-- Footer -->
        <div style="border-top: 1px solid #ddd; margin-top: 30px; padding-top: 20px; font-size: 12px; color: #888; text-align: center;">
            <p style="margin: 0;">{{ __('main.automated_email_notice') }}</p>
            <p style="margin: 5px 0 0 0;">{{ config('app.name') }} - {{ date('Y') }}</p>
        </div>
    </div>
</div>
