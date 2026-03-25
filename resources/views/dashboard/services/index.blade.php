@extends('dashboard.layout.master')

@section('title', __('main.services'))
@section('page-title', '💼 ' . __('main.services'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #0f766e;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-briefcase"></i>
                        {{ __('main.services') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.services') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_services') }}</p>

                    @if (auth()->user()->can('services-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.services.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_service') }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-building',
                    'items' => [
                        ['id' => 'stat-total', 'value' => count($services), 'label' => __('main.total_services')],
                        ['id' => 'stat-active', 'value' => $services->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $services->where('is_active', false)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-building',
                'title' => __('main.services'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.services')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.services')]) }}">

                    <select id="activeFilter" class="entity-select">
                        <option value="">{{ __('main.all') }} - {{ __('main.active') }}</option>
                        <option value="1">{{ __('main.active') }}</option>
                        <option value="0">{{ __('main.inactive') }}</option>
                    </select>
                </div>

                @if (auth()->user()->can('services-create'))
                    <div class="entity-toolbar-group">
                        <a href="{{ route('dashboard.services.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                            {{ __('main.create_service') }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table">
                        <thead>
                            <tr>
                                <th>{{ __('main.icon') }}</th>
                                <th>{{ __('main.title') }}</th>
                                <th>{{ __('main.active') }}</th>
                                <th>{{ __('main.created_by') }}</th>
                                <th>{{ __('main.created_at') }}</th>
                                <th>{{ __('main.order') }}</th>
                                <th>{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                                <tr id="row-{{ $service->id }}" data-active="{{ (int) $service->is_active }}">
                                    <td title="{{ $service->translations[app()->getLocale()]['title'] ?? '' }}">
                                        <div class="relative w-fit">
                                            @if ($service->icon && checkExistFile($service->icon))
                                                <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->translations[app()->getLocale()]['title'] ?? '' }}"
                                                    class="rounded-full size-10 shrink-0 object-cover">
                                            @else
                                                <span class="entity-panel-title-icon"><i class="fas fa-briefcase"></i></span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="entity-primary-text block">
                                            {{ limitedText($service->translations[app()->getLocale()]['title'] ?? '', 50) }}
                                        </strong>
                                    </td>
                                    <td>
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $service->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $service->is_active,
                                            'modelClass' => 'service',
                                        ])
                                    </td>
                                    <td>
                                        @if ($service->creator)
                                            <a href="{{ route('dashboard.users.show', $service->creator->id) }}" class="entity-contact-link">
                                                {{ $service->creator->name }}
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </a>
                                        @else
                                            <span class="entity-secondary-text">N/A</span>
                                        @endif
                                    </td>
                                    <td><span class="entity-secondary-text">{{ $service->created_at?->format('d/m/Y') }}</span></td>
                                    <td><span class="entity-primary-text">{{ $service->order ?? 0 }}</span></td>
                                    <td>
                                        <div class="entity-actions">
                                            @include('dashboard.components.permissions-actions', [
                                                'record' => $service,
                                                'models' => 'services',
                                                'modelClass' => 'service',
                                            ])
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="entity-empty">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($services->hasPages())
                    <div class="entity-pagination">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchBox');
            const activeFilter = document.getElementById('activeFilter');
            const rows = Array.from(document.querySelectorAll('tbody tr[id^="row-"]'));

            function filterServices() {
                const searchValue = (searchBox?.value || '').toLowerCase().trim();
                const activeValue = activeFilter?.value || '';

                rows.forEach(function(row) {
                    const text = row.textContent.toLowerCase();
                    const matchesSearch = !searchValue || text.includes(searchValue);
                    const matchesActive = !activeValue || row.dataset.active === activeValue;

                    row.style.display = matchesSearch && matchesActive ? '' : 'none';
                });
            }

            searchBox?.addEventListener('input', filterServices);
            activeFilter?.addEventListener('change', filterServices);
        });
    </script>
@endpush
