@extends('dashboard.layout.master')

@section('title', __('main.official_domains'))
@section('page-title', '🌐 ' . __('main.official_domains'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush


@section('content')
    <div class="entity-index-page" style="--page-accent: #14b8a6;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-globe"></i>
                        {{ __('main.official_domains') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.official_domains') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_official_domains') }}</p>

                    <div class="entity-hero-actions">
                        <a href="{{ route('dashboard.official-domains.create') }}" class="entity-hero-action">
                            <i class="fas fa-plus-circle"></i>
                            {{ __('main.create_official_domain') }}
                        </a>
                    </div>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-pie',
                    'items' => [
                        ['id' => 'stat-total', 'value' => count($officialDomains), 'label' => __('main.total_official_domains')],
                        ['id' => 'stat-active', 'value' => $officialDomains->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $officialDomains->where('is_active', false)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-globe',
                'title' => __('main.official_domains'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.official_domains')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.official_domains')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    <a href="{{ route('dashboard.official-domains.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.create_official_domain') }}
                    </a>
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.badge') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($officialDomains as $officialDomain)
                                <tr id="row-{{ $officialDomain->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $officialDomain->is_active }}">
                                    <td class="p-4 text-sm text-gray-600">{{ $officialDomain->title ?? '' }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $officialDomain->translations[app()->getLocale()]['badge'] ?? '' }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $officialDomain->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $officialDomain->is_active,
                                            'modelClass' => 'officialDomain',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $officialDomain->order ?? 0 }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.status-actions', [
                                            'record' => $officialDomain,
                                            'models' => 'official-domains',
                                            'modelClass' => 'officialDomain',
                                            'availableOptions' => array_column(\App\Enum\PestDomainEnums::cases(), 'value'),
                                        ])
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if ($officialDomain->status === 'published') bg-green-100 text-green-800
                                        @elseif($officialDomain->status === 'draft') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                            {{ __('main.' . $officialDomain->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($officialDomain->creator)
                                            <a href="{{ route('dashboard.users.show', $officialDomain->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $officialDomain->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $officialDomain->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $officialDomain,
                                            'models' => 'official-domains',
                                            'modelClass' => 'official-domain',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-8 text-center text-gray-400">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($officialDomains->hasPages())
                        <div class="entity-pagination">
                            {{ $officialDomains->links() }}
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
