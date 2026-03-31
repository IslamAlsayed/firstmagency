<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_rating') }}</title>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">
    <style>
        body {
            background: #f3f4f6;
            padding: 40px 0;
            margin: 0;
            font-family: '{{ $settings->font_name ?? 'Tajawal' }}', system-ui, -apple-system, Segoe UI, Arial, sans-serif !important;
        }
    </style>
</head>

<body dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">
    <div style="background: #fff; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-left: 4px solid #0284c7;">
        <div style="border-bottom: 1px solid #e5e7eb; padding-bottom: 12px; margin-bottom: 22px;">
            <h2 style="color: #28a745; margin: 0; font-size: 22px; letter-spacing: 0.5px;">{{ __('main.support_pro') }}</h2>
        </div>
        <div style="padding-bottom: 18px;">
            <h2 style="color: #28a745; margin: 0 0 12px 0; font-size: 20px;">✓ {{ __('main.thanks_for_rating') }}</h2>
            <p style="margin: 0 0 8px 0; color: #222; font-size: 15px;">{{ __('main.ticket_closed') }}</p>
            <p style="margin: 0 0 18px 0; color: #222; font-size: 15px;">{{ __('main.ticket_feedback_request') }}</p>
            <a href="{{ route('tickets.support_pro_rating', ['ticketId' => $ticket->uuid, 'token' => $ticket->token]) }}"
                style="display: inline-block; padding: 12px 24px; background: #28a745; color: #fff !important; text-decoration: none; border-radius: 6px; font-weight: 600; margin-bottom: 10px; font-size: 15px;">{{ __('main.rate_ticket_now') }}</a>
            <div style="margin-top: 12px;">
                <p style="font-size: 12px; line-height: 1.2; margin: 0 0 2px 0; color: #666;">{{ __('main.if_button_not_working') }}</p>
                <a href="{{ route('tickets.support_pro_rating', ['ticketId' => $ticket->uuid, 'token' => $ticket->token]) }}"
                    style="font-size: 11px; color: #2563eb; word-break: break-all; text-decoration: underline;">{{ route('tickets.support_pro_rating', ['ticketId' => $ticket->uuid, 'token' => $ticket->token]) }}</a>
            </div>
        </div>
        <div style="font-size: 12px; color: #888; border-top: 1px solid #e5e7eb; padding-top: 12px;">
            <p style="margin: 0;">{{ __('main.automated_email_notice') }}</p>
        </div>
    </div>
</body>

</html>
