<!DOCTYPE html>
<html class="h-full" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

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

            --font-family: "{{ $settings->font_name ?? 'Tajawal' }}", system-ui, -apple-system, Segoe UI, Aria !important;
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

    <!-- Scripts -->
    @include('dashboard.layout.partials.scripts')
</body>

</html>
