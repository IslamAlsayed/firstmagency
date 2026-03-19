<!DOCTYPE html>
<html class="h-full" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.customer_replied_on_ticket_notification') }}</title>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">
    <style>
        :root {
            --font-family: "{{ $settings->font_name ?? 'Tajawal' }}", system-ui, -apple-system, Segoe UI, Aria !important;
        }

        * {
            font-family: var(--font-family) !important;
        }
    </style>
    <link href="{{ asset('assets/plugins/tailwind/tailwind.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            background: #ea580c;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 600;
        }

        .ticket-box {
            margin-top: 15px;

            &>div {
                background: #f8fafc;
                padding: 10px 15px;
                border-radius: 6px;
            }
        }

        .email-badge {
            display: inline-block;
            background: #fed7aa;
            color: #92400e;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 15px;
            border-left: 3px solid #ea580c;
        }

        .container {
            border-left: 4px solid #ea580c;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="email-badge">💬 {{ __('main.customer_message_received') ?? 'رسالة عميل جديدة' }}</div>
        <h2>{{ __('main.customer_replied_on_ticket_notification') }}</h2>
        <div>
            <span>{{ __('main.hello') }} <strong>{{ $ticket->department?->name ?? __('main.support') }}</strong>،</span>
            <span>{{ $ticket->name }} {{ __('main.has_replied_on_your_ticket') }}</span>
        </div>

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
