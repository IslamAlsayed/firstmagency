@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <h1 class="text-3xl font-bold mb-6">
            {{ __('main.create_about_us') }}
        </h1>

        <form action="{{ route('dashboard.about-us.store') }}" method="POST" enctype="multipart/form-data" class="kt-card">
            @csrf

            <div class="kt-card-body">
                <!-- Title -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">{{ __('main.title') }} *</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="kt-input w-full @error('title') error @enderror"
                        placeholder="{{ __('main.title') }}">
                    @error('title')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">{{ __('main.description') }} *</label>
                    <textarea name="description" class="kt-input w-full @error('description') error @enderror" rows="5" placeholder="{{ __('main.description') }}">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">{{ __('main.image') }}</label>
                    <input type="file" name="image" class="kt-input w-full @error('image') error @enderror" accept="image/*">
                    @error('image')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alt Text -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">{{ __('main.alt_text') }}</label>
                    <input type="text" name="alt_text" value="{{ old('alt_text') }}" class="kt-input w-full" placeholder="{{ __('main.alt_text') }}">
                </div>

                <!-- Order -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">{{ __('main.order') }} *</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" class="kt-input w-full @error('order') error @enderror" min="0">
                    @error('order')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Active -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" class="w-4 h-4" {{ old('is_active') ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-medium">{{ __('main.active') }}</span>
                    </label>
                </div>
            </div>

            <div class="kt-card-footer flex gap-3">
                @include('dashboard.components.save-submit')
                <a href="{{ route('dashboard.about-us.index') }}" class="kt-btn kt-btn-secondary">
                    {{ __('main.cancel') }}
                </a>
            </div>
        </form>
    </div>
@endsection
