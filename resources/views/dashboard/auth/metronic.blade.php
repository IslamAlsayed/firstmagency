<!DOCTYPE html>
<html class="h-full" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    @include('layouts.partials.head')
    @vite('resources/css/app.css')
    @stack('styles')

    {{-- FontAwesome Icons --}}
    <link rel="stylesheet" href="{{ asset('vendor/toasts/css/all.min.css') }}">
    {{-- Toasts Styles --}}
    <link rel="stylesheet" href="{{ asset('vendor/toasts/css/toasts.css') }}">
    {{-- Toasts Scripts --}}
    <script type="module" src="{{ asset('vendor/toasts/js/toasts.js') }}"></script>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">
    <style>
        :root {
            --dash_primary_color: {{ $settings->colors['dash_primary_color'] ?? '#0074F7' }};
            --text_color: {{ $settings->colors['text_color'] ?? '#ffffff' }};
            --icon_color: {{ $settings->colors['icon_color'] ?? '#4a5565' }};
            --button_color: {{ $settings->colors['button_color'] ?? '#0074F7' }};

            --font-family: "{{ $settings->font_name ?? 'Tajawal' }}";
        }
    </style>
    <style>
        #kt_theme_mode_menu {
            width: fit-content;
            position: fixed;
            top: 50px;
            right: 50px;
            color: White;
        }

        html.light {
            #kt_theme_mode_menu {
                color: Black;
            }
        }
    </style>
</head>

<body id="kt_app_body" class="app-default">
    @if (view()->exists('vendor/toasts/toasts'))
        @include('vendor.toasts.toasts')
    @endif

    {{-- <div id="kt_theme_mode_menu">
        <div class="flex items-center justify-between gap-2">
            <span class="flex items-center gap-2">
                <i class="text-base ki-filled ki-moon text-gray-600" id="icon-theme-mode"></i>
                <span class="font-medium text-2sm text-gray-600" id="text-theme-mode">
                    {{ __('main.dark_mode') }}
                </span>
            </span>
            <input class="kt-switch" id="switch-theme-mode" type="checkbox" value="1" />
        </div>
    </div> --}}

    @yield('content')

    @include('layouts.partials.scripts')
    @vite('resources/js/app.js')
    {{-- Theme Mode --}}
    @include('dashboard.components.script-theme')
</body>

</html>
