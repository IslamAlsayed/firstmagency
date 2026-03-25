@extends('dashboard.layout.master')

@section('title', __('main.role_management'))
@section('page-title', '🔐 ' . __('main.role_management'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #db2777;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-shield-alt"></i>
                        {{ __('main.role_management') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.roles') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.role_management') }}</p>

                    @if (auth()->user()->can('roles-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.roles.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_role') }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-key',
                    'items' => [
                        ['value' => $allItems, 'label' => __('main.total_roles')],
                        ['value' => $totalPermissions, 'label' => __('main.total_permissions')],
                        ['value' => $rolesWithPermissions, 'label' => __('main.roles_with_permissions')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-shield-alt',
                'title' => __('main.roles'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.roles')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.roles')]) }}">

                    <select id="guardFilter" class="entity-select">
                        <option value="">{{ __('main.all') }} - {{ __('main.guard') }}</option>
                        <option value="web">web</option>
                        <option value="api">api</option>
                    </select>
                </div>

                @if (auth()->user()->can('roles-create'))
                    <div class="entity-toolbar-group">
                        <a href="{{ route('dashboard.roles.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                            {{ __('main.create_role') }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table">
                        <thead>
                            <tr>
                                <th>{{ __('main.role_name') }}</th>
                                <th>{{ __('main.guard') }}</th>
                                <th>{{ __('main.permissions') }}</th>
                                <th>{{ __('main.created_at') }}</th>
                                <th>{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr id="row-{{ $role->id }}" data-guard="{{ $role->guard_name }}">
                                    <td><span class="entity-primary-text">{{ $role->name }}</span></td>
                                    <td>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            {{ $role->guard_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="px-2 py-1 bg-pink-100 text-pink-800 rounded text-xs font-medium">
                                            {{ $role->permissions_count }} {{ __('main.permissions') }}
                                        </span>
                                    </td>
                                    <td><span class="entity-secondary-text">{{ $role->created_at->format('d/m/Y') }}</span></td>
                                    <td>
                                        <div class="entity-actions">
                                            @include('dashboard.components.permissions-actions', [
                                                'record' => $role,
                                                'models' => 'roles',
                                                'modelClass' => 'role',
                                            ])
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="entity-empty">
                                        {{ __('main.no_data') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchBox');
            const guardFilter = document.getElementById('guardFilter');
            const rows = Array.from(document.querySelectorAll('tbody tr[id^="row-"]'));

            function filterRoles() {
                const searchValue = (searchBox?.value || '').toLowerCase().trim();
                const guardValue = guardFilter?.value || '';

                rows.forEach(function(row) {
                    const text = row.textContent.toLowerCase();
                    const matchesSearch = !searchValue || text.includes(searchValue);
                    const matchesGuard = !guardValue || row.dataset.guard === guardValue;

                    row.style.display = matchesSearch && matchesGuard ? '' : 'none';
                });
            }

            searchBox?.addEventListener('input', filterRoles);
            guardFilter?.addEventListener('change', filterRoles);
        });
    </script>
@endpush
