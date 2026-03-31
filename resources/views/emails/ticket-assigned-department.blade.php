<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_assigned_to_department_notification') }}</title>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            padding: 20px;
            font-family: '{{ $settings->font_name ?? 'Tajawal' }}', system-ui, -apple-system, Segoe UI, Arial, sans-serif !important;
        }
    </style>
</head>

<body dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">
    <div style="background: #fff; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-left: 4px solid #0284c7;">
        <div style="border-bottom: 3px solid #007bff; margin-bottom: 10px; padding-bottom: 10px;">
            <h1 style="color: #007bff; margin: 0; font-size: 24px;">{{ config('app.name') }}</h1>
        </div>
        <p style="font-size: 16px; color: #333; margin-bottom: 15px;">
            {{ __('main.hello') }} {{ $department->user->name }},
        </p>
        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #007bff; margin-bottom: 20px;">
            <p style="font-size: 14px; color: #555; margin: 0;">
                <strong>{{ __('main.ticket_assigned_to_department_notification') }}</strong>
            </p>
            <p style="font-size: 13px; color: #777; margin-top: 10px;">
                {!! __('main.new_ticket_in_department', ['department' => app()->getLocale() == 'ar' ? $department->name_ar : $department->name]) !!}
            </p>
        </div>
        <div style="margin-bottom: 25px;">
            <h3 style="color: #333; margin-bottom: 15px;">{{ __('main.ticket_details') }}</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 5px; background-color: #f0f0f0; font-weight: bold; color: #333; width: 30%;">{{ __('main.ticket_uuid') }}:</td>
                    <td style="padding: 5px; color: #555;">{{ $ticket->uuid }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.customer') }}:</td>
                    <td style="padding: 5px; color: #555;">{{ $ticket->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.email') }}:</td>
                    <td style="padding: 5px; color: #555;">{{ $ticket->email }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.phone') }}:</td>
                    <td style="padding: 5px; color: #555;">{{ $ticket->phone }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.subject') }}:</td>
                    <td style="padding: 5px; color: #555;">{{ $ticket->subject }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.department') }}:</td>
                    <td style="padding: 5px; color: #555;">{{ app()->getLocale() == 'ar' ? $department->name_ar : $department->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px; background-color: #f0f0f0; font-weight: bold; color: #333;">{{ __('main.priority') }}:</td>
                    <td style="padding: 5px; color: #555;">{{ __('main.' . $ticket->priority) }}</td>
                </tr>
            </table>
        </div>
        <div style="text-align: center; margin: 10px 0;">
            <a href="{{ $ticketLink }}"
                style="display: inline-block; background-color: #007bff; color: white; text-decoration: none; padding: 12px 30px; border-radius: 5px; font-weight: bold; font-size: 14px;">{{ __('main.view_ticket') }}</a>
        </div>
        <div style="background-color: #e8f4f8; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            <p style="font-size: 13px; color: #555; margin: 0;">
                {{ __('main.ticket_please_respond_soon') }}
            </p>
        </div>
        <div style="border-top: 1px solid #ddd; margin-top: 10px; padding-top: 20px; font-size: 12px; color: #888; text-align: center;">
            <p style="margin: 0;">{{ __('main.automated_email_notice') }}</p>
            <p style="margin: 5px 0 0 0;">{{ config('app.name') }} - {{ date('Y') }}</p>
        </div>
    </div>
</body>

</html>
</div>
