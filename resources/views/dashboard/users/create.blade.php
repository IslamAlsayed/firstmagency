@extends('dashboard.layout.master')

@section('title', __('main.create_user'))
@section('page-title', '👤 ' . __('main.create_user'))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.create_user') }}</h3>

            <a href="{{ route('dashboard.users.index') }}" class="kt-btn kt-btn-outline-primary">
                {{ __('main.back_to_types', ['types' => __('main.users')]) }}
            </a>
        </div>
        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.users.store') ?? '#' }}" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4 lg:gap-6">
                    <!-- معلومات الوسائط -->
                    @include('dashboard.components.photo')

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.name') }} <span
                                    class="text-red-500">*</span></label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="name" name="name" required value="{{ old('name') }}">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.email') }} <span
                                    class="text-red-500">*</span></label>
                            <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="email" name="email" required value="{{ old('email') }}">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.password') }} <span
                                    class="text-red-500">*</span></label>
                            <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="password" name="password" required>
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.confirm_password') }} <span
                                    class="text-red-500">*</span></label>
                            <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.role') }} <span
                                    class="text-red-500">*</span></label>
                            <select class="kt-select basic-single" id="role" name="role" required>
                                <option value="" selected>--</option>
                                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>{{ __('main.super_admin') }}</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>{{ __('main.admin') }}</option>
                                <option value="content_manager" {{ old('role') == 'content_manager' ? 'selected' : '' }}>{{ __('main.content_manager') }}
                                </option>
                            </select>
                            @error('role')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="mobile" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.mobile') }}</label>
                            <input type="tel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="mobile" name="mobile" value="{{ old('mobile') }}">
                            @error('mobile')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.phone') }}</label>
                            <input type="tel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        {{-- العنوان --}}
                        @include('dashboard.components.input-text-editor', [
                            'name' => 'address',
                            'value' => old('address'),
                        ])

                        {{-- السيرة الذاتية --}}
                        @include('dashboard.components.input-text-editor', [
                            'name' => 'bio',
                            'value' => old('bio'),
                        ])
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.status') }}</label>
                            <select class="kt-select basic-single" id="status" name="status" required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>{{ __('main.active') ?? 'نشط' }}</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('main.inactive') ?? 'غير نشط' }}</option>
                                <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>{{ __('main.suspended') ?? 'معلق' }}</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- هل نشط -->
                    <div class="flex flex-wrap" style="gap: 10px 40px;">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('dashboard.components.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => 1,
                                'label' => __('main.is_active'),
                            ])
                        </div>
                    </div>

                    <!-- الحقول المخفية للنظام -->
                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                    <input type="hidden" name="updated_by" value="{{ auth()->id() }}">

                    <!-- زر الحفظ -->
                    @include('dashboard.components.save-submit', ['models' => 'dashboard.users', 'model' => 'user'])
                </div>
            </form>
        </div>
    </div>
@endsection
