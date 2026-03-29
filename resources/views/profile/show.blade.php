@extends('dashboard.layout.master')

@section('title', __('main.my_profile'))

@include('profile._theme')

@section('content')
    <div class="profile-shell">
        <section class="profile-hero profile-animate">
            <div class="profile-hero-grid">
                <div>
                    <span class="profile-kicker"><i class="fas fa-sparkles"></i> {{ __('main.my_profile') }}</span>
                    <h1 class="profile-title">{{ $user->name }}</h1>
                    <p class="profile-subtitle">{{ __('main.manage_your_profile') }}</p>

                    <div class="profile-hero-actions">
                        <a href="{{ route('dashboard.profile.edit') }}" class="profile-action">
                            <i class="fas fa-pen-to-square"></i>
                            {{ __('main.edit_profile') }}
                        </a>
                        <a href="{{ route('dashboard.profile.activity') }}" class="profile-action-secondary">
                            <i class="fas fa-chart-line"></i>
                            {{ __('main.view_activity') }}
                        </a>
                    </div>
                </div>

                <div class="profile-side-card">
                    <div class="profile-avatar-wrap">
                        @if ($user->photo && checkExistFile($user->photo))
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="profile-avatar">
                        @elseif ($user->photo)
                            <img src="{{ asset('assets/images/avatars/' . $user->photo) }}" alt="{{ $user->name }}" class="profile-avatar">
                        @else
                            <div class="profile-avatar-placeholder"><i class="fas fa-user"></i></div>
                        @endif

                        <div>
                            <div class="text-sm opacity-75">{{ __('main.account_status') }}</div>
                            <div class="text-xl font-black">{{ __('main.' . strtolower($user->role)) }}</div>
                            <span class="profile-badge">
                                <i class="fas {{ $user->is_active ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                {{ $user->is_active ? __('main.active') : __('main.inactive') }}
                            </span>
                        </div>
                    </div>

                    <div class="profile-mini-grid">
                        <div class="profile-mini-card">
                            <span>{{ __('main.join_date') }}</span>
                            <strong>{{ $user->created_at->format('M d, Y') }}</strong>
                        </div>
                        <div class="profile-mini-card">
                            <span>{{ __('main.last_login') }}</span>
                            <strong>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : __('main.never') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="profile-grid">
            <section class="profile-panel profile-animate profile-delay-1">
                <div class="profile-panel-head">
                    <div class="profile-panel-title">
                        <div class="profile-panel-icon"><i class="fas fa-id-card"></i></div>
                        <div>
                            <h2>{{ __('main.personal_information') }}</h2>
                            <p>{{ __('main.manage_your_profile') }}</p>
                        </div>
                    </div>
                </div>

                <div class="profile-info-grid">
                    <div class="profile-info-card">
                        <span>{{ __('main.name') }}</span>
                        <div class="profile-value">{{ ucfirst($user->name ?? '--') }}</div>
                    </div>
                    <div class="profile-info-card">
                        <span>{{ __('main.role') }}</span>
                        <div class="profile-value">{{ __('main.' . strtolower($user->role)) }}</div>
                    </div>
                    <div class="profile-info-card">
                        <span>{{ __('main.email') }}</span>
                        <div class="profile-value email">
                            <a href="mailto:{{ $user->email }}" class="entity-contact-link">{{ $user->email }}</a>
                        </div>
                    </div>
                    <div class="profile-info-card">
                        <span>{{ __('main.mobile') }}</span>
                        <div class="profile-value">
                            @if ($user->mobile)
                                <a href="tel:{{ $user->mobile }}" class="entity-contact-link">{{ $user->mobile }}</a>
                            @else
                                <span class="text-slate-400">{{ __('main.not_provided') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="profile-info-card">
                        <span>{{ __('main.phone') }}</span>
                        <div class="profile-value">
                            @if ($user->phone)
                                <a href="tel:{{ $user->phone }}" class="entity-contact-link">{{ $user->phone }}</a>
                            @else
                                <span class="text-slate-400">{{ __('main.not_provided') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="profile-info-card">
                        <span>{{ __('main.email_verified') }}</span>
                        <div class="profile-value">
                            <span class="profile-state-badge w-fit {{ $user->email_verified_at ? 'success' : 'warning' }}">
                                <i class="fas {{ $user->email_verified_at ? 'fa-circle-check' : 'fa-clock' }}"></i>
                                {{ $user->email_verified_at ? __('main.verified') : __('main.unverified') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="profile-rich-block">
                    <span class="block text-xs font-extrabold uppercase tracking-[0.18em] text-slate-400 mb-2">{{ __('main.address') }}</span>
                    @if ($user->address)
                        <div class="text-slate-900 font-semibold">{!! $user->address !!}</div>
                    @else
                        <div class="text-slate-400">{{ __('main.not_provided') }}</div>
                    @endif
                </div>

                @if ($user->bio)
                    <div class="profile-rich-block">
                        <span class="block text-xs font-extrabold uppercase tracking-[0.18em] text-slate-400 mb-2">{{ __('main.bio') }}</span>
                        <div class="prose prose-sm max-w-none text-slate-900">{!! $user->bio !!}</div>
                    </div>
                @endif
            </section>

            <div class="flex flex-col gap-6">
                <section class="profile-panel profile-animate profile-delay-2">
                    <div class="profile-panel-head">
                        <div class="profile-panel-title">
                            <div class="profile-panel-icon"><i class="fas fa-sliders"></i></div>
                            <div>
                                <h3>{{ __('main.account_settings') }}</h3>
                                <p>{{ __('main.update_your_password') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="profile-list">
                        <div class="profile-list-item">
                            <div>
                                <strong>{{ __('main.change_password') }}</strong>
                                <small>{{ __('main.update_your_password') }}</small>
                            </div>
                            <a href="{{ route('dashboard.profile.edit') . '#forget-password' }}" class="profile-action">{{ __('main.change') }}</a>
                        </div>

                        <div class="profile-list-item">
                            <div>
                                <strong>{{ __('main.language_preference') }}</strong>
                                <small>{{ __('main.select_your_preferred_language') }}</small>
                            </div>
                            <div class="profile-lang-list">
                                @foreach (config('languages') as $lang => $language)
                                    <a href="{{ route('locale.change', $lang) }}" class="profile-lang-chip {{ app()->getLocale() === $lang ? 'active' : '' }}">
                                        {{ app()->getLocale() == 'ar' ? $language['name_ar'] : $language['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                @if (getActiveUser()->can('dashboard-switch-account'))
                    <section class="profile-panel profile-animate profile-delay-3">
                        <div class="profile-panel-head">
                            <div class="profile-panel-title">
                                <div class="profile-panel-icon"><i class="ki-filled ki-arrow-right-left"></i></div>
                                <div>
                                    <h3>{{ __('messages.switch_to_anther_user') }}</h3>
                                    <p>{{ __('main.account_information') }}</p>
                                </div>
                            </div>
                        </div>
                        @include('dashboard.components.account-switcher', ['availableUsers' => $users])
                    </section>
                @endif
            </div>
        </div>
    </div>
@endsection
