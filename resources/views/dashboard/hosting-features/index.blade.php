@extends('dashboard.layout.master')

@section('title', __('main.hosting_features'))
@section('page-title', 'ÌæÅ ' . __('main.hosting_features'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush


@section('content')
    <div class="entity-index-page" style="--page-accent: #f97316;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-list"></i>
                        {{ __('main.hosting_features') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.hosting_features') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_types', ['types' => __('main.hosting_features')]) }}</p>

                    <div class="entity-hero-actions">
                        <a href="{{ route('dashboard.hosting-features.create') }}" class="entity-hero-action">
                            <i class="fas fa-plus-circle"></i>
                            {{ __('main.create_type', ['type' => __('main.hosting_feature')]) }}
                        </a>
                    </div>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-line',
                    'items' => [
                        ['id' => 'stat-total', 'value' => $allItems, 'label' => __('main.total_types', ['types' => __('main.hosting_features')])],
                        ['id' => 'stat-active', 'value' => $allItemActive, 'label' => __('main.active_types', ['types' => __('main.hosting_features')])],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-list',
                'title' => __('main.hosting_features'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.hosting_features')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.hosting_features')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    <a href="{{ route('dashboard.hosting-features.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.create_type', ['type' => __('main.hosting_feature')]) }}
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
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hostingFeatures as $feature)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="p-4 text-sm">
                                        @if ($feature->image)
                                            <img src="{{ asset('storage/' . $feature->image) }}" class="w-12 h-12 rounded object-cover shadow-sm">
                                        @else
                                            <span class="text-gray-400">--</span>
                                        @endif
                                    </td>
                                    <td class="p-4" title="{{ $feature->translations[app()->getLocale()]['title'] ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($feature->translations[app()->getLocale()]['title'] ?? '--', 30) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-600">{{ $feature->order ?? 0 }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $feature->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $feature->is_active,
                                            'modelClass' => 'hostingFeature',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($feature->creator)
                                            <a href="{{ route('dashboard.users.show', $feature->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $feature->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-500">{{ $feature->created_at?->format('d/m/Y') ?? '--' }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $feature,
                                            'models' => 'hosting-features',
                                            'modelClass' => 'hosting-feature',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($hostingFeatures->hasPages())
                        <div class="entity-pagination">
                            {{ $hostingFeatures->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
