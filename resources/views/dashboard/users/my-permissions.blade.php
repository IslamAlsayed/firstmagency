@extends('dashboard.layout.master')

@section('title', __('main.my_permissions'))
@section('page-title', __('main.my_permissions'))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <div class="mb-6">
            <h1 class="text-2xl font-bold mb-2">{{ __('main.my_permissions') }}</h1>
            <p class="text-gray-600">{{ __('main.here_are_your_permissions') }}</p>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-1">{{ __('main.your_roles') }}</h2>
            <ul class="list-disc list-inside">
                @forelse($roles as $role)
                    <li><span class="font-bold">{{ $role->name }}</span></li>
                @empty
                    <li class="text-gray-400">{{ __('main.no_roles_assigned') }}</li>
                @endforelse
            </ul>
        </div>

        <div class="mb-4">
            <h4 class="text-sm font-semibold text-gray-600 mb-1">{{ __('main.your_permissions') }}</h4>
            <p class="text-xs text-gray-500">{{ __('main.all_permissions_you_have') ?? 'جميع الصلاحيات التي تملكها (مباشرة أو من الدور)' }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @php
                $groupedPermissions = $allPermissions->groupBy(function ($p) {
                    $parts = explode('-', $p->name);
                    if (count($parts) > 1 && $parts[count($parts) - 1] === 'delete' && $parts[count($parts) - 2] === 'force') {
                        array_pop($parts);
                        array_pop($parts);
                    } else {
                        array_pop($parts);
                    }
                    return implode('-', $parts);
                });
            @endphp
            @foreach ($groupedPermissions as $module => $modulePermissions)
                <div class="border border-gray-200 rounded-lg p-4">
                    <h5 class="text-sm font-semibold text-gray-700 mb-3 capitalize">{{ __('main.' . str_replace('-', '_', $module)) }}</h5>
                    <div class="space-y-2">
                        @foreach ($modulePermissions as $permission)
                            <div class="flex items-center gap-3">
                                <span class="custom-input disabled-option">
                                    <input type="checkbox" checked disabled id="perm_{{ $permission->id }}">
                                    <label for="perm_{{ $permission->id }}">{{ __('main.' . str_replace(' ', '-', str_replace('_', '-', $permission->name))) }}</label>
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
