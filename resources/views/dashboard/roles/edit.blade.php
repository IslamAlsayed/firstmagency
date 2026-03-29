@extends('dashboard.layout.master')

@section('title', __('main.edit_role'))
@section('page-title', '🔐 ' . __('main.edit_role'))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.roles.update', $role->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('main.role_name') }} <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="name" name="name" required
                            value="{{ old('name', $role->name) }}" placeholder="مثال: محرر، مدير">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="">
                    <h4 class="text-sm font-semibold text-gray-600 mb-1">{{ __('main.assign_permissions') }}</h4>
                    <p class="text-xs text-gray-500">{{ __('main.select_permissions_for_role') ?? 'اختر الأذونات المراد تعيينها لهذا الدور' }}</p>
                </div>

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
                                                'id' => 'permission_' . $permission->id,
                                                'value' => $permission->id,
                                                'checked' => in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '',
                                                'label' => __('main.' . str_replace(' ', '-', str_replace('_', '-', $permission->name))),
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-yellow-800 text-sm">{{ __('main.no_data') }}</p>
                    </div>
                @endif

                <!-- زر الحفظ -->
                @include('dashboard.components.save-submit', ['models' => 'dashboard.roles', 'model' => 'role'])
            </div>
        </form>
    </div>
@endsection
