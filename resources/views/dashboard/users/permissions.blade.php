@extends('dashboard.layout.master')

@section('title', __('main.user_type', ['type' => __('main.permissions')]))
@section('page-title', '🔐 ' . __('main.user_type', ['type' => __('main.permissions')]))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.users.updatePermissions', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">{{ $user->name }} <span class="email">({{ $user->email }})</span></h2>
                <div class="text-sm text-gray-500 mb-2">{{ __('main.user_role') }}:
                    <span class="kt-badge text-white" style="background-color: {{ $user->department?->border_main_color ?? 'default' }};">
                        {{ __('main.' . $user->role) }}
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="text-sm font-semibold text-gray-600 mb-1">{{ __('main.assign_permissions') }}</h4>
                <p class="text-xs text-gray-500">{{ __('main.select_permissions_for_user') ?? 'اختر الأذونات المراد تعيينها لهذا المستخدم (ستتجاوز صلاحيات الدور)' }}</p>
            </div>

            <div class="grid gap-6 lg:gap-8">
                @if ($permissions->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @php
                            $permissions = $permissions->groupBy(function ($p) {
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
                        @foreach ($permissions as $module => $modulePermissions)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h5 class="text-sm font-semibold text-gray-700 mb-3 capitalize">{{ __('main.' . str_replace('-', '_', $module)) }}</h5>
                                <div class="space-y-2">
                                    @foreach ($modulePermissions as $permission)
                                        <div class="flex items-center gap-3">
                                            <input type="hidden" name="permissions[]" value="0">
                                            @include('dashboard.components.checkbox-button', [
                                                'name' => 'permissions[]',
                                                'id' => 'perm_' . $permission->id,
                                                'value' => $permission->name,
                                                'checked' => $user->hasPermissionTo($permission->name),
                                                'label' => __('main.' . str_replace(' ', '-', str_replace('_', '-', $permission->name))),
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Save Submit --}}
                @include('dashboard.components.save-submit', ['models' => 'dashboard.users', 'model' => 'permissions'])
            </div>
        </form>
    </div>
@endsection
