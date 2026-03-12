<!DOCTYPE html>
<html class="h-full" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    @include('layouts.partials.head')
    @stack('styles')
</head>

<body>
    @if (view()->exists('vendor/toasts/toasts'))
        @include('vendor.toasts.toasts')
    @endif

    <!-- Wrapper -->
    <div class="kt-wrapper flex grow flex-col">
        @include('layouts.header')

        <!-- Content -->
        <main class="grow" id="content" role="content">
            @yield('content')
        </main>
        <!-- End of Content -->

        @include('layouts.footer')
    </div>
    <!-- End of Wrapper -->

    <div id="imageViewer" class="image-viewer">
        <img id="viewerImg">
    </div>

    <!-- Scripts -->
    @include('layouts.partials.scripts')
</body>

</html>
