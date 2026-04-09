<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_rating') }}</title>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">
    <style>
        :root {
            --font-family: "{{ $settings->font_name ?? 'Tajawal' }}", system-ui, -apple-system, Segoe UI, Aria !important;
        }

        * {
            font-family: var(--font-family) !important;
        }
    </style>

    <!-- Tailwind CSS -->
    <link href="{{ asset('assets/plugins/tailwind/tailwind.css') }}" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="kt-card bg-white text-gray-500" style="max-width: 500px; margin: auto; border-color: var(--color-gray-200);">
        <div class="p-4">
            <h2 class="font-semibold mb-3">{{ __('main.invalid_rating_link') }}</h2>
            <p class="text-gray-600 mb-3">{{ __('main.invalid_rating_description') }}</p>
            <a href="{{ route('tickets.inquiry') }}" class="kt-btn kt-btn-outline-primary rounded-full font-semibold" toggle-button>
                <i class="fas fa-arrow-left"></i> {{ __('main.back_to_inquiry') }}
            </a>
        </div>
    </div>
</body>

</html>
