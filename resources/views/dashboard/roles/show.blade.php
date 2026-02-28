@extends('dashboard.layout.master')

@section('title', __('dashboard.view_role'))
@section('page-title', '🔐 ' . __('dashboard.view_role'))

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Role Details -->
        <div class="lg:col-span-1">
            <div class="background rounded-lg shadow p-4">
                <div class="bg-indigo-50 border-l-4 border-indigo-500 mb-4 rounded">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $role->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ __('dashboard.guard') }}: <span
                            class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $role->guard_name }}</span></p>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">{{ __('dashboard.total_permissions') }}</label>
                        <p class="text-2xl font-bold text-purple-600">{{ $role->permissions->count() }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">{{ __('dashboard.created_at') }}</label>
                        <p class="text-sm text-gray-600">{{ $role->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">{{ __('dashboard.updated_at') }}</label>
                        <p class="text-sm text-gray-600">{{ $role->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <a href="{{ route('dashboard.roles.edit', $role->id) }}"
                        class="flex-1 px-4 py-2 kt-btn kt-btn-outline-primary text-white rounded-lg text-center text-sm font-medium transition">
                        <i class="fas fa-edit mr-2"></i> {{ __('dashboard.edit') }}
                    </a>
                    <a href="{{ route('dashboard.roles.index') }}"
                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 text-center text-sm font-medium transition">
                        <i class="fas fa-arrow-left mr-2"></i> {{ __('dashboard.back') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Permissions List -->
        <div class="lg:col-span-2">
            <div class="background rounded-lg shadow p-4">
                <div class="bg-purple-50 border-l-4 border-purple-500 mb-4 rounded">
                    <h4 class="text-sm font-semibold text-purple-900">{{ __('dashboard.assigned_permissions') }}</h4>
                </div>

                @if ($role->permissions->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($role->permissions->groupBy(fn($p) => explode('-', $p->name)[0]) as $module => $modulePermissions)
                            <div class="border border-gray-200 rounded-lg">
                                <h5 class="text-sm font-semibold text-gray-700 mb-3 capitalize">{{ $module }}</h5>
                                <div class="space-y-2">
                                    @foreach ($modulePermissions as $permission)
                                        <div class="flex items-center gap-2 p-2 bg-gray-50 rounded">
                                            <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                            <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                        <i class="fas fa-info-circle text-yellow-600 text-2xl mb-2"></i>
                        <p class="text-yellow-800 font-medium">{{ __('dashboard.no_permissions_assigned_to_role') ?? 'لم تكن هناك أذونات معينة لهذا الدور' }}</p>
                        <p class="text-yellow-700 text-sm mt-1">{{ __('dashboard.edit_role_to_assign_permissions') ?? 'عدل هذا الدور لتعين الأذونات' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
