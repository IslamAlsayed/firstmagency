<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_replied') }}</title>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}"
        rel="stylesheet">
    <style>
        :root {
            --font-family: "{{ $settings->font_name ?? 'Tajawal' }}", system-ui, -apple-system, Segoe UI, Aria !important;
        }

        * {
            font-family: var(----font-family) !important;
        }
    </style>
    <!-- Tailwind CSS -->
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
            background: #2563eb;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }

        .ticket-box {
            margin-top: 15px;

            &>div {
                background: #f8fafc;
                padding: 10px 15px;
                border-radius: 6px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>{{ __('main.ticket_replied') }}</h2>
        <div>
            <span>{{ __('main.hello') }} <strong>{{ $messageRow->ticket->name }}</strong>،</span>
            <span>{{ __('main.ticket_replied_successfully') }}</span>
        </div>
        <div class="ticket-box">
            <strong>{{ __('main.ticket_message') }}:</strong>
            <div class="px-3 py-1 rounded-md text-sm font-medium" style="border: 1px solid #00000050;">
                {!! $messageRow->message !!}
            </div>
        </div>
        <a href="{{ $viewLink }}" class="button">{{ __('main.view_ticket') }}</a>
        <p style="margin-top:30px;color:#666">{{ __('main.support_team_response') }}</p>
    </div>
</body>

</html>
