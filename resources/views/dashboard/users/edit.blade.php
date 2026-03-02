@extends('dashboard.layout.master')

@section('title', __('main.edit_user'))
@section('page-title', '👤 ' . __('main.edit_user'))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.edit_user') }}</h3>

            <a href="{{ route('dashboard.users.index') }}" class="kt-btn kt-btn-outline-primary">
                {{ __('main.back_to_types', ['types' => __('main.users')]) }}
            </a>
        </div>
        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.users.update', $user->id) ?? '#' }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gap-4 lg:gap-6">
                    <!-- معلومات الوسائط -->
                    @include('dashboard.components.photo', ['record' => $user])

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.name') }}</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="name" name="name" value="{{ old('name', $user->name) }}">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.email') }}</label>
                            <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="email" name="email" value="{{ old('email', $user->email) }}">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.role') }}</label>
                            <select class="kt-select basic-single" id="role" name="role">
                                <option value="" selected>--</option>
                                <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>{{ __('main.super_admin') }}
                                </option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>{{ __('main.admin') }}</option>
                                <option value="content_manager" {{ old('role', $user->role) == 'content_manager' ? 'selected' : '' }}>
                                    {{ __('main.content_manager') }}</option>
                            </select>
                            @error('role')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="mobile" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.mobile') }}</label>
                            <input type="tel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}">
                            @error('mobile')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.phone') }}</label>
                            <input type="tel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        {{-- العنوان --}}
                        @include('dashboard.components.input-text-editor', [
                            'name' => 'address',
                            'value' => old('address', $user->address),
                        ])

                        {{-- السيرة الذاتية --}}
                        @include('dashboard.components.input-text-editor', [
                            'name' => 'bio',
                            'value' => old('bio', $user->bio),
                        ])
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.status') }}</label>
                            <select class="kt-select basic-single" id="status" name="status">
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>{{ __('main.active') }}</option>
                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>{{ __('main.inactive') }}</option>
                                <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>{{ __('main.suspended') }}</option>
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
                                'checked' => old('is_active', $user->is_active),
                                'label' => __('main.is_active'),
                            ])
                        </div>
                    </div>

                    <!-- حقول مخفية للنظام -->
                    <input type="hidden" name="created_by" value="{{ old('created_by', $user->created_by) }}">
                    <input type="hidden" name="updated_by" value="{{ old('updated_by', $user->updated_by) }}">

                    <!-- زر التحديث -->
                    @include('dashboard.components.update-submit', ['models' => 'dashboard.users', 'model' => 'user'])
                </div>
            </form>
        </div>
    </div>
@endsection
