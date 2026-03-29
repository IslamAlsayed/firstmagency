<!DOCTYPE html>
<html class="h-full" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    @include('layouts.partials.head')
    @stack('styles')

    <style>
        #content {
            position: relative;
            top: -30px;
        }
    </style>
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
                    <a class="fixed-support-item flex items-center gap-2" href="{{ config('app.whatsapp_link', 'https://wa.me/201212601601') }}" target="_blank" rel="noopener">
                        <span class="fixed-support-image">
                            <img src="{{ config('app.support_images.sales', asset('assets/images/website/support/sales.png')) }}" alt="">
                        </span>
                        <span class="fixed-support-t">{{ __('main.fixed_support_contact_sales') }}</span>
                    </a>
                    <a class="fixed-support-item flex items-center gap-2" href="{{ route('tickets.index') }}" target="_blank" rel="noopener">
                        <span class="fixed-support-image">
                            <img src="{{ config('app.support_images.tickets', asset('assets/images/website/support/tickets.png')) }}" alt="">
                        </span>
                        <span class="fixed-support-t">{{ __('main.fixed_support_open_ticket') }}</span>
                    </a>
                    <a class="fixed-support-item flex items-center gap-2" href="{{ config('app.phone_link', 'tel:201212601601') }}" target="_blank" rel="noopener">
                        <span class="fixed-support-image">
                            <img src="{{ config('app.support_images.phone', asset('assets/images/website/support/phone.png')) }}" alt="">
                        </span>
                        <span class="fixed-support-t">{{ __('main.fixed_support_direct_call') }}</span>
                    </a>
                    <a class="fixed-support-item flex items-center gap-2" href="{{ config('app.client_portal_url', '#') }}" target="_blank" rel="noopener">
                        <span class="fixed-support-image">
                            <img src="{{ config('app.support_images.account', asset('assets/images/website/support/account.png')) }}" alt="">
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
