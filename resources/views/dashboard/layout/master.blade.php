<!DOCTYPE html>
<html class="h-full" dir="{{ session('dashboard_locale', 'ar') == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ session('dashboard_locale', 'ar') }}">

<head>
    @include('dashboard.layout.partials.head')
    @stack('styles')

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
</head>

<body>
    @if (view()->exists('vendor/toasts/toasts'))
        @include('vendor.toasts.toasts')
    @endif

    <!-- Page -->
    <div class="dashboard-container">
        @include('dashboard.layout.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            @include('dashboard.layout.topbar')

            <div class="p-6">
                <!-- Page Content -->
                @yield('content')
            </div>
        </main>
    </div>

    <div id="imageViewer" class="image-viewer">
        <img id="viewerImg">
    </div>

    <!-- Scripts -->
    @include('dashboard.layout.partials.scripts')
    @include('dashboard.components.delete-ajax-script')
</body>

</html>
