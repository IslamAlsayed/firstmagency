@extends('dashboard.layout.master')

@section('title', __('main.user_management'))
@section('page-title', '👤 ' . __('main.user_management'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #1d4ed8;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-users"></i>
                        {{ __('main.user_management') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.users') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.user_management') }}</p>

                    @if (auth()->user()->can('users-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.users.create') }}" class="entity-hero-action">
                                <i class="fas fa-user-plus"></i>
                                {{ __('main.create_user') }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-user-shield',
                    'items' => [
                        ['value' => $allItems, 'label' => __('main.users')],
                        ['value' => $superAdmins, 'label' => __('main.superadmin')],
                        ['value' => $admins, 'label' => __('main.admin')],
                        ['value' => $contentManagers, 'label' => __('main.content_manager')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-users',
                'title' => __('main.users'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.users')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.users')]) }}">

                    <select id="roleFilter" class="entity-select">
                        <option value="">{{ __('main.all') }} - {{ __('main.role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}">{{ __('main.' . $role) }}</option>
                        @endforeach
                    </select>

                    <select id="activeFilter" class="entity-select">
                        <option value="">{{ __('main.all') }} - {{ __('main.active') }}</option>
                        <option value="1">{{ __('main.active') }}</option>
                        <option value="0">{{ __('main.inactive') }}</option>
                    </select>
                </div>

                @if (auth()->user()->can('users-create'))
                    <div class="entity-toolbar-group">
                        <a href="{{ route('dashboard.users.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                            {{ __('main.create_user') }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table">
                        <thead>
                            <tr>
                                <th>{{ __('main.photo') }}</th>
                                <th>{{ __('main.name') }}</th>
                                <th>{{ __('main.email') }}</th>
                                <th>{{ __('main.role') }}</th>
                                <th>{{ __('main.join_date') }}</th>
                                <th>{{ __('main.active') }}</th>
                                <th>{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr id="row-{{ $user->id }}" data-role="{{ $user->role }}" data-active="{{ (int) $user->is_active }}">
                                    <td title="{{ $user->name }}">
                                        <div class="relative w-fit">
                                            @if ($user->photo && checkExistFile($user->photo))
                                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" loading="lazy" class="rounded-full size-10 shrink-0 object-cover">
                                            @else
                                                @if ($user->photo)
                                                    <img src="{{ asset('assets/images/avatars/' . $user->photo) }}" alt="{{ $user->name }}" loading="lazy"
                                                        class="rounded-full size-10 shrink-0 object-cover">
                                                @else
                                                    <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ $user->name }}" loading="lazy" class="rounded-full size-10 shrink-0 object-cover">
                                                @endif
                                            @endif
                                            @if (isset($models) && $models && $models == 'users')
                                                <span class="real-active {{ $user->user_status == 'online' ? 'active heartbeat' : '' }} user-heartbeat-{{ $user->id }}"></span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="entity-primary-text">{{ $user->name }}</span>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $user->email }}" class="entity-contact-link email">
                                            {{ $user->email }}
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if ($user->isSuperAdmin()) bg-red-100 text-red-800
                                            @elseif($user->isAdmin()) bg-yellow-100 text-yellow-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ __('main.' . $user->role) }}
                                        </span>
                                    </td>
                                    <td><span class="entity-secondary-text">{{ $user->created_at->format('d/m/Y') }}</span></td>
                                    <td>
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $user->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $user->is_active,
                                            'modelClass' => 'user',
                                        ])
                                    </td>
                                    <td>
                                        <div class="entity-actions">
                                            <a href="{{ route('dashboard.users.editPermissions', $user->id) }}" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-pink-500 text-white" toggle-button>
                                                @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                                                    {!! __('main.permissions') !!}
                                                @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                                                    <i class="fas fa-key text-white"></i>
                                                @else
                                                    <i class="fas fa-key text-white"></i>
                                                    {!! __('main.permissions') !!}
                                                @endif
                                            </a>
                                            @include('dashboard.components.permissions-actions', [
                                                'record' => $user,
                                                'models' => 'users',
                                                'modelClass' => 'user',
                                            ])
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="entity-empty">
                                        {{ __('main.no_users_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="entity-pagination">
                        {{ $users->links() }}
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
            const roleFilter = document.getElementById('roleFilter');
            const activeFilter = document.getElementById('activeFilter');
            const rows = Array.from(document.querySelectorAll('tbody tr[id^="row-"]'));

            function filterUsers() {
                const roleValue = roleFilter?.value || '';
                const activeValue = activeFilter?.value || '';

                rows.forEach(function(row) {
                    const matchesRole = !roleValue || row.dataset.role === roleValue;
                    const matchesActive = !activeValue || row.dataset.active === activeValue;

                    row.style.display = matchesRole && matchesActive ? '' : 'none';
                });
            }

            roleFilter?.addEventListener('change', filterUsers);
            activeFilter?.addEventListener('change', filterUsers);
        });
    </script>
@endpush
