@extends('dashboard.layout.master')

@section('title', __('main.dashboards_and_apps'))
@section('page-title', 'í´§ ' . __('main.dashboards_and_apps'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush


@section('content')
    <div class="entity-index-page" style="--page-accent: #06b6d4;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-tools"></i>
                        {{ __('main.dashboards_and_apps') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.dashboards_and_apps') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_types', ['types' => __('main.dashboards_and_apps')]) }}</p>

                    <div class="entity-hero-actions">
                        <a href="{{ route('dashboard.dashboards-and-systems.create') }}" class="entity-hero-action">
                            <i class="fas fa-plus-circle"></i>
                            {{ __('main.create_dashboards_and_app') }}
                        </a>
                    </div>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-bar',
                    'items' => [
                        ['id' => 'stat-total', 'value' => $allItems, 'label' => __('main.total_types', ['types' => __('main.dashboards_and_apps')])],
                        ['id' => 'stat-os', 'value' => $operatingSystemsCount, 'label' => __('main.total_operating_systems')],
                        ['id' => 'stat-apps', 'value' => $dashboardsAndAppsCount, 'label' => __('main.total_dashboards_and_apps')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-tools',
                'title' => __('main.dashboards_and_apps'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.dashboards_and_apps')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.dashboards_and_apps')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    <a href="{{ route('dashboard.dashboards-and-systems.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.create_dashboards_and_app') }}
                    </a>
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.slug') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.type') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardsAndSystems as $app)
                                <tr id="row-{{ $app->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="p-4">
                                        <div class="relative w-fit">
                                            @if ($app->image && checkExistFile($app->image))
                                                <img src="{{ asset('storage/' . $app->image) }}" alt="{{ $app->translations[app()->getLocale()]['title'] ?? '' }}" class="w-[90px] h-[35px] rounded-[9px] shrink-0 object-cover">
                                            @else
                                                <i class="fas fa-tools text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4" title="{{ $app->translations[app()->getLocale()]['title'] ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($app->translations[app()->getLocale()]['title'] ?? '--', 30) }}
                                        </span>
                                    </td>
                                    <td title="{{ $app->slug ?? '--' }}" class="p-4 text-sm text-gray-600">
                                        {{ limitedText($app->slug ?? '--', 25) }}
                                    </td>
                                    <td class="p-4 text-sm">
                                        <span class="inline-block bg-purple-50 text-purple-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ $app->type ?? '--' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-600">{{ $app->order ?? 0 }}</td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($app->creator)
                                            <a href="{{ route('dashboard.users.show', $app->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $app->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-500">{{ $app->created_at?->format('d/m/Y') ?? '--' }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $app,
                                            'models' => 'dashboards-and-systems',
                                            'modelClass' => 'dashboards-and-system',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-4 text-center text-gray-500">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($dashboardsAndSystems->hasPages())
                        <div class="entity-pagination">
                            {{ $dashboardsAndSystems->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
