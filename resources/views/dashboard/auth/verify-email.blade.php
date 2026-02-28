@extends('layouts.metronic')

@section('title', __('auth.verify_email'))

@push('styles')
    <style>
        .page-bg {
            background-image: url('assets/dashboard/mediaimages/2600x1200/bg-10.png');
        }

        .dark .page-bg {
            background-image: url('assets/dashboard/mediaimages/2600x1200/bg-10-dark.png');
        }
    </style>
@endpush

@push('scripts')
    <!-- Google tag (gtag.js) -->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-52YZ3XGZJ6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-52YZ3XGZJ6');
    </script>

    <!-- Theme Mode -->
    <script>
        const defaultThemeMode = 'light'; // light|dark|system
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) {
                themeMode = localStorage.getItem('kt-theme');
            } else if (
                document.documentElement.hasAttribute('data-kt-theme-mode')
            ) {
                themeMode =
                    document.documentElement.getAttribute('data-kt-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ?
                    'dark' :
                    'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>
    <!-- End of Theme Mode -->
@endpush

@section('content')
    <!--begin::Authentication - Verify Email -->
    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg" style="height: 100svh">
        <div class="kt-card max-w-[440px] w-full">
            <form action="{{ route('password.email') }}" class="kt-card-content flex flex-col gap-5 p-10" id="kt_password_reset_form" method="post">
                <div class="flex justify-center py-10">
                    <img alt="image" class="dark:hidden max-h-[130px]" src="{{ asset('assets/dashboard/media/illustrations/30.svg') }}" />
                    <img alt="image" class="light:hidden max-h-[130px]" src="{{ asset('assets/dashboard/media/illustrations/30-dark.svg') }}" />
                </div>
                <h3 class="text-lg font-medium text-mono text-center mb-3">
                    {{ __('auth.check_your_email') }}
                </h3>
                <div class="text-sm text-center text-secondary-foreground">
                    {{ __('auth.click_link_sent') }}
                    <a class="text-sm text-foreground font-medium text-primary" href="#">
                        {{ $request->user()->email }}
                    </a>
                    <br />
                    {{ __('auth.to_reset_password') }}
                </div>
                {{-- <div class="flex justify-center">
                    <a class="kt-btn kt-btn-primary flex justify-center"
                        href="/metronic/tailwind/demo1/authentication/branded/reset-password/change-password/">
                        Skip for now
                    </a>
                </div> --}}
                <div class="flex items-center justify-center gap-1">
                    <span class="text-xs text-secondary-foreground">
                        {{ __('auth.didnt_receive_email') }}
                    </span>
                    <a class="text-xs font-medium link" href="{{ route('password.request') }}">
                        {{ __('auth.resend') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
    <!--end::Authentication - Verify Email-->
@endsection

@push('scripts')
@endpush
