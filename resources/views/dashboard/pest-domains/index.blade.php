@extends('dashboard.layout.master')

@section('title', __('main.pest_domains'))
@section('page-title', '🌐 ' . __('main.pest_domains'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush


@section('content')
    <div class="entity-index-page" style="--page-accent: #0ea5e9;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-globe"></i>
                        {{ __('main.pest_domains') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.pest_domains') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_pest_domains') }}</p>

                    <div class="entity-hero-actions">
                        <a href="{{ route('dashboard.pest-domains.create') }}" class="entity-hero-action">
                            <i class="fas fa-plus-circle"></i>
                            {{ __('main.create_pest_domain') }}
                        </a>
                    </div>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-pie',
                    'items' => [
                        ['id' => 'stat-total', 'value' => count($pestDomains), 'label' => __('main.total_pest_domains')],
                        ['id' => 'stat-active', 'value' => $pestDomains->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $pestDomains->where('is_active', false)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-globe',
                'title' => __('main.pest_domains'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.pest_domains')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.pest_domains')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    <a href="{{ route('dashboard.pest-domains.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.create_pest_domain') }}
                    </a>
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.alt_text') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pestDomains as $pestDomain)
                                <tr id="row-{{ $pestDomain->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $pestDomain->is_active }}">
                                    <td title="{{ $pestDomain->alt_text ?? '' }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($pestDomain->image && checkExistFile($pestDomain->image))
                                                <img src="{{ asset('storage/' . $pestDomain->image) }}" alt="{{ $pestDomain->alt_text ?? '' }}" class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                            @else
                                                <i class="fas fa-globe text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4" title="{{ $pestDomain->alt_text ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($pestDomain->alt_text ?? '--', 25) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $pestDomain->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $pestDomain->is_active,
                                            'modelClass' => 'pestDomain',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $pestDomain->order ?? 0 }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.status-actions', [
                                            'record' => $pestDomain,
                                            'models' => 'pest-domains',
                                            'modelClass' => 'pestDomain',
                                            'availableOptions' => array_column(\App\Enum\PestDomainEnums::cases(), 'value'),
                                        ])
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if ($pestDomain->status === 'published') bg-green-100 text-green-800
                                    @elseif($pestDomain->status === 'draft') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                            {{ __('main.' . $pestDomain->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($pestDomain->creator)
                                            <a href="{{ route('dashboard.users.show', $pestDomain->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $pestDomain->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $pestDomain->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $pestDomain,
                                            'models' => 'pest-domains',
                                            'modelClass' => 'pest-domain',
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

                    @if ($pestDomains->hasPages())
                        <div class="entity-pagination">
                            {{ $pestDomains->links() }}
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
