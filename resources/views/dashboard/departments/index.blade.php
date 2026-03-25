@extends('dashboard.layout.master')

@section('title', __('main.departments'))
@section('page-title', '🏢 ' . __('main.departments'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #7c3aed;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-sitemap"></i>
                        {{ __('main.departments') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.departments') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.departments') }}</p>

                    @if (auth()->user()->can('departments-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.departments.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_type', ['type' => __('main.department')]) }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-building-circle-check',
                    'items' => [
                        ['value' => $departments->total(), 'label' => __('main.departments')],
                        ['value' => $departments->whereNotNull('user_id')->count(), 'label' => __('main.username')],
                        ['value' => $departments->whereNull('user_id')->count(), 'label' => __('main.na')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-sitemap',
                'title' => __('main.departments'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.departments')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.departments')]) }}">
                </div>

                @if (auth()->user()->can('departments-create'))
                    <div class="entity-toolbar-group">
                        <a href="{{ route('dashboard.departments.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                            {{ __('main.create_type', ['type' => __('main.department')]) }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table">
                        <thead>
                            <tr>
                                <th>{{ __('main.name') }}</th>
                                <th>{{ __('main.name') }} (عربي)</th>
                                <th>{{ __('main.username') }}</th>
                                <th>{{ __('main.styling') }}</th>
                                <th>{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $department)
                                <tr id="row-{{ $department->id }}">
                                    <td><span class="entity-primary-text">{{ $department->name }}</span></td>
                                    <td><span class="entity-secondary-text">{{ $department->name_ar }}</span></td>

                                    <td>
                                        @if ($department->user)
                                            <div class="flex items-center gap-2">
                                                @if ($department->user->photo)
                                                    <img src="{{ asset('assets/images/avatars/' . $department->user->photo) }}" alt="{{ $department->user->name }}" class="rounded-full size-6 shrink-0">
                                                @else
                                                    <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ $department->user->name }}" class="rounded-full size-6 shrink-0">
                                                @endif
                                                <span class="entity-primary-text">{{ $department->user->name }}</span>
                                            </div>
                                        @else
                                            <span class="entity-secondary-text">{{ __('main.na') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded" style="background-color: {{ $department->bg_color ?? '#ccc' }}; border: 2px solid {{ $department->border_color ?? '#999' }};">
                                            </div>
                                            <span class="entity-secondary-text">{{ $department->badge_color ?? __('main.na') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="entity-actions">
                                            @include('dashboard.components.permissions-actions', [
                                                'record' => $department,
                                                'models' => 'departments',
                                                'modelClass' => 'department',
                                            ])
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="entity-empty">
                                        {{ __('main.no_departments_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($departments->hasPages())
                    <div class="entity-pagination">
                        {{ $departments->links() }}
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchBox');
            const rows = Array.from(document.querySelectorAll('tbody tr[id^="row-"]'));

            searchBox?.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                rows.forEach(function(row) {
                    const rowText = row.innerText.toLowerCase();
                    if (!searchTerm || rowText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
