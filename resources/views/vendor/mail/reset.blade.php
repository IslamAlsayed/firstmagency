@php
    $settings = (object) [
        'font_url' => 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap',
        'font_name' => 'Tajawal',
    ];
    $url = url(config('app.url') . route('password.reset', ['token' => $token, 'email' => $email], false));
@endphp
<!DOCTYPE html>
<html class="h-full" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('auth.reset_password') }}</title>
    <link href="{{ $settings->font_url }}" rel="stylesheet">
    <style>
        :root {
            --font-family: '{{ $settings->font_name }}', system-ui, -apple-system, Segoe UI, Aria !important;
        }

        * {
            font-family: var(--font-family) !important;
        }

        body {
            background: #f5f5f5;
            padding: 20px;
        }

        .kt-card {
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.07);
            border-radius: 18px;
            border: 1px solid #e5e7eb;
        }

        .kt-card-header,
        .kt-card-footer {
            padding: 18px 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .kt-card-footer {
            border-top: 1px solid #e5e7eb;
            border-bottom: none;
            color: #888;
        }

        .kt-card-body {
            padding: 24px;
        }

        .kt-btn {
            display: inline-block;
            padding: 10px 32px;
            background: #fff;
            color: #2563eb;
            border: 2px solid #2563eb;
            border-radius: 9999px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s, color 0.2s;
        }

        .kt-btn:hover {
            background: #2563eb;
            color: #fff;
        }

        .text-black {
            color: #222;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .font-semibold {
            font-weight: 600;
        }

        .w-fit {
            width: fit-content;
        }

        .flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
        }

        .gap-3 {
            gap: 0.75rem;
        }

        .text-center {
            text-align: center;
        }

        .justify-center {
            justify-content: center;
        }

        .p-4 {
            padding: 1rem;
        }
    </style>
</head>

<body>
    <div class="kt-card bg-white text-gray-500" style="max-width: 500px; margin: auto;">
        <div class="kt-card-header">
            <h2 class="font-semibold text-black" style="margin: 0;">{{ config('app.name') }}</h2>
        </div>
        <div class="kt-card-body flex flex-col gap-3">
            <h2 class="font-semibold text-black" style="margin: 0;">{{ __('auth.reset_password') }}</h2>
            <p>{{ __('auth.password_reset_email_intro') }}</p>
            <a href="{{ $url }}" class="kt-btn w-fit text-center justify-center">{{ __('auth.reset_password') }}</a>
            <div>
                <p class="text-sm" style="font-size: 12px; line-height: 0.7;">{{ __('main.if_button_not_working') }}</p>
                <a href="{{ $url }}" style="font-size: 10px; color: #2563eb; word-break: break-all;">{{ $url }}</a>
            </div>
            <p style="font-size: 12px; color: #888;">
                {{ __('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]) }}
            </p>
            <p style="font-size: 12px; color: #888;">
                {{ __('If you did not request a password reset, no further action is required.') }}
            </p>
        </div>
        <div class="kt-card-footer" style="font-size: 12px;">
            <p>{{ __('main.automated_email_notice') ?? 'This is an automated email, please do not reply.' }}</p>
        </div>
    </div>
</body>

</html>
