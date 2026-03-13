<!DOCTYPE html>
<html class="h-full" dir="{{ session('dashboard_locale', 'ar') == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ session('dashboard_locale', 'ar') }}">

<head>
    @include('dashboard.layout.partials.head')
    @stack('styles')

    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}"
        rel="stylesheet">
    <style>
        :root {
            --primary: {{ $settings->primary_color ?? '#6f42c1' }};
            --secondary: {{ $settings->secondary_color ?? '#6c757d' }};
            --success: {{ $settings->success_color ?? '#198754' }};
            --danger: {{ $settings->danger_color ?? '#dc3545' }};
            --warning: {{ $settings->warning_color ?? '#ffc107' }};
            --info: {{ $settings->info_color ?? '#0dcaf0' }};
            --accent-color: {{ $settings->accent_color ?? '#dc3545' }};
            --header-color: {{ $settings->header_color ?? '#ffffff' }};
            --header-text-color: {{ $settings->header_text_color ?? '#f7f7f7' }};
            --footer-color: {{ $settings->footer_color ?? '#2d3748' }};

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

            <div class="p-4">
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
