@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <h1 class="text-3xl font-bold mb-6">
            {{ __('main.view_about_us') }}
        </h1>

        <div class="kt-card">
            <div class="kt-card-body">
                <!-- Title -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">{{ __('main.title') }}</label>
                    <p class="text-lg font-semibold">{{ $aboutUs->title }}</p>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">{{ __('main.description') }}</label>
                    <p class="text-base">{{ $aboutUs->description }}</p>
                </div>

                <!-- Image -->
                @if ($aboutUs->image && checkExistFile($aboutUs->image))
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-600 mb-2">{{ __('main.image') }}</label>
                        <img src="{{ asset('storage/' . $aboutUs->image) }}" alt="{{ $aboutUs->alt_text }}" class="max-w-md h-auto rounded">
                    </div>
                @endif

                <!-- Alt Text -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">{{ __('main.alt_text') }}</label>
                    <p class="text-base">{{ $aboutUs->alt_text ?? '-' }}</p>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">{{ __('main.status') }}</label>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $aboutUs->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $aboutUs->is_active ? __('main.active') : __('main.inactive') }}
                    </span>
                </div>

                <!-- Creator -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">{{ __('main.created_by') }}</label>
                    <p class="text-base">{{ $aboutUs->creator->name ?? '-' }}</p>
                </div>

                <!-- Created At -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">{{ __('main.created_at') }}</label>
                    <p class="text-base">{{ $aboutUs->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>

            <div class="kt-card-footer flex gap-3">
                @can('update', $aboutUs)
                    <a href="{{ route('dashboard.about-us.edit', $aboutUs->id) }}" class="kt-btn kt-btn-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        <i class="fas fa-edit"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan

                <a href="{{ route('dashboard.about-us.index') }}" class="kt-btn kt-btn-secondary">
                    {{ __('main.back') }}
                </a>
            </div>
        </div>
    </div>
@endsection
