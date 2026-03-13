<!DOCTYPE html>
<html class="h-full" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_rating') }}</title>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}"
        rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="{{ asset('assets/plugins/tailwind/tailwind.css') }}" rel="stylesheet">
    <style>
        :root {
            --font-family: "{{ $settings->font_name ?? 'Tajawal' }}", system-ui, -apple-system, Segoe UI, Aria !important;
        }

        * {
            font-family: var(--font-family) !important;
        }

        body {
            background: #f5f5f5;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="kt-card bg-white text-gray-500" style="max-width: 500px; margin: auto; border-color: var(--color-gray-200);">
        <div class="kt-card-header" style="border-color: var(--color-gray-200);">
            <h2 class="font-semibold text-black">{{ __('main.support_pro') }}</h2>
        </div>
        <div class="kt-card-body p-4 flex flex-col gap-3">
            <h2 class="font-semibold text-black">{{ __('main.support_rating') }}</h2>
            <p>{{ __('main.ticket_closed') }}</p>
            <p>{{ __('main.ticket_feedback_request') }}</p>
            <a href="{{ route('tickets.support_pro_rating', ['ticketId' => $ticket->uuid, 'token' => $ticket->token]) }}"
                class="kt-btn kt-btn-outline-primary font-semibold rounded-full flex text-center justify-center w-fit">{{ __('main.rate_ticket_now') }}</a>
            <div>
                <p class="text-sm" style="font-size: 12px; line-height: 0.7;">{{ __('main.if_button_not_working') }}</p>
                <a href="{{ route('tickets.support_pro_rating', ['ticketId' => $ticket->uuid, 'token' => $ticket->token]) }}"
                    style="font-size: 10px; color: #2563eb; word-break: break-all;">
                    {{ route('tickets.support_pro_rating', ['ticketId' => $ticket->uuid, 'token' => $ticket->token]) }}
                </a>
            </div>
        </div>
        <div class="kt-card-footer" style="font-size: 12px; border-color: var(--color-gray-200);">
            <p>{{ __('main.automated_email_notice') }}</p>
        </div>
    </div>
</body>

</html>
