@extends('dashboard.layout.master')

@section('title', __('dashboard.view_permission'))
@section('page-title', '🔑 ' . __('dashboard.view_permission'))

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Permission Details -->
        <div class="lg:col-span-1">
            <div class="background rounded-lg shadow p-4">
                <div class="bg-indigo-50 mb-6 rounded">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-key text-yellow-500 text-xl"></i>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $permission->name }}</h3>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ __('dashboard.guard') }}: <span
                            class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $permission->guard_name }}</span></p>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">{{ __('dashboard.description') }}</label>
                        <p class="text-sm text-gray-600 mt-1">{{ $permission->description ?? '—' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">{{ __('dashboard.created_at') }}</label>
                        <p class="text-sm text-gray-600">{{ $permission->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">{{ __('dashboard.updated_at') }}</label>
                        <p class="text-sm text-gray-600">{{ $permission->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <a href="{{ route('dashboard.permissions.edit', $permission->id) }}"
                        class="flex-1 px-4 py-2 kt-btn kt-btn-outline-primary text-white rounded-lg text-center text-sm font-medium transition">
                        <i class="fas fa-edit mr-2"></i> {{ __('dashboard.edit') }}
                    </a>
                    <a href="{{ route('dashboard.permissions.index') }}"
                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 text-center text-sm font-medium transition">
                        <i class="fas fa-arrow-left mr-2"></i> {{ __('dashboard.back') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Roles with this permission -->
        <div class="lg:col-span-2">
            <div class="background rounded-lg shadow p-4">
                <div class="bg-purple-50 mb-6 rounded">
                    <h4 class="text-sm font-semibold text-purple-900">{{ __('dashboard.roles_with_this_permission') }}</h4>
                </div>

                @php
                    $rolesWithPermission = \Spatie\Permission\Models\Role::whereHas('permissions', function ($q) use ($permission) {
                        $q->where('id', $permission->id);
                    })->get();
                @endphp

                @if ($rolesWithPermission->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($rolesWithPermission as $role)
                            <div class="rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-2">
                                    <h5 class="font-semibold text-gray-800">{{ $role->name }}</h5>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">{{ $role->guard_name }}</span>
                                </div>
                                <p class="text-xs text-gray-600">تم الإنشاء: {{ $role->created_at->format('d/m/Y') }}</p>
                                <a href="{{ route('dashboard.roles.show', $role->id) }}"
                                    class="mt-3 kt-btn kt-btn-outline-primary text-sm text-indigo-600 font-medium">
                                    عرض الدور <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-yellow-50 rounded-lg p-6 text-center">
                        <i class="fas fa-info-circle text-yellow-600 text-2xl mb-2"></i>
                        <p class="text-yellow-800 font-medium">{{ __('dashboard.no_associated_roles') }}</p>
                        <p class="text-yellow-700 text-sm mt-1">{{ __('dashboard.link_permission_to_roles') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
