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
            background: #f3f4f6;
            padding: 50px 20px 20px;
        }

        .kt-card {
            border: none !important;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08) !important;
        }

        .rating-stars {
            color: #ffc107;
            font-size: 20px;
        }

        .ticket-info {
            padding: 12px;
            font-size: 14px;
            border-radius: 6px;
            background: #f8f9fa;
        }

        .ticket-info-row {
            color: #555;
        }

        .ticket-info-label {
            color: #333;
            font-weight: 600;
            margin-inline-end: 5px;
            display: inline-block;
        }

        .comment-box {
            background: #fff;
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 6px;
            margin-block: 6px 12px;
            line-height: 1.6;
            color: #555;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <div class="kt-card bg-white text-gray-500" style="max-width: 500px; margin: auto; border-color: var(--color-gray-200);">
        <div class="kt-card-header" style="border-color: var(--color-gray-200);">
            <h2 class="font-semibold text-black">{{ __('main.support_pro') }}</h2>
        </div>
        <div class="kt-card-body p-4 flex flex-col gap-2" style="border-color: var(--color-gray-200);">
            <h2 class="font-semibold text-black" style="color: #28a745;">✓ {{ __('main.thanks_for_rating') }}</h2>

            <p style="font-size: 14px">
                {{ __('main.thank_you') }} <strong>{{ $ticket->name }}</strong>، {{ __('main.rating_on_ticket') }}
            </p>

            <p style="font-size: 14px">
                {{ __('main.rating_importance') }}
            </p>

            <!-- Ticket Information -->
            <div class="ticket-info">
                <div class="ticket-info-row">
                    <span class="ticket-info-label">{{ __('main.ticket_number') }}:</span>
                    <span>#{{ $ticket->uuid }}</span>
                </div>
                <div class="ticket-info-row">
                    <span class="ticket-info-label">{{ __('main.subject') }}:</span>
                    <span>{{ $ticket->subject }}</span>
                </div>
            </div>

            <!-- Rating Display -->
            @if ($rating)
                <div style="text-align: center;">
                    <p style="font-size: 14px;">{{ __('main.your_rating') }}:</p>
                    <div class="rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $rating->rating)
                            ★@else<span style="color: #ddd;">★</span>
                            @endif
                        @endfor
                    </div>
                </div>

                <!-- Comment Display -->
                @if ($rating->comment)
                    <div>
                        <p style="font-size: 14px; font-weight: 600;">{{ __('main.your_comment') }}:</p>
                        <div class="comment-box" style="border-color: var(--color-gray-200);">
                            {{ $rating->comment }}
                        </div>
                    </div>
                @endif
            @endif

            <p style="color: #28a745; font-weight: 500; text-align: center;">
                ✓ {{ __('main.rating_received') }}
            </p>

            <p style="color: #999; font-size: 13px; text-align: center;">
                {{ __('main.review_ticket_anytime') }}
            </p>

            <a href="{{ route('tickets.show', $ticket->uuid) }}"
                class="kt-btn kt-btn-outline-primary font-semibold rounded-full flex text-center justify-center w-fit"
                style="margin: 8px auto; text-decoration: none; padding: 10px 30px; background: #007bff; color: white; border: none; cursor: pointer;">
                {{ __('main.view_your_ticket') }}
            </a>

            <div>
                <p class="text-sm" style="font-size: 12px; line-height: 0.7; color: #999; margin-top: 12px;">{{ __('main.if_button_not_working') }}</p>
                <a href="{{ route('tickets.show', $ticket->uuid) }}" style="font-size: 10px; color: #2563eb; word-break: break-all;">
                    {{ route('tickets.show', $ticket->uuid) }}
                </a>
            </div>
        </div>
        <div class="kt-card-footer" style="font-size: 12px; border-color: var(--color-gray-200);">
            <p>{{ __('main.automated_email_notice') }}</p>
        </div>
    </div>
</body>

</html>
