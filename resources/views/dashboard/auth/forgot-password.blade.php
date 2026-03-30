@extends('dashboard.auth.metronic')

@section('title', __('auth.password_recovery'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('dashboard/css/auth/forgot-password.css') }}">
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
    <div class="login-wrap flex items-center justify-center">
        <div class="login-shell grid grid-cols-1 lg:grid-cols-2">
            <section class="login-panel p-8 lg:p-12 flex flex-col justify-between gap-8">
                <div class="space-y-4 stagger-in">
                    <span class="login-badge inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-[13px] font-medium">
                        <i class="ki-filled ki-lock text-[15px]"></i>
                        {{ __('auth.password_recovery') }}
                    </span>
                    <h1 class="text-xl sm:text-2xl lg:text-4xl font-semibold leading-tight">
                        {{ __('auth.forgot_password') }}
                    </h1>
                    <p class="text-xs sm:text-sm lg:text-base text-white/80 leading-relaxed max-w-xl">
                        {{ __('auth.enter_email_to_reset') }}
                    </p>
                </div>
                <div class="stagger-in pt-2">
                    <a href="{{ route('locale.change', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                        class="inline-flex items-center gap-2 text-sm text-white/80 hover:text-white transition-colors duration-200">
                        <i class="ki-filled ki-language text-[15px]"></i>
                        <span>{{ app()->getLocale() == 'ar' ? config('languages.en.name') : config('languages.ar.name_ar') }}</span>
                    </a>
                </div>
            </section>
            <section class="login-form-col flex items-center justify-center p-6 lg:p-12">
                <form action="{{ route('password.email') }}" class="login-form flex flex-col gap-5" id="kt_password_reset_form" method="post" autocomplete="off">
                    @csrf
                    <div class="stagger-in">
                        <h3 class="text-2xl font-semibold text-mono leading-tight mb-1">{{ __('auth.password_recovery') }}</h3>
                        <p class="text-sm text-secondary-foreground">{{ __('auth.enter_email_to_reset') }}</p>
                    </div>
                    <div class="flex flex-col gap-1 stagger-in">
                        <label class="kt-form-label font-normal text-mono">{{ __('auth.email_label') }}</label>
                        <input class="kt-input h-[48px] login-input" placeholder="e@e.com" type="email" name="email" autocomplete="off" value="{{ old('email') }}" />
                    </div>
                    <button class="kt-btn kt-btn-primary login-submit flex justify-center grow stagger-in" type="submit">
                        {{ __('auth.send') }}
                    </button>
                </form>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
