<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_replied') }}</title>
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
        <div
            style="display: inline-block; background: #dbeafe; color: #0c4a6e; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 15px; border-left: 3px solid #0284c7;">
            ✓ {{ __('main.support_response') ?? 'رد من الفريق' }}</div>
        <h2 style="margin-top:0; color:#0c4a6e;">{{ __('main.ticket_replied') }}</h2>
        <div style="margin-bottom: 10px; color:#222;">
            <span>{{ __('main.hello') }} <strong>{{ $ticket->name }}</strong>،</span>
            <span>{{ __('main.ticket_replied_successfully') }}</span>
        </div>
        <div style="margin-top: 15px;">
            <strong style="color:#0c4a6e;">{{ __('main.ticket_message') }}:</strong>
            <div style="background: #f8fafc; padding: 10px 15px; border-radius: 6px; border: 1px solid #00000050; margin-top: 5px; font-size: 14px; color: #222;">
                {!! $messageRow->message !!}
            </div>
        </div>
        @if ($messageRow->attachments)
            <div style="margin-top: 15px;">
                <strong style="color:#0c4a6e;">{{ __('main.attachments') }}:</strong>
                <div style="background: #f8fafc; padding: 10px 15px; border-radius: 6px; border: 1px solid #00000050; margin-top: 5px; font-size: 14px; color: #222;">
                    <ul style="margin: 0; padding-inline-start: 18px;">
                        @foreach ($messageRow->attachments as $attachment)
                            <li>
                                <a href="{{ asset('storage/' . $attachment) }}" target="_blank" style="color: #2563eb; text-decoration: underline;">
                                    {{ basename($attachment) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <a href="{{ $viewLink }}"
            style="display: inline-block; padding: 12px 20px; background: #0c4a6e; color: #fff !important; text-decoration: none; border-radius: 6px; margin-top: 20px; font-weight: 600;">{{ __('main.view_ticket') }}</a>
        <p style="margin:20px 0 0;color:#666">{{ __('main.support_team_response') }}</p>
    </div>
</body>

</html>
