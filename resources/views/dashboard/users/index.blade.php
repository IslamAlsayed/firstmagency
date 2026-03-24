@extends('dashboard.layout.master')

@section('title', __('main.user_management'))
@section('page-title', '👤 ' . __('main.user_management'))

@section('content')
    <div class="w-full">
        <div class="bg-white shadow-lg radius-lg">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-users mr-2"></i> {{ __('main.users') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.users')]) }}">
                    <a href="{{ route('dashboard.users.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.create_user') }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.photo') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.name') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.email') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.role') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.join_date') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr id="row-{{ $user->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td title="{{ $user->name }}">
                                    <div class="relative w-fit">
                                        @if ($user->photo && checkExistFile($user->photo))
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" loading="lazy" class="rounded-full size-9 shrink-0">
                                        @else
                                            @if ($user->photo)
                                                <img src="{{ asset('assets/images/avatars/' . $user->photo) }}" alt="{{ $user->name }}" loading="lazy" class="rounded-full size-9 shrink-0">
                                            @else
                                                <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ $user->name }}" loading="lazy" class="rounded-full size-9 shrink-0">
                                            @endif
                                        @endif
                                        @if (isset($models) && $models && $models == 'users')
                                            <span class="real-active {{ $user->user_status == 'online' ? 'active heartbeat' : '' }} user-heartbeat-{{ $user->id }}"></span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 text-sm text-gray-800">{{ $user->name }}</td>
                                <td class="p-4 text-sm text-gray-600 email">{{ $user->email }}</td>
                                <td class="p-4 text-sm">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if ($user->isSuperAdmin()) bg-red-100 text-red-800
                                        @elseif($user->isAdmin()) bg-yellow-100 text-yellow-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ __('main.' . $user->role) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="p-4 text-sm">
                                    @include('dashboard.components.toggle-hold', [
                                        'modelId' => $user->id,
                                        'field' => 'is_active',
                                        'value' => (bool) $user->is_active,
                                        'modelClass' => 'user',
                                    ])
                                </td>
                                <td class="p-4 text-sm space-x-2">
                                    @include('dashboard.components.permissions-actions', [
                                        'record' => $user,
                                        'models' => 'users',
                                        'modelClass' => 'user',
                                    ])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                    {{ __('main.no_users_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($users->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
