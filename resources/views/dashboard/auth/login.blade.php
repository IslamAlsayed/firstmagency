@extends('dashboard.auth.metronic')

@section('title', __('auth.login'))

@push('styles')
    <style>
        .page-bg {
            background-image: url(../assets/images/dashboard/bg-10.png);
        }

        .dark .page-bg {
            background-image: url(../assets/images/dashboard/bg-10-dark.png);
        }
    </style>
@endpush

@section('content')
    <!--begin::Authentication - Sign-in -->
    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg" style="height: 100svh">
        <div class="kt-card max-w-[370px] m-auto" style="width: calc(100% - 40px);">
            <form action="{{ route('login') }}" class="kt-card-content flex flex-col gap-5 p-6" id="kt_sign_in_form" method="post" autocomplete="off">
                @csrf
                <div class="text-center ">
                    <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                        {{ __('auth.sign_in') }}
                    </h3>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        {{ __('auth.email_label') }}
                    </label>
                    <input class="kt-input h-[45px]" placeholder="e@e.com" type="email" name="email" autocomplete="off" value="{{ old('email', 'superadmin@firstmagency.com') }}" list="emails" />
                    <datalist id="emails">
                        <option value="superadmin@firstmagency.com">
                        <option value="admin@firstmagency.com">
                        <option value="content@firstmagency.com">
                    </datalist>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between gap-1 disabled opacity-50">
                        <label class="kt-form-label font-normal text-mono">
                            {{ __('auth.password_label') }}
                        </label>
                        <a class="text-sm kt-link shrink-0" href="{{ route('password.request') }}">
                            {{ __('auth.forgot_password') }}
                        </a>
                    </div>
                    <div class="kt-input h-[45px]" data-kt-toggle-password="true">
                        <input name="password" type="password" value="{{ old('password', '12345678') }}" autocomplete="off" />
                        <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                            <span class="kt-toggle-password-active:hidden">
                                <i class="ki-filled ki-eye text-muted-foreground"></i>
                            </span>
                            <span class="hidden kt-toggle-password-active:block">
                                <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                            </span>
                        </button>
                    </div>
                </div>
                <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit" toggle-button>
                    {{ __('auth.sign_in') }}
                </button>
            </form>
        </div>
    </div>
    <!--end::Authentication - Sign-in-->
@endsection

@push('scripts')
    @if (session('session_expired'))
        <script>
            window.showToast({
                type: 'info',
                message: '{{ __('messages.session_expired ') }}',
            });
        </script>
    @endif
@endpush
