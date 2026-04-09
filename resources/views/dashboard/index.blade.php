@extends('dashboard.layout.master')

@section('title', __('main.dashboard'))
@section('page-title', '🏠 ' . __('main.dashboard'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@push('styles')
    <style>
        .dashboard-hero {
            background:
                radial-gradient(circle at top right, #d05423, transparent 24%),
                linear-gradient({{ app()->getLocale() == 'en' ? '135deg' : '225deg' }}, #96310e 0%, #f97316 100%);
        }
    </style>
@endpush

@section('content')
    @php
        $articlesPublishedPercent = ($contentStats['articles']['total'] ?? 0) > 0 ? (($contentStats['articles']['published'] ?? 0) / $contentStats['articles']['total']) * 100 : 0;
        $projectsActivePercent = ($contentStats['projects']['total'] ?? 0) > 0 ? (($contentStats['projects']['active'] ?? 0) / $contentStats['projects']['total']) * 100 : 0;
        $servicesActivePercent = ($contentStats['services']['total'] ?? 0) > 0 ? (($contentStats['services']['active'] ?? 0) / $contentStats['services']['total']) * 100 : 0;
        $clientsActivePercent = ($businessStats['clients']['total'] ?? 0) > 0 ? (($businessStats['clients']['active'] ?? 0) / $businessStats['clients']['total']) * 100 : 0;
        $ticketsOpenPercent = ($supportStats['tickets']['total'] ?? 0) > 0 ? (($supportStats['tickets']['open'] ?? 0) / $supportStats['tickets']['total']) * 100 : 0;
        $avgRating = round($supportStats['reviews']['average_rate'] ?? 0, 1);
    @endphp

    <div class="dashboard-home">
        <section class="dashboard-hero">
            <div class="dashboard-hero-grid">
                <div>
                    <span class="hero-kicker">
                        <i class="fas fa-sparkles"></i>
                        {{ __('main.dashboard') }}
                    </span>

                    <h1 class="hero-title">{{ __('main.welcome') }}, {{ auth()->user()->name }}</h1>
                    <p class="hero-subtitle">{{ __('main.dashboard') }} - {{ now()->format('l, d F Y') }}</p>

                    <div class="quick-actions">
                        @can('tickets-create')
                            <a href="{{ route('dashboard.tickets.create') }}" class="quick-action">
                                <i class="fas fa-ticket-alt"></i>
                                {{ __('main.create_type', ['type' => __('main.ticket')]) }}
                            </a>
                        @endcan
                        @can('articles-create')
                            <a href="{{ route('dashboard.articles.create') }}" class="quick-action">
                                <i class="fas fa-newspaper"></i>
                                {{ __('main.create_type', ['type' => __('main.article')]) }}
                            </a>
                        @endcan
                        @can('projects-create')
                            <a href="{{ route('dashboard.projects.create') }}" class="quick-action">
                                <i class="fas fa-project-diagram"></i>
                                {{ __('main.create_type', ['type' => __('main.project')]) }}
                            </a>
                        @endcan
                        @can('services-create')
                            <a href="{{ route('dashboard.services.create') }}" class="quick-action">
                                <i class="fas fa-cogs"></i>
                                {{ __('main.create_type', ['type' => __('main.service')]) }}
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="hero-focus-card">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-bold text-white/85">{{ __('main.settings_quick_add') }}</p>
                            <p class="text-xs text-white/70">{{ __('main.last_update') }}: {{ now()->format('H:i A') }}</p>
                        </div>
                        <div class="text-4xl text-white/20">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>

                    <div class="hero-focus-grid">
                        <div class="hero-focus-item">
                            <strong>{{ $supportStats['tickets']['open'] ?? 0 }}</strong>
                            <span class="text-sm text-white/80">{{ __('main.open') }} {{ __('main.tickets') }}</span>
                        </div>
                        <div class="hero-focus-item">
                            <strong>{{ $supportStats['reviews']['pending'] ?? 0 }}</strong>
                            <span class="text-sm text-white/80">{{ __('main.pending_review') }}</span>
                        </div>
                        <div class="hero-focus-item">
                            <strong>{{ $contentStats['articles']['draft'] ?? 0 }}</strong>
                            <span class="text-sm text-white/80">{{ __('main.draft') }} {{ __('main.articles') }}</span>
                        </div>
                        <div class="hero-focus-item">
                            <strong>{{ $businessStats['clients']['active'] ?? 0 }}</strong>
                            <span class="text-sm text-white/80">{{ __('main.active') }} {{ __('main.clients') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="dashboard-kpis">
            <article class="dashboard-kpi" style="--accent: #2563eb;">
                <div class="kpi-meta">
                    <div>
                        <div class="kpi-label">{{ __('main.total_users') }}</div>
                        <div class="kpi-value">{{ $stats['total_users'] ?? 0 }}</div>
                    </div>
                    <span class="kpi-icon"><i class="fas fa-users"></i></span>
                </div>
                <div class="kpi-note">
                    <span class="kpi-chip">{{ $stats['superadmins'] ?? 0 }} {{ __('main.superadmins') }}</span>
                    <span class="kpi-chip">{{ $stats['admins'] ?? 0 }} {{ __('main.admins') }}</span>
                    <span class="kpi-chip">{{ $stats['content_managers'] ?? 0 }} {{ __('main.content_managers') }}</span>
                </div>
            </article>

            <article class="dashboard-kpi" style="--accent: #7c3aed;">
                <div class="kpi-meta">
                    <div>
                        <div class="kpi-label">{{ __('main.articles') }}</div>
                        <div class="kpi-value">{{ $contentStats['articles']['total'] ?? 0 }}</div>
                    </div>
                    <span class="kpi-icon"><i class="fas fa-newspaper"></i></span>
                </div>
                <div class="kpi-note">
                    <span class="kpi-chip">{{ $contentStats['articles']['published'] ?? 0 }} {{ __('main.published') }}</span>
                    <span class="kpi-chip">{{ $contentStats['articles']['draft'] ?? 0 }} {{ __('main.draft') }}</span>
                </div>
            </article>

            <article class="dashboard-kpi" style="--accent: #0f766e;">
                <div class="kpi-meta">
                    <div>
                        <div class="kpi-label">{{ __('main.projects') }}</div>
                        <div class="kpi-value">{{ $contentStats['projects']['total'] ?? 0 }}</div>
                    </div>
                    <span class="kpi-icon"><i class="fas fa-project-diagram"></i></span>
                </div>
                <div class="kpi-note">
                    <span class="kpi-chip">{{ $contentStats['projects']['active'] ?? 0 }} {{ __('main.active') }}</span>
                </div>
            </article>

            <article class="dashboard-kpi" style="--accent: #ea580c;">
                <div class="kpi-meta">
                    <div>
                        <div class="kpi-label">{{ __('main.total_tickets') }}</div>
                        <div class="kpi-value" data-ticket-total>{{ $supportStats['tickets']['total'] ?? 0 }}</div>
                    </div>
                    <span class="kpi-icon"><i class="fas fa-ticket-alt"></i></span>
                </div>
                <div class="kpi-note">
                    <span class="kpi-chip">{{ $supportStats['tickets']['open'] ?? 0 }} {{ __('main.open') }}</span>
                    <span class="kpi-chip">{{ $supportStats['tickets']['in_progress'] ?? 0 }} {{ __('main.in_progress') }}</span>
                    <span class="kpi-chip">{{ $supportStats['tickets']['closed'] ?? 0 }} {{ __('main.closed') }}</span>
                </div>
            </article>
        </section>

        <section class="dashboard-main-grid">
            <div class="dashboard-stack">
                <div class="dashboard-panel">
                    <div class="dashboard-panel-body">
                        <div class="dashboard-panel-header">
                            <div class="panel-title">
                                <span class="panel-title-icon"><i class="fas fa-layer-group"></i></span>
                                <div>
                                    <h3>{{ __('main.content_management') }}</h3>
                                    <p>{{ __('main.dashboard') }}</p>
                                </div>
                            </div>
                            @can('articles-read')
                                <a class="panel-link underline" href="{{ route('dashboard.articles.index') }}">{{ __('main.articles') }}</a>
                            @endcan
                        </div>

                        <div class="snapshot-grid">
                            <article class="snapshot-card">
                                <span class="kpi-label">{{ __('main.articles') }}</span>
                                <strong>{{ $contentStats['articles']['total'] ?? 0 }}</strong>
                                <div class="progress-track mt-4">
                                    <div class="progress-bar" style="width: {{ $articlesPublishedPercent }}%"></div>
                                </div>
                                <div class="stats-inline">
                                    <span class="stats-pill success">{{ $contentStats['articles']['published'] ?? 0 }} {{ __('main.published') }}</span>
                                    <span class="stats-pill warning">{{ $contentStats['articles']['draft'] ?? 0 }} {{ __('main.draft') }}</span>
                                </div>
                                <small>{{ round($articlesPublishedPercent) }}% {{ __('main.published') }}</small>
                            </article>

                            <article class="snapshot-card">
                                <span class="kpi-label">{{ __('main.services') }}</span>
                                <strong>{{ $contentStats['services']['total'] ?? 0 }}</strong>
                                <div class="progress-track mt-4">
                                    <div class="progress-bar" style="width: {{ $servicesActivePercent }}%"></div>
                                </div>
                                <div class="stats-inline">
                                    <span class="stats-pill info">{{ $contentStats['services']['active'] ?? 0 }} {{ __('main.active') }}</span>
                                </div>
                                <small>{{ __('main.service_management') }}</small>
                            </article>

                            <article class="snapshot-card">
                                <span class="kpi-label">{{ __('main.projects') }}</span>
                                <strong>{{ $contentStats['projects']['total'] ?? 0 }}</strong>
                                <div class="progress-track mt-4">
                                    <div class="progress-bar" style="width: {{ $projectsActivePercent }}%"></div>
                                </div>
                                <div class="stats-inline">
                                    <span class="stats-pill success">{{ $contentStats['projects']['active'] ?? 0 }} {{ __('main.active') }}</span>
                                </div>
                                <small>{{ round($projectsActivePercent) }}% {{ __('main.active') }}</small>
                            </article>

                            <article class="snapshot-card">
                                <span class="kpi-label">{{ __('main.clients') }}</span>
                                <strong>{{ $businessStats['clients']['total'] ?? 0 }}</strong>
                                <div class="progress-track mt-4">
                                    <div class="progress-bar" style="width: {{ $clientsActivePercent }}%"></div>
                                </div>
                                <div class="stats-inline">
                                    <span class="stats-pill success">{{ $businessStats['clients']['active'] ?? 0 }} {{ __('main.active') }}</span>
                                </div>
                                <small>{{ __('main.client_network') }}</small>
                            </article>
                        </div>
                    </div>
                </div>

                <div class="dashboard-panel">
                    <div class="dashboard-panel-body">
                        <div class="dashboard-panel-header">
                            <div class="panel-title">
                                <span class="panel-title-icon"><i class="fas fa-clock-rotate-left"></i></span>
                                <div>
                                    <h3>{{ __('main.recent_activities') }}</h3>
                                    <p>{{ __('main.recent_activity') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="activity-grid">
                            <section class="activity-column">
                                <div class="activity-column-header">
                                    <h4>{{ __('main.articles') }}</h4>
                                    @can('articles-read')
                                        <a class="panel-link underline" href="{{ route('dashboard.articles.index') }}">{{ __('main.content_management') }}</a>
                                    @endcan
                                </div>
                                <ul class="activity-list">
                                    @forelse ($recentActivities['latest_articles'] as $item)
                                        <li class="activity-item">
                                            <div>
                                                <strong>#{{ $item->id }} {{ $item->slug }}</strong>
                                                <span>{{ $item->created_at?->diffForHumans() }}</span>
                                            </div>
                                            <span class="stats-pill {{ $item->status === 'published' ? 'success' : 'warning' }}">{{ __('main.' . $item->status) }}</span>
                                        </li>
                                    @empty
                                        <li class="activity-item"><span>{{ __('messages.no_records_found') }}</span></li>
                                    @endforelse
                                </ul>
                            </section>

                            <section class="activity-column">
                                <div class="activity-column-header">
                                    <h4>{{ __('main.projects') }}</h4>
                                    @can('projects-read')
                                        <a class="panel-link underline" href="{{ route('dashboard.projects.index') }}">{{ __('main.projects') }}</a>
                                    @endcan
                                </div>
                                <ul class="activity-list">
                                    @forelse ($recentActivities['latest_projects'] as $item)
                                        <li class="activity-item">
                                            <div>
                                                <strong>#{{ $item->id }} {{ limitedText($item->title ?? '', 36) }}</strong>
                                                <span>{{ $item->created_at?->diffForHumans() }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="activity-item"><span>{{ __('messages.no_records_found') }}</span></li>
                                    @endforelse
                                </ul>
                            </section>

                            <section class="activity-column">
                                <div class="activity-column-header">
                                    <h4>{{ __('main.tickets') }}</h4>
                                    @can('tickets-read')
                                        <a class="panel-link underline" href="{{ route('dashboard.tickets.index') }}">{{ __('main.ticket_network') }}</a>
                                    @endcan
                                </div>
                                <ul class="activity-list">
                                    @forelse ($recentActivities['latest_tickets'] as $item)
                                        <li class="activity-item">
                                            <div>
                                                <strong>#{{ $item->id }} {{ limitedText($item->subject ?? '', 32) }}</strong>
                                                <span>{{ $item->created_at?->diffForHumans() }}</span>
                                            </div>
                                            <span class="stats-pill info">{{ __('main.' . $item->status) }}</span>
                                        </li>
                                    @empty
                                        <li class="activity-item"><span>{{ __('messages.no_records_found') }}</span></li>
                                    @endforelse
                                </ul>
                            </section>

                            <section class="activity-column">
                                <div class="activity-column-header">
                                    <h4>{{ __('main.reviews') }}</h4>
                                    @can('reviews-read')
                                        <a class="panel-link underline" href="{{ route('dashboard.reviews.index') }}">{{ __('main.customer_feedback') }}</a>
                                    @endcan
                                </div>
                                <ul class="activity-list">
                                    @forelse ($recentActivities['latest_reviews'] as $item)
                                        <li class="activity-item">
                                            <div>
                                                <strong>#{{ $item->id }} {{ $item->name }}</strong>
                                                <span>{{ $item->created_at?->diffForHumans() }}</span>
                                            </div>
                                            <span class="stats-pill {{ $item->status === 'approved' ? 'success' : 'warning' }}">{{ $item->rate }}/5</span>
                                        </li>
                                    @empty
                                        <li class="activity-item"><span>{{ __('messages.no_records_found') }}</span></li>
                                    @endforelse
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-stack">
                <div class="dashboard-panel">
                    <div class="dashboard-panel-body">
                        <div class="dashboard-panel-header">
                            <div class="panel-title">
                                <span class="panel-title-icon"><i class="fas fa-headset"></i></span>
                                <div>
                                    <h3>{{ __('main.ticket_network') }}</h3>
                                    <p>{{ __('main.dashboard') }}</p>
                                </div>
                            </div>
                            @can('tickets-read')
                                <a class="panel-link underline" href="{{ route('dashboard.tickets.index') }}">{{ __('main.tickets') }}</a>
                            @endcan
                        </div>

                        <div class="support-overview-grid">
                            <div class="support-stat">
                                <strong data-ticket-total>{{ $supportStats['tickets']['total'] ?? 0 }}</strong>
                                <span>{{ __('main.total_tickets') }}</span>
                            </div>
                            <div class="support-stat">
                                <strong>{{ $supportStats['tickets']['open'] ?? 0 }}</strong>
                                <span>{{ __('main.open') }}</span>
                            </div>
                            <div class="support-stat">
                                <strong>{{ $supportStats['tickets']['in_progress'] ?? 0 }}</strong>
                                <span>{{ __('main.in_progress') }}</span>
                            </div>
                        </div>

                        <div class="progress-track mb-3">
                            <div class="progress-bar" style="width: {{ $ticketsOpenPercent }}%"></div>
                        </div>
                        <p class="text-sm text-slate-500 font-semibold mb-4">{{ round($ticketsOpenPercent) }}% {{ __('main.open') }} {{ __('main.tickets') }}</p>

                        <div class="ticket-list">
                            @forelse ($supportStats['tickets']['latest'] as $item)
                                @can('tickets-read')
                                    <a href="{{ route('dashboard.tickets.show', $item->id) }}" class="ticket-item">
                                        <div class="ticket-item-main">
                                            <h4>{{ $item->name }}</h4>
                                            <p>{{ limitedText($item->subject ?? '', 56) }}</p>
                                            <div class="ticket-badges">
                                                <span class="kt-badge text-white {{ \App\Enum\TicketEnums::from($item->status)->badgeColor() }}">{{ __('main.' . $item->status) }}</span>
                                                <span class="kt-badge text-white" style="background-color: {{ $item->department?->border_main_color ?? 'default' }};">
                                                    {{ __('main.' . str_replace('-', '_', str_replace(' ', '_', $item->department?->name ?? 'no_department'))) }}
                                                </span>
                                            </div>
                                        </div>
                                        <i class="fa-solid fa-arrow-up-right-from-square" style="color: var(--icon_color)"></i>
                                    </a>
                                @endcan
                            @empty
                                <div class="ticket-item">
                                    <div class="ticket-item-main">
                                        <h4>{{ __('messages.no_records_found') }}</h4>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="dashboard-panel">
                    <div class="dashboard-panel-body">
                        <div class="dashboard-panel-header">
                            <div class="panel-title">
                                <span class="panel-title-icon"><i class="fas fa-shield-heart"></i></span>
                                <div>
                                    <h3>{{ __('main.system_status') }}</h3>
                                    <p>{{ __('main.last_update') }}: {{ now()->format('H:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="health-grid">
                            <article class="health-card">
                                <h4><span class="dot" style="background:#16a34a"></span>{{ __('main.system_status') }}</h4>
                                <p>{{ __('main.system_online') }}</p>
                                <small>{{ __('main.all_systems_operational') }}</small>
                            </article>

                            <article class="health-card">
                                <h4><span class="dot" style="background:#2563eb"></span>{{ __('main.database_status') }}</h4>
                                <p>{{ __('main.database_connected') }}</p>
                                <small>{{ __('main.sync_complete') }}</small>
                            </article>

                            <article class="health-card">
                                <h4><span class="dot" style="background:#f59e0b"></span>{{ __('main.reviews') }}</h4>
                                <p>{{ $avgRating }}/5 {{ __('main.avg_rating') }}</p>
                                <small>{{ $supportStats['reviews']['pending'] ?? 0 }} {{ __('main.pending_review') }}</small>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ablyKey = '{{ config('app.ably_key') }}';
            if (typeof Ably === 'undefined' || !ablyKey) {
                console.warn('Ably is not available or ABLY_KEY is missing.');
                return;
            }

            const ticketUpdates = new Ably.Realtime({
                key: ablyKey,
                logLevel: 1,
            });

            const ticketUpdatesChannel = ticketUpdates.channels.get('ticket-updates');
            ticketUpdatesChannel.subscribe('tickets-count', function(message) {
                const data = message.data || {};
                document.querySelectorAll('[data-ticket-total]').forEach(function(element) {
                    element.textContent = data.tickets_count ?? element.textContent;
                });
            });

            window.addEventListener('beforeunload', function() {
                ticketUpdates?.close();
            });
        });
    </script>
@endpush
