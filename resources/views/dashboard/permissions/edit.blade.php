@extends('dashboard.layout.master')

@section('title', __('dashboard.edit_permission'))
@section('page-title', '🔑 ' . __('dashboard.edit_permission'))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header">
            <div class="flex items-center gap-4">
                <h3 class="kt-card-title">{{ __('dashboard.edit_permission') }}: {{ $permission->name }}</h3>
            </div>
        </div>
        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.permissions.update', $permission->id) }}">
                @csrf
                @method('PUT')
                <div class="grid gap-4 lg:gap-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('dashboard.permission_name') }} <span
                                    class="text-red-500">*</span></label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                id="name" name="name" required value="{{ old('name', $permission->name) }}" placeholder="مثال: users-create"
                                pattern="[a-z0-9\-]+" title="{{ __('dashboard.use_lowercase_numbers') }}">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">{{ __('dashboard.permission_format') }}</p>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('dashboard.description') }}</label>
                        <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" id="description" name="description"
                            rows="4" placeholder="الوصف ما تلعبه هذه الأذونة...">{{ old('description', $permission->description) }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- تحديث الإرسال -->
                    @include('dashboard.components.update-submit', ['models' => 'dashboard.permissions', 'model' => 'permission'])
                </div>
            </form>
        </div>
    </div>
@endsection
