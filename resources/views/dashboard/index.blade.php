@extends('dashboard.layout.master')

@section('title', __('main.dashboard'))
@section('page-title', '🏠 ' . __('main.dashboard'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@push('styles')
    <style>
        .dashboard-home {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .dashboard-hero {
            position: relative;
            overflow: hidden;
            border-radius: 1.5rem;
            padding: 1.75rem;
            color: #fff;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.22), transparent 24%),
                linear-gradient({{ getActiveUser()->dashboard_locale == 'en' ? '135deg' : '225deg' }}, var(--dark-color) 0%, var(--light-color) 100%);
            box-shadow: 0 24px 50px rgba(15, 23, 42, 0.18);
        }

        .dashboard-hero::after {
            content: '';
            position: absolute;
            inset-inline-end: -3rem;
            bottom: -4rem;
            width: 12rem;
            height: 12rem;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.08);
        }

        .dashboard-hero-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(280px, 0.9fr);
            gap: 1.25rem;
            align-items: start;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.8rem;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.14);
            color: rgba(255, 255, 255, 0.92);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .hero-title {
            margin-top: 1rem;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            line-height: 1.08;
            font-weight: 800;
        }

        .hero-subtitle {
            margin-top: 0.85rem;
            max-width: 52rem;
            color: rgba(255, 255, 255, 0.82);
            font-size: 1rem;
        }

        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1.35rem;
        }

        .quick-action {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.8rem 1rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #fff;
            font-weight: 700;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .quick-action:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.18);
        }

        .hero-focus-card {
            border-radius: 1.25rem;
            background: rgba(7, 10, 24, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.14);
            padding: 1.1rem;
            backdrop-filter: blur(8px);
        }

        .hero-focus-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .hero-focus-item {
            border-radius: 1rem;
            padding: 0.9rem;
            background: rgba(255, 255, 255, 0.08);
        }

        .hero-focus-item strong {
            display: block;
            font-size: 1.4rem;
            line-height: 1;
            margin-bottom: 0.35rem;
        }

        .dashboard-kpis {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .dashboard-kpi {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            padding: 1.2rem;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.16);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .dashboard-kpi::before {
            content: '';
            position: absolute;
            inset-inline-start: 0;
            top: 0;
            width: 100%;
            height: 4px;
            background: var(--accent, var(--icon_color));
        }

        .kpi-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .kpi-icon {
            width: 3rem;
            height: 3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            color: #fff;
            background: var(--accent, var(--icon_color));
            box-shadow: 0 10px 25px color-mix(in srgb, var(--accent, var(--icon_color)) 25%, transparent);
        }

        .kpi-label {
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .kpi-value {
            font-size: clamp(2rem, 4vw, 2.6rem);
            line-height: 1;
            font-weight: 800;
            color: #0f172a;
        }

        .kpi-note {
            margin-top: 0.75rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .kpi-chip {
            padding: 0.35rem 0.65rem;
            border-radius: 9999px;
            background: #f8fafc;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .dashboard-main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(320px, 0.95fr);
            gap: 1.5rem;
        }

        .dashboard-stack {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .dashboard-panel {
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 1.35rem;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .dashboard-panel-body {
            padding: 1.35rem;
        }

        .dashboard-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }

        .panel-title {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .panel-title-icon {
            width: 2.75rem;
            height: 2.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.95rem;
            background: color-mix(in srgb, var(--icon_color) 14%, white);
            color: var(--icon_color);
        }

        .panel-title h3 {
            margin: 0;
            color: #0f172a;
            font-size: 1.05rem;
            font-weight: 800;
        }

        .panel-title p {
            margin: 0.2rem 0 0;
            color: #64748b;
            font-size: 0.85rem;
        }

        .panel-link {
            color: var(--icon_color);
            font-size: 0.82rem;
            font-weight: 800;
        }

        .snapshot-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .snapshot-card {
            border-radius: 1.1rem;
            padding: 1rem;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .snapshot-card strong {
            display: block;
            margin-top: 0.85rem;
            font-size: 1.95rem;
            line-height: 1;
            color: #0f172a;
        }

        .snapshot-card small {
            display: block;
            margin-top: 0.45rem;
            color: #64748b;
            font-weight: 700;
        }

        .progress-track {
            width: 100%;
            height: 0.5rem;
            border-radius: 9999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--icon_color), color-mix(in srgb, var(--icon_color) 55%, #22c55e));
        }

        .stats-inline {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.85rem;
        }

        .stats-pill {
            padding: 0.4rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .stats-pill.success {
            background: #dcfce7;
            color: #166534;
        }

        .stats-pill.warning {
            background: #fef3c7;
            color: #92400e;
        }

        .stats-pill.info {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .support-overview-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .support-stat {
            border-radius: 1rem;
            padding: 0.9rem;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .support-stat strong {
            display: block;
            font-size: 1.4rem;
            color: #0f172a;
        }

        .support-stat span {
            color: #64748b;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .ticket-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .ticket-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem;
            border-radius: 1rem;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.12);
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .ticket-item:hover {
            transform: translateY(-2px);
            background: #f1f5f9;
        }

        .ticket-item-main {
            min-width: 0;
        }

        .ticket-item-main h4 {
            margin: 0;
            color: #0f172a;
            font-size: 0.95rem;
            font-weight: 800;
        }

        .ticket-item-main p {
            margin: 0.25rem 0 0;
            color: #64748b;
            font-size: 0.8rem;
        }

        .ticket-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 0.65rem;
        }

        .activity-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .activity-column {
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.12);
            background: #f8fafc;
            overflow: hidden;
        }

        .activity-column-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.9rem 1rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.14);
            background: #fff;
        }

        .activity-column-header h4 {
            margin: 0;
            color: #0f172a;
            font-size: 0.9rem;
            font-weight: 800;
        }

        .activity-list {
            list-style: none;
            margin: 0;
            padding: 0.35rem;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.85rem;
            border-radius: 0.85rem;
        }

        .activity-item+.activity-item {
            margin-top: 0.2rem;
        }

        .activity-item:hover {
            background: rgba(255, 255, 255, 0.78);
        }

        .activity-item strong {
            display: block;
            color: #0f172a;
            font-size: 0.87rem;
        }

        .activity-item span {
            display: block;
            margin-top: 0.2rem;
            color: #64748b;
            font-size: 0.77rem;
        }

        .health-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .health-card {
            border-radius: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .health-card .dot {
            width: 0.7rem;
            height: 0.7rem;
            border-radius: 9999px;
            display: inline-block;
            margin-inline-end: 0.4rem;
        }

        .health-card h4 {
            margin: 0 0 0.55rem;
            color: #0f172a;
            font-size: 0.88rem;
            font-weight: 800;
        }

        .health-card p {
            margin: 0;
            color: #475569;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .health-card small {
            display: block;
            margin-top: 0.45rem;
            color: #64748b;
            font-size: 0.76rem;
        }

        @media (max-width: 1280px) {
            .dashboard-kpis {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .dashboard-main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {

            .dashboard-hero-grid,
            .activity-grid,
            .snapshot-grid,
            .health-grid,
            .support-overview-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-hero {
                padding: 1.25rem;
            }

            .hero-title {
                font-size: 1.9rem;
            }

            .hero-subtitle {
                font-size: 0.92rem;
            }

            .dashboard-kpis {
                grid-template-columns: 1fr;
            }

            .dashboard-panel-body {
                padding: 1rem;
            }
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
                        @if (auth()->user()->can('tickets-create'))
                            <a href="{{ route('dashboard.tickets.create') }}" class="quick-action">
                                <i class="fas fa-ticket-alt"></i>
                                {{ __('main.create_type', ['type' => __('main.ticket')]) }}
                            </a>
                        @endif
                        @if (auth()->user()->can('articles-create'))
                            <a href="{{ route('dashboard.articles.create') }}" class="quick-action">
                                <i class="fas fa-newspaper"></i>
                                {{ __('main.create_type', ['type' => __('main.article')]) }}
                            </a>
                        @endif
                        @if (auth()->user()->can('projects-create'))
                            <a href="{{ route('dashboard.projects.create') }}" class="quick-action">
                                <i class="fas fa-project-diagram"></i>
                                {{ __('main.create_type', ['type' => __('main.project')]) }}
                            </a>
                        @endif
                        @if (auth()->user()->can('services-create'))
                            <a href="{{ route('dashboard.services.create') }}" class="quick-action">
                                <i class="fas fa-cogs"></i>
                                {{ __('main.create_type', ['type' => __('main.service')]) }}
                            </a>
                        @endif
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
                            <a class="panel-link" href="{{ route('dashboard.articles.index') }}">{{ __('main.articles') }}</a>
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
                                    <a class="panel-link" href="{{ route('dashboard.articles.index') }}">{{ __('main.content_management') }}</a>
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
                                    <a class="panel-link" href="{{ route('dashboard.projects.index') }}">{{ __('main.projects') }}</a>
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
                                    <a class="panel-link" href="{{ route('dashboard.tickets.index') }}">{{ __('main.ticket_network') }}</a>
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
                                    <a class="panel-link" href="{{ route('dashboard.reviews.index') }}">{{ __('main.customer_feedback') }}</a>
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
                            <a class="panel-link" href="{{ route('dashboard.tickets.index') }}">{{ __('main.tickets') }}</a>
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
