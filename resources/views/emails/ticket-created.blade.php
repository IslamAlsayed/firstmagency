<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_received') }}</title>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            font-family: '{{ $settings->font_name ?? 'Tajawal' }}', system-ui, -apple-system, Segoe UI, Arial, sans-serif !important;
        }
    </style>
</head>

<body dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">
    <div style="background: #fff; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-left: 4px solid #0284c7;">
        <h2 style="margin: 0 0 16px 0; color: #222; font-size: 22px; font-weight: 700;">{{ __('main.ticket_received') }}</h2>
        <div style="margin-bottom: 12px;">
            <span style="color: #444; font-size: 15px;">{{ __('main.hello') }} <strong>{{ $ticket->name }}</strong>،</span>
            <span style="color: #444; font-size: 15px;">{{ __('main.ticket_created_successfully') }}</span>
        </div>
        <div style="background: #f8fafc; padding: 15px; border-radius: 6px; margin-top: 15px; margin-bottom: 18px;">
            <strong style="color: #222;">{{ __('main.ticket_number') }}:</strong>
            <span style="display: inline-block; background: #e5e7eb; border-radius: 4px; font-size: 13px; font-weight: 600; padding: 4px 12px; margin-left: 8px; color: #222;">
                {{ $ticket->uuid }}
            </span>
        </div>
        <a href="{{ $viewLink }}"
            style="display: inline-block; padding: 12px 20px; background: #2563eb; color: #fff !important; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 15px;">{{ __('main.view_ticket') }}</a>
        <p style="margin-top:30px;color:#666; font-size: 14px;">{{ __('main.support_team_response') }}</p>
    </div>
</body>

</html>
