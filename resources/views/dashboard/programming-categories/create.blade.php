@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.programming_category')]))
@section('page-title', '💻 ' . __('main.create_type', ['type' => __('main.programming_category')]))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.programming-categories.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6">
                <!-- Image Upload -->
                <div class="grid grid-cols-1 gap-6">
                    @include('dashboard.components.photo', ['column' => 'image'])
                </div>

                <!-- Name and Name (Arabic) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.name') }}
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('name') border-red-500 @enderror" placeholder="{{ __('main.name') }}">
                        @error('name')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="name_ar" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.name_ar') }}
                        </label>
                        <input type="text" id="name_ar" name="name_ar" value="{{ old('name_ar') }}"
                            class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('name_ar') border-red-500 @enderror"
                            placeholder="{{ __('main.name_ar') }}">
                        @error('name_ar')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Alt Text & Order -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="alt_text" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.alt_text') }}
                        </label>
                        <input type="text" id="alt_text" name="alt_text" value="{{ old('alt_text') }}"
                            class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('alt_text') border-red-500 @enderror"
                            placeholder="{{ __('main.alt_text') }}">
                        @error('alt_text')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="order" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.order') }}
                        </label>
                        <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                            class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                    </div>
                </div>

                <!-- Active -->
                <div class="flex flex-wrap items-center gap-6">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('dashboard.components.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                <!-- Save Button -->
                @include('dashboard.components.save-submit', ['models' => 'dashboard.programming-categories', 'model' => 'category'])
            </div>
        </form>
    </div>
@endsection
