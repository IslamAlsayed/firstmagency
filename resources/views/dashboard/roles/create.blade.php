@extends('dashboard.layout.master')

@section('title', __('main.create_role'))
@section('page-title', '🔐 ' . __('main.create_role'))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.create_role') }}</h3>

            <a href="{{ route('dashboard.roles.index') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                {{ __('main.back_to_types', ['types' => __('main.roles')]) }}
            </a>
        </div>
        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.roles.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4 lg:gap-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('main.role_name') }} <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="name" name="name" required
                                value="{{ old('name') }}" placeholder="مثال: محرر، مدير">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- تعيين الأذونات -->
                    <div class="">
                        <h4 class="text-sm font-semibold text-gray-600 mb-1">{{ __('main.assign_permissions') }}</h4>
                        <p class="text-xs text-gray-500">حدد الأذونات المراد تعيينها إلى هذا الدور</p>
                    </div>

                    @if ($permissions->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($permissions->groupBy(fn($p) => explode('-', $p->name)[0]) as $module => $modulePermissions)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h5 class="text-sm font-semibold text-gray-700 mb-3 capitalize">{{ $module }}</h5>
                                    <div class="space-y-2">
                                        @foreach ($modulePermissions as $permission)
                                            <div class="flex items-center gap-3">
                                                <input type="hidden" name="permissions[]" value="0">
                                                @include('dashboard.components.checkbox-button', [
                                                    'name' => 'permissions[]',
                                                    'id' => 'permission_' . $permission->id,
                                                    'value' => $permission->id,
                                                    'checked' => in_array($permission->id, old('permissions', [])),
                                                    'label' => $permission->name,
                                                ])
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800 text-sm">لا توجد أذونات متاحة. يرجى إنشاء أذونات أولاً.</p>
                        </div>
                    @endif

                    <!-- زر الحفظ -->
                    @include('dashboard.components.save-submit', ['models' => 'dashboard.roles', 'model' => 'role'])
                </div>
            </form>
        </div>
    </div>
@endsection
