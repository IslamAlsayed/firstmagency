@extends('dashboard.layout.master')

@section('title', __('main.dashboard'))
@section('page-title', '🏠 ' . __('main.dashboard'))

@push('styles')
    <style>
        @media (max-width: 768px) {
            .welcome-header {
                padding: 20px;

                h1 {
                    font-size: 20px;
                }

                p {
                    font-size: 14px;
                }

                i,
                svg {
                    width: 40px;
                }
            }
        }
    </style>
@endpush

@section('content')
    <!-- Header Section -->
    <div class="mb-8">
        <div class="welcome-header rounded-[15px] shadow-xl p-8 text-white"
            style="background: linear-gradient({{ getActiveUser()->dashboard_locale == 'en' ? '135deg' : '225deg' }}, var(--primary) 0%, #5e5d5d 100%)">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">{{ __('main.welcome') }}, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-indigo-100 text-lg">{{ __('main.dashboard') }} - {{ now()->format('l, d F Y') }}</p>
                </div>
                <div class="text-6xl opacity-20">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <!-- System Overview Cards (Top Row) -->
        <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <a href="{{ route('dashboard.users.index') }}" class="text-primary text-sm font-semibold uppercase tracking-wide">
                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                        {{ __('main.total_users') }}
                    </a>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
                <div class="bg-primary rounded-lg p-3 text-white shadow-lg group-hover:bg-blue-600 transition-all">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 text-primary text-xs font-semibold">
                <span class="w-fit bg-blue-100 px-2 py-1 rounded-full">
                    {{ $stats['superadmins'] }} {{ __('main.superadmins') }}
                </span>
                <span class="w-fit bg-blue-100 px-2 py-1 rounded-full">
                    {{ $stats['admins'] }} {{ __('main.admins') }}
                </span>
                <span class="w-fit bg-blue-100 px-2 py-1 rounded-full">
                    {{ $stats['content_managers'] }} {{ __('main.content_managers') }}
                </span>
            </div>
        </div>

        <!-- Articles -->
        <div class="group bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <a href="{{ route('dashboard.articles.index') }}" class="text-primary text-sm font-semibold uppercase tracking-wide">
                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                        {{ __('main.articles') }}
                    </a>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $contentStats['articles']['total'] ?? 0 }}</p>
                </div>
                <div class="bg-primary rounded-lg p-3 text-white shadow-lg group-hover:bg-purple-600 transition-all">
                    <i class="fas fa-newspaper text-2xl"></i>
                </div>
            </div>
            <div class="flex gap-2 text-xs">
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full font-semibold">📤 {{ $contentStats['articles']['published'] ?? 0 }}</span>
                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-semibold">📝 {{ $contentStats['articles']['draft'] ?? 0 }}</span>
            </div>
        </div>

        <!-- Projects -->
        <div class="group bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <a href="{{ route('dashboard.projects.index') }}" class="text-primary text-sm font-semibold uppercase tracking-wide">
                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                        {{ __('main.projects') }}
                    </a>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ $contentStats['projects']['total'] ?? 0 }}</p>
                </div>
                <div class="bg-primary rounded-lg p-3 text-white shadow-lg group-hover:bg-green-600 transition-all">
                    <i class="fas fa-project-diagram text-2xl"></i>
                </div>
            </div>
            <div class="text-primary text-xs font-semibold">
                <span class="bg-green-100 px-2 py-1 rounded-full">✅ {{ $contentStats['projects']['active'] ?? 0 }} {{ __('main.active') }}</span>
            </div>
        </div>

        <!-- Tickets -->
        <div class="group bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <a href="{{ route('dashboard.tickets.index') }}" class="text-primary text-sm font-semibold uppercase tracking-wide">
                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                        {{ __('main.tickets') }}
                    </a>
                    <p class="text-4xl font-bold text-gray-800 mt-2 tickets-count">{{ $supportStats['tickets']['total'] ?? 0 }}</p>
                </div>
                <div class="bg-primary rounded-lg p-3 text-white shadow-lg group-hover:bg-amber-600 transition-all">
                    <i class="fas fa-ticket-alt text-2xl"></i>
                </div>
            </div>
            <div class="flex gap-2 text-xs">
                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full font-semibold">🔴 {{ $supportStats['tickets']['open'] ?? 0 }}</span>
                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-semibold">⏳ {{ $supportStats['tickets']['in_progress'] ?? 0 }}</span>
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full font-semibold">✅ {{ $supportStats['tickets']['closed'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Secondary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Reviews & Ratings -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                <div class="bg-primary rounded-lg p-3 text-white">
                    <i class="fas fa-star text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        <a href="{{ route('dashboard.users.index') }}">
                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                            {{ __('main.reviews') }}
                        </a>
                    </h3>
                    <p class="text-xs text-gray-500">{{ __('main.customer_feedback') }}</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-primary text-sm">{{ __('main.total_reviews') }}</span>
                    <span class="text-2xl font-bold text-gray-800">{{ $supportStats['reviews']['total'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-primary text-sm">{{ __('main.approved') }} ✓</span>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $supportStats['reviews']['approved'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-primary text-sm">{{ __('main.pending_review') }}</span>
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $supportStats['reviews']['pending'] ?? 0 }}</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <span class="text-primary text-sm font-semibold">{{ __('main.avg_rating') }}</span>
                        <div class="flex items-center gap-1">
                            @php
                                $avgRating = round($supportStats['reviews']['average_rate'], 1);
                            @endphp
                            <span class="text-2xl font-bold text-yellow-500">{{ $avgRating }}</span>
                            <div class="flex">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $avgRating)
                                        <i class="fas fa-star text-yellow-400"></i>
                                    @else
                                        <i class="far fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                <div class="bg-primary rounded-lg p-3 text-white">
                    <i class="fas fa-cogs text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        <a href="{{ route('dashboard.services.index') }}">
                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                            {{ __('main.services') }}
                        </a>
                    </h3>
                    <p class="text-xs text-gray-500">{{ __('main.service_management') }}</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-primary text-sm">{{ __('main.total_services') }}</span>
                    <span class="text-2xl font-bold text-gray-800">{{ $contentStats['services']['total'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-primary text-sm">{{ __('main.active') }}</span>
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $contentStats['services']['active'] ?? 0 }}</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                    <p class="text-2xl font-bold text-gradient bg-gradient-to-r from-cyan-500 to-blue-500 bg-clip-text text-transparent">
                        {{ $contentStats['services']['total'] > 0 ? '🟢 ' . __('main.active') : '🔴 ' . __('main.no_services') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Clients & Business -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                <div class="bg-primary rounded-lg p-3 text-white">
                    <i class="fas fa-handshake text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        <a href="{{ route('dashboard.clients.index') }}">
                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                            {{ __('main.clients') }}
                        </a>
                    </h3>
                    <p class="text-xs text-gray-500">{{ __('main.client_network') }}</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-primary text-sm">{{ __('main.total_clients') }}</span>
                    <span class="text-2xl font-bold text-gray-800">{{ $businessStats['clients']['total'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-primary text-sm">{{ __('main.active') }}</span>
                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $businessStats['clients']['active'] ?? 0 }}</span>
                </div>
                <div class="mt-6">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        @php
                            $activePercent = $businessStats['clients']['total'] > 0 ? ($businessStats['clients']['active'] / $businessStats['clients']['total']) * 100 : 0;
                        @endphp
                        <div class="bg-green-600 h-2 rounded-full transition-all duration-500" style="width: {{ $activePercent }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">{{ round($activePercent) }}% {{ __('main.active') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Footer -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- System Status -->
        <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-server text-green-600 text-lg"></i>
                    {{ __('main.system_status') }}
                </h4>
                <span class="w-3 h-3 bg-green-600 rounded-full animate-pulse"></span>
            </div>
            <p class="text-sm text-gray-600 font-semibold">{{ __('main.system_online') }}</p>
            <p class="text-xs text-gray-500 mt-2">✓ {{ __('main.all_systems_operational') }}</p>
        </div>

        <!-- Database Status -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-database text-primary text-lg"></i>
                    {{ __('main.database_status') }}
                </h4>
                <span class="w-3 h-3 bg-blue-600 rounded-full animate-pulse"></span>
            </div>
            <p class="text-sm text-gray-600 font-semibold">{{ __('main.database_connected') }}</p>
            <p class="text-xs text-gray-500 mt-2">✓ {{ __('main.sync_complete') }}</p>
        </div>

        <!-- Last Update -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-sync-alt text-purple-600"></i>
                    {{ __('main.last_update') }}
                </h4>
            </div>
            <p class="text-sm text-gray-600">{{ now()->format('H:i A') }}</p>
            <p class="text-xs text-gray-500 mt-2">{{ now()->format('d M Y') }}</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize Ably for real-time ticket updates
        const ablyKey = '{{ config('app.ably_key') }}';
        if (typeof Ably === 'undefined' || !ablyKey) {
            console.warn('Ably is not available or ABLY_KEY is missing.');
            return;
        }

        const ticketUpdates = new Ably.Realtime({
            key: ablyKey,
            logLevel: 1
        });

        // Subscribe to ticket deletion events
        const ticketUpdatesChannel = ticketUpdates.channels.get('ticket-updates');
        ticketUpdatesChannel.subscribe('tickets-count', (message) => {
            const data = message.data;
            let ticketsCount = document.querySelector('.tickets-count');
            ticketsCount.textContent = data.tickets_count;
        });
    </script>
@endpush
