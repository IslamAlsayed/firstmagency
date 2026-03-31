<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.customer_replied_on_ticket_notification') }}</title>
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
            style="display: inline-block; background: #fed7aa; color: #92400e; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 15px; border-left: 3px solid #ea580c;">
            💬 {{ __('main.customer_message_received') ?? 'رسالة عميل جديدة' }}</div>
        <h2 style="margin: 0 0 12px 0; color: #222; font-size: 20px; font-weight: 700;">{{ __('main.customer_replied_on_ticket_notification') }}</h2>
        <div style="margin-bottom: 12px;">
            <span style="color: #444; font-size: 15px;">{{ __('main.hello') }} <strong>{{ $ticket->department?->name ?? __('main.support') }}</strong>،</span>
            <span style="color: #444; font-size: 15px;">{{ $ticket->name }} {{ __('main.has_replied_on_your_ticket') }}</span>
        </div>
        <div style="margin-top: 15px;">
            <strong style="color: #222;">{{ __('main.customer_message') }}:</strong>
            <div style="border: 1px solid #00000050; border-radius: 6px; padding: 10px 15px; font-size: 14px; font-weight: 500; background: #f8fafc; margin-top: 6px;">
                {!! $messageRow->message !!}
            </div>
        </div>
        @if ($messageRow->attachments)
            <div style="margin-top: 15px;">
                <strong style="color: #222;">{{ __('main.attachments') }}:</strong>
                <div style="border: 1px solid #00000050; border-radius: 6px; padding: 10px 15px; font-size: 14px; font-weight: 500; background: #f8fafc; margin-top: 6px;">
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
        <a href="{{ $ticketLink }}"
            style="display: inline-block; padding: 12px 20px; background: #ea580c; color: #fff !important; text-decoration: none; border-radius: 6px; margin-top: 20px; font-weight: 600; font-size: 15px;">{{ __('main.view_ticket') }}</a>
        <p style="margin-top:30px;color:#666; font-size: 14px;">{{ __('main.customer_needs_response') }}</p>
    </div>
</body>

</html>

<div class="ticket-box">
    <strong>{{ __('main.customer_message') }}:</strong>
    <div class="px-3 py-1 rounded-md text-sm font-medium" style="border: 1px solid #00000050;">
        {!! $messageRow->message !!}
    </div>
</div>

@if ($messageRow->attachments)
    <div class="ticket-box">
        <strong>{{ __('main.attachments') }}:</strong>
        <div class="px-3 py-2 rounded-md text-sm font-medium" style="border: 1px solid #00000050;">
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

<a href="{{ $ticketLink }}" class="button">{{ __('main.view_ticket') }}</a>
<p style="margin-top:30px;color:#666">{{ __('main.customer_needs_response') }}</p>
</div>
</body>

</html>
