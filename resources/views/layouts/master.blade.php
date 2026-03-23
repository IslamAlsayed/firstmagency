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

    <div id="fixed-support" class="fixed-support">
        <div id="open-fixed-support" class="headphones flex items-center justify-center gap-4">
            <i class="fas fa-headphones icon"></i>
            <span class="font-semibold">{{ __('main.contact_button') }}</span>
        </div>

        <div id="fixed-support-content" class="fixed-support-content font-semibold hidden" style="width: 360px">
            <div class="fixed-support-header flex items-center justify-between gap-4">
                <span>{{ __('main.fixed_support_title') }}</span>
                <button id="close-fixed-support" class="cursor-pointer">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            <div class="fixed-support-body">
                <div class="fixed-support-welcome">{{ __('main.fixed_support_welcome') }}</div>
                <div class="fixed-support-title">{{ __('main.fixed_support_choose_methods') }}</div>
                <div class="fixed-support-list">
                    <a class="fixed-support-item flex items-center gap-2" href="https://wa.me/201212601601" target="_blank" rel="noopener">
                        <span class="fixed-support-image">
                            <img src="https://firstmagency.com/wp-content/uploads/2025/08/4782351.png" alt="">
                        </span>
                        <span class="fixed-support-t">{{ __('main.fixed_support_contact_sales') }}</span>
                    </a>
                    <a class="fixed-support-item flex items-center gap-2" href="{{ route('tickets.index') }}" target="_blank" rel="noopener"
                        href="https://firstmagency.com/%d8%a7%d9%84%d8%a3%d8%aa%d8%b5%d9%80%d9%80%d9%80%d8%a7%d9%84-%d8%a8%d9%86%d8%a7/" target="_blank" rel="noopener">
                        <span class="fixed-support-image">
                            <img src="https://firstmagency.com/wp-content/uploads/2025/08/724715.png" alt="">
                        </span>
                        <span class="fixed-support-t">{{ __('main.fixed_support_open_ticket') }}</span>
                    </a>
                    <a class="fixed-support-item flex items-center gap-2" href="tel:201212601601" target="_blank" rel="noopener" href="tel:201212601601" target="_blank" rel="noopener">
                        <span class="fixed-support-image">
                            <img src="https://firstmagency.com/wp-content/uploads/2025/08/9999340.png" alt="">
                        </span>
                        <span class="fixed-support-t">{{ __('main.fixed_support_direct_call') }}</span>
                    </a>
                    <a class="fixed-support-item flex items-center gap-2" href="https://client.firstmagency.com" target="_blank" rel="noopener" href="https://client.firstmagency.com/" target="_blank"
                        rel="noopener">
                        <span class="fixed-support-image">
                            <img src="https://firstmagency.com/wp-content/uploads/2025/08/3437393.png" alt="">
                        </span>
                        <span class="fixed-support-t">{{ __('main.fixed_support_manage_account') }}</span>
                    </a>
                </div>
            </div>
            <div class="fixed-support-footer flex items-center justify-between gap-4">
                <span id="remaining-time">{{ __('main.fixed_support_remaining_time') }}: 00:00</span>
                <span class="status"></span>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @include('layouts.partials.scripts')
</body>

</html>
