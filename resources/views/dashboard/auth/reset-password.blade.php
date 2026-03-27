@extends('dashboard.auth.metronic')

@section('title', __('auth.reset_password'))

@push('styles')
    <style>
        .login-wrap {
            min-height: calc(100svh + 23px);
            padding: clamp(16px, 3vw, 34px);
            background:
                radial-gradient(1200px 580px at 100% 0%, rgba(245, 73, 0, 0.16), transparent 60%),
                radial-gradient(900px 420px at 0% 100%, rgba(0, 116, 247, 0.17), transparent 60%),
                linear-gradient(125deg, #f4f6fb 0%, #ffffff 40%, #f8fbff 100%);
            overflow: hidden;
            position: relative;
            isolation: isolate;
            top: -23px;
        }

        .dark .login-wrap {
            background:
                radial-gradient(1000px 520px at 100% 0%, rgba(245, 73, 0, 0.2), transparent 60%),
                radial-gradient(800px 420px at 0% 100%, rgba(0, 116, 247, 0.24), transparent 60%),
                linear-gradient(120deg, #0f1725 0%, #111827 45%, #141f32 100%);
        }

        .login-shell {
            width: min(1180px, 100%);
            min-height: min(560px, calc(100svh - 2 * clamp(16px, 3vw, 34px)));
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 20px 70px rgba(0, 0, 0, 0.13);
            backdrop-filter: blur(14px);
            overflow: hidden;
            animation: shellIn .7s cubic-bezier(0.2, 0.9, 0.2, 1) both;
        }

        .dark .login-shell {
            background: rgba(17, 24, 39, 0.7);
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 70px rgba(0, 0, 0, 0.42);
        }

        .login-panel {
            background:
                radial-gradient(500px 180px at 8% 100%, rgba(255, 255, 255, 0.16), transparent 70%),
                linear-gradient(145deg, #11223f 0%, #1f3661 44%, #1f5287 100%);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .login-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(255, 255, 255, 0.06) 1px, transparent 1px),
                linear-gradient(180deg, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
            background-size: 26px 26px;
            opacity: 0.24;
            mix-blend-mode: soft-light;
            pointer-events: none;
        }

        .login-badge {
            border: 1px solid rgba(255, 255, 255, 0.25);
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(6px);
        }

        .login-feature {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.08);
        }

        .login-form-col {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.84) 0%, rgba(255, 255, 255, 0.95) 100%);
        }

        .dark .login-form-col {
            background: linear-gradient(160deg, rgba(17, 24, 39, 0.72) 0%, rgba(15, 23, 37, 0.88) 100%);
        }

        .login-form {
            width: min(420px, 100%);
            animation: fadeRise .65s ease both;
            animation-delay: .08s;
        }

        .login-input {
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, 0.11);
            background: rgba(255, 255, 255, 0.9);
            transition: box-shadow .22s, border-color .22s, transform .22s;
        }

        .dark .login-input {
            border-color: rgba(255, 255, 255, 0.14);
            background: rgba(15, 23, 42, 0.56);
        }

        .login-input:focus-within {
            border-color: rgba(0, 116, 247, 0.55);
            box-shadow: 0 0 0 4px rgba(0, 116, 247, 0.13);
            transform: translateY(-1px);
        }

        .password-field {
            display: flex;
            align-items: center;
            padding-inline: 12px;
        }

        .password-field input {
            width: 100%;
            height: 48px;
            border: 0;
            outline: 0;
            background: transparent;
            color: inherit;
        }

        .password-toggle {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 0;
            outline: 0;
            background: transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color .2s ease;
        }

        .password-toggle:hover {
            background-color: rgba(0, 116, 247, 0.12);
        }

        .dark .password-toggle:hover {
            background-color: rgba(148, 163, 184, 0.18);
        }

        .password-toggle i {
            color: var(--muted-color, #94a3b8);
            font-size: 14px;
            pointer-events: none;
        }

        .login-submit {
            border-radius: 12px;
            min-height: 46px;
            transition: transform .2s, box-shadow .2s, filter .2s;
            box-shadow: 0 10px 24px rgba(0, 116, 247, 0.28);
        }

        .login-submit:hover {
            transform: translateY(-2px);
            filter: brightness(1.03);
            box-shadow: 0 13px 28px rgba(0, 116, 247, 0.33);
        }

        .stagger-in {
            animation: fadeRise .55s ease both;
        }

        .stagger-in:nth-child(1) {
            animation-delay: .02s;
        }

        .stagger-in:nth-child(2) {
            animation-delay: .1s;
        }

        .stagger-in:nth-child(3) {
            animation-delay: .16s;
        }

        .stagger-in:nth-child(4) {
            animation-delay: .2s;
        }

        .stagger-in:nth-child(5) {
            animation-delay: .24s;
        }

        @keyframes shellIn {
            from {
                opacity: 0;
                transform: translateY(16px) scale(0.985);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes fadeRise {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 1024px) {
            .login-shell {
                min-height: auto;
            }

            .login-panel {
                min-height: 280px;
            }
        }

        @media (max-width: 425px) {
            .login-wrap {
                align-items: start;
                min-height: calc(110svh + 30px);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .login-wrap::before,
            .login-wrap::after,
            .login-shell,
            .login-form,
            .stagger-in {
                animation: none !important;
            }
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
    <div class="login-wrap flex items-center justify-center">
        <div class="login-shell grid grid-cols-1 lg:grid-cols-2">
            <section class="login-panel p-8 lg:p-12 flex flex-col justify-between gap-8">
                <div class="space-y-4 stagger-in">
                    <span class="login-badge inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-[13px] font-medium">
                        <i class="ki-filled ki-lock text-[15px]"></i>
                        {{ __('auth.reset_password') }}
                    </span>
                    <h1 class="text-xl sm:text-2xl lg:text-4xl font-semibold leading-tight">
                        {{ __('auth.reset_password') }}
                    </h1>
                    <p class="text-xs sm:text-sm lg:text-base text-white/80 leading-relaxed max-w-xl">
                        {{ __('auth.create_new_secure_password') }}
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
                <form action="{{ route('password.store') }}" class="login-form flex flex-col gap-5" id="kt_new_password_form" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="stagger-in">
                        <h3 class="text-2xl font-semibold text-mono leading-tight mb-1">{{ __('auth.reset_password') }}</h3>
                        <p class="text-sm text-secondary-foreground">{{ __('auth.create_new_secure_password') }}</p>
                    </div>
                    <div class="flex flex-col gap-1 stagger-in">
                        <label class="kt-form-label font-normal text-mono">{{ __('auth.email_label') }}</label>
                        <input class="kt-input h-[48px] login-input" placeholder="e@e.com" type="email" name="email" autocomplete="off" value="{{ old('email', $request->email) }}" />
                        @error('email')
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block"><span role="alert">{{ $message }}</span></div>
                            </div>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1 stagger-in">
                        <label class="kt-form-label font-normal text-mono">{{ __('auth.new_password') }}</label>
                        <div class="h-[48px] login-input password-field">
                            <input id="resetPasswordInput" name="password" type="password" autocomplete="off" />
                            <button id="resetPasswordToggle" class="password-toggle" type="button" aria-label="{{ __('main.toggle_password_visibility') }}" aria-pressed="false">
                                <i id="resetPasswordIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block"><span role="alert">{{ $message }}</span></div>
                            </div>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1 stagger-in">
                        <label class="kt-form-label font-normal text-mono">{{ __('auth.confirm_new_password') }}</label>
                        <div class="h-[48px] login-input password-field">
                            <input id="resetPasswordConfirmationInput" name="password_confirmation" type="password" autocomplete="off" />
                            <button id="resetPasswordConfirmationToggle" class="password-toggle" type="button" aria-label="{{ __('main.toggle_password_visibility') }}" aria-pressed="false">
                                <i id="resetPasswordConfirmationIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block"><span role="alert">{{ $message }}</span></div>
                            </div>
                        @enderror
                    </div>
                    <button class="kt-btn kt-btn-primary login-submit flex justify-center grow stagger-in" type="submit">
                        {{ __('auth.reset_password') }}
                    </button>
                </form>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            [
                ['resetPasswordInput', 'resetPasswordToggle', 'resetPasswordIcon'],
                ['resetPasswordConfirmationInput', 'resetPasswordConfirmationToggle', 'resetPasswordConfirmationIcon']
            ].forEach(function(ids) {
                const input = document.getElementById(ids[0]);
                const toggle = document.getElementById(ids[1]);
                const icon = document.getElementById(ids[2]);

                if (!input || !toggle || !icon) {
                    return;
                }

                toggle.addEventListener('click', function() {
                    const isHidden = input.type == 'password';

                    input.type = isHidden ? 'text' : 'password';
                    toggle.setAttribute('aria-pressed', String(isHidden));
                    toggle.setAttribute('aria-label', isHidden ? @js(__('main.hide_password')) : @js(__('main.show_password')));
                    icon.classList.toggle('fa-eye', !isHidden);
                    icon.classList.toggle('fa-eye-slash', isHidden);
                });
            });
        });
    </script>
@endpush
