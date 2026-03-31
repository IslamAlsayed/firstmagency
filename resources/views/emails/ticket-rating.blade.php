<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_rating') }}</title>
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
        <div style="border-bottom: 1px solid #e5e7eb; padding: 20px 24px 10px 24px; border-radius: 10px 10px 0 0;">
            <h2 style="font-weight: 700; color: #222; margin: 0; font-size: 22px;">{{ __('main.support_pro') }}</h2>
        </div>
        <div style="padding: 24px; display: flex; flex-direction: column; gap: 12px;">
            <h2 style="font-weight: 700; color: #222; margin: 0 0 8px 0; font-size: 18px;">{{ __('main.support_rating') }}</h2>
            <p style="margin: 0 0 8px 0; color: #555; font-size: 15px;">{{ __('main.ticket_closed') }}</p>
            <p style="margin: 0 0 16px 0; color: #555; font-size: 15px;">{{ __('main.ticket_feedback_request') }}</p>
            <a href="{{ route('tickets.support_pro_rating', ['ticketId' => $ticket->uuid, 'token' => $ticket->token]) }}"
                style="display: inline-block; background: #2563eb; color: #fff !important; font-weight: 600; border-radius: 999px; padding: 12px 32px; text-align: center; text-decoration: none; font-size: 16px; margin: 0 auto 8px auto; min-width: 180px;">{{ __('main.rate_ticket_now') }}</a>
            <div style="margin-top: 10px;">
                <p style="font-size: 12px; line-height: 1.2; color: #888; margin: 0 0 4px 0;">{{ __('main.if_button_not_working') }}</p>
                <a href="{{ route('tickets.support_pro_rating', ['ticketId' => $ticket->uuid, 'token' => $ticket->token]) }}"
                    style="font-size: 11px; color: #2563eb; word-break: break-all; text-decoration: underline;">{{ route('tickets.support_pro_rating', ['ticketId' => $ticket->uuid, 'token' => $ticket->token]) }}</a>
            </div>
        </div>
        <div style="font-size: 12px; color: #888; border-top: 1px solid #e5e7eb; padding: 12px 24px 16px 24px; border-radius: 0 0 10px 10px; background: #fafbfc;">
            <p style="margin: 0;">{{ __('main.automated_email_notice') }}</p>
        </div>
    </div>
</body>

</html>
