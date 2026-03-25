@extends('dashboard.layout.master')

@section('title', __('main.account_activity'))

@include('profile._theme')

@section('content')
    <div class="profile-shell">
        <section class="profile-hero profile-animate">
            <div class="profile-hero-grid">
                <div>
                    <a href="{{ route('dashboard.profile.show') }}" class="profile-kicker"><i class="fas fa-arrow-left-long"></i> {{ __('main.back') }}</a>
                    <h1 class="profile-title">{{ __('main.account_activity') }}</h1>
                    <p class="profile-subtitle">{{ __('main.monitor_your_account_activity') }}</p>

                    <div class="profile-hero-actions">
                        <a href="{{ route('dashboard.profile.edit') }}" class="profile-action"><i class="fas fa-pen"></i>{{ __('main.edit_profile') }}</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline-flex">
                            @csrf
                            <button type="submit" class="profile-danger cursor-pointer"><i class="fas fa-right-from-bracket"></i>{{ __('main.logout') }}</button>
                        </form>
                    </div>
                </div>

                <div class="profile-side-card">
                    <div class="profile-mini-grid">
                        <div class="profile-mini-card">
                            <span>{{ __('main.joined_on') }}</span>
                            <strong>{{ $joinDate }}</strong>
                        </div>
                        <div class="profile-mini-card">
                            <span>{{ __('main.last_login') }}</span>
                            <strong>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : __('main.never') }}</strong>
                        </div>
                        <div class="profile-mini-card">
                            <span>{{ __('main.account_status') }}</span>
                            <strong>{{ $user->is_active ? __('main.active') : __('main.inactive') }}</strong>
                        </div>
                        <div class="profile-mini-card">
                            <span>{{ __('main.role') }}</span>
                            <strong>{{ __('main.' . strtolower($user->role)) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="profile-grid">
            <section class="profile-panel profile-animate profile-delay-1">
                <div class="profile-panel-head">
                    <div class="profile-panel-title">
                        <div class="profile-panel-icon"><i class="fas fa-timeline"></i></div>
                        <div>
                            <h3>{{ __('main.account_activity') }}</h3>
                            <p>{{ __('main.monitor_your_account_activity') }}</p>
                        </div>
                    </div>
                </div>

                <div class="profile-timeline">
                    <div class="profile-timeline-item">
                        <strong class="text-slate-900">{{ __('main.join_date') }}</strong>
                        <div class="text-slate-600 mt-1">{{ $user->created_at->format('M d, Y') }}</div>
                        <small class="text-slate-500">{{ $user->created_at->diffForHumans() }}</small>
                    </div>

                    <div class="profile-timeline-item">
                        <strong class="text-slate-900">{{ __('main.last_login') }}</strong>
                        <div class="text-slate-600 mt-1">
                            @if ($user->last_login_at)
                                {{ $user->last_login_at->format('M d, Y H:i:s') }}
                            @else
                                {{ __('main.never') }}
                            @endif
                        </div>
                        @if ($user->last_login_at)
                            <small class="text-slate-500">{{ $user->last_login_at->diffForHumans() }}</small>
                        @endif
                    </div>

                    <div class="profile-timeline-item">
                        <strong class="text-slate-900">{{ __('main.last_login_ip') }}</strong>
                        <div class="text-slate-600 mt-1">{{ $user->last_login_ip ?: '-' }}</div>
                        <small class="text-slate-500">{{ __('main.login_information') }}</small>
                    </div>

                    <div class="profile-timeline-item">
                        <strong class="text-slate-900">{{ __('main.password_changed') }}</strong>
                        <div class="text-slate-600 mt-1">
                            @if ($user->password_changed_at)
                                {{ $user->password_changed_at->format('M d, Y') }}
                            @else
                                {{ __('main.never') }}
                            @endif
                        </div>
                        <small class="text-slate-500">{{ __('main.security_recommendations') }}</small>
                    </div>
                </div>
            </section>

            <div class="flex flex-col gap-6">
                <section class="profile-panel profile-animate profile-delay-2">
                    <div class="profile-panel-head">
                        <div class="profile-panel-title">
                            <div class="profile-panel-icon"><i class="fas fa-circle-info"></i></div>
                            <div>
                                <h3>{{ __('main.account_information') }}</h3>
                                <p>{{ __('main.user_information') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="profile-list">
                        <div class="profile-list-item"><strong>{{ __('main.user_id') }}</strong><span>#{{ $user->id }}</span></div>
                        <div class="profile-list-item"><strong>{{ __('main.name') }}</strong><span>{{ $user->name }}</span></div>
                        <div class="profile-list-item"><strong>{{ __('main.email') }}</strong><a class="entity-contact-link" href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
                        <div class="profile-list-item"><strong>{{ __('main.role') }}</strong><span>{{ str_replace('_', ' ', $user->role) }}</span></div>
                    </div>
                </section>

                <section class="profile-security-list profile-animate profile-delay-3">
                    <div class="profile-panel-title mb-4">
                        <div class="profile-panel-icon"><i class="fas fa-shield-heart"></i></div>
                        <div>
                            <h4>{{ __('main.security_recommendations') }}</h4>
                            <p>{{ __('main.account_settings') }}</p>
                        </div>
                    </div>

                    <ul>
                        <li><i class="fas fa-check-circle text-emerald-600 mt-1"></i><span>{{ __('main.security_strong_password') }}</span></li>
                        <li><i class="fas fa-check-circle text-sky-600 mt-1"></i><span>{{ __('main.security_verify_email') }}</span></li>
                        <li><i class="fas fa-check-circle text-amber-600 mt-1"></i><span>{{ __('main.security_monitor_activity') }}</span></li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
@endsection
