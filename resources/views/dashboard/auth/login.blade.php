@extends('dashboard.auth.metronic')

@section('title', __('auth.login'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/auth/login.css') }}">
@endpush

@section('content')
    <div class="login-wrap flex items-center justify-center">
        <div class="login-shell grid grid-cols-1 lg:grid-cols-2">
            <section class="login-panel p-8 lg:p-12 flex flex-col justify-between gap-8">
                <div class="space-y-4 stagger-in">
                    <span class="login-badge inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-[13px] font-medium">
                        <i class="ki-filled ki-security-user text-[15px]"></i>
                        {{ __('main.login_dashboard_badge') }}
                    </span>
                    <h1 class="text-xl sm:text-2xl lg:text-4xl font-semibold leading-tight">
                        {{ __('main.login_hero_title') }}
                    </h1>
                    <p class="text-xs sm:text-sm lg:text-base text-white/80 leading-relaxed max-w-xl">
                        {{ __('main.login_hero_description') }}
                    </p>
                </div>

                <div class="grid gap-3 text-xs sm:text-sm">
                    <div class="login-feature stagger-in rounded-xl px-4 py-3 flex items-center gap-3">
                        <i class="ki-filled ki-chart-line-up fs-4"></i>
                        <span>{{ __('main.login_feature_analytics') }}</span>
                    </div>
                    <div class="login-feature stagger-in rounded-xl px-4 py-3 flex items-center gap-3">
                        <i class="ki-filled ki-message-text-2 fs-4"></i>
                        <span>{{ __('main.login_feature_tickets') }}</span>
                    </div>
                    <div class="login-feature stagger-in rounded-xl px-4 py-3 flex items-center gap-3">
                        <i class="ki-filled ki-verify fs-4"></i>
                        <span>{{ __('main.login_feature_security') }}</span>
                    </div>
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
                <form action="{{ route('login') }}" class="login-form flex flex-col gap-5" id="kt_sign_in_form" method="post">
                    @csrf

                    <div class="stagger-in">
                        <h3 class="text-2xl font-semibold text-mono leading-tight mb-1">{{ __('auth.sign_in') }}</h3>
                        <p class="text-sm text-secondary-foreground">{{ __('main.login_form_description') }}</p>
                    </div>

                    <div class="flex flex-col gap-1 stagger-in">
                        <label class="kt-form-label font-normal text-mono mb-1">{{ __('auth.email_label') }}</label>
                        <input class="kt-input h-[48px] login-input" placeholder="e@e.com" type="email" name="email" value="{{ old('email') }}" list="emails" />
                        <datalist id="emails">
                            <option value="info@firstmagency.com">
                                {{-- @foreach (\App\Models\User::get('email') as $email) --}}
                                {{-- <option value="{{ $email->email }}"> --}}
                                {{-- @endforeach --}}
                        </datalist>
                    </div>

                    <div class="flex flex-col gap-1 stagger-in">
                        <div class="flex items-center justify-between gap-1 disabled opacity-50 mb-1">
                            <label class="kt-form-label font-normal text-mono">{{ __('auth.password_label') }}</label>
                            <a class="text-sm kt-link shrink-0" href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
                        </div>
                        <div class="h-[48px] login-input password-field">
                            <input id="loginPasswordInput" name="password" type="password" value="{{ old('password') }}" />
                            <button id="loginPasswordToggle" class="password-toggle" type="button" aria-label="{{ __('main.toggle_password_visibility') }}" aria-pressed="false">
                                <i id="loginPasswordIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button class="kt-btn kt-btn-primary login-submit flex justify-center grow stagger-in" type="submit" toggle-button
                        style="color: var(--text_color); background-color: var(--button_color);">
                        {{ __('auth.sign_in') }}
                    </button>
                </form>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('loginPasswordInput');
            const passwordToggle = document.getElementById('loginPasswordToggle');
            const passwordIcon = document.getElementById('loginPasswordIcon');

            if (!passwordInput || !passwordToggle || !passwordIcon) {
                return;
            }

            passwordToggle.addEventListener('click', function() {
                const isHidden = passwordInput.type == 'password';

                passwordInput.type = isHidden ? 'text' : 'password';
                passwordToggle.setAttribute('aria-pressed', String(isHidden));
                passwordToggle.setAttribute('aria-label', isHidden ? @js(__('main.hide_password')) : @js(__('main.show_password')));

                passwordIcon.classList.toggle('fa-eye', !isHidden);
                passwordIcon.classList.toggle('fa-eye-slash', isHidden);
            });
        });
    </script>

    @if (session('session_expired'))
        <script>
            window.showToast({
                type: 'info',
                message: '{{ __('messages.session_expired') }}',
            });
        </script>
    @endif
@endpush
