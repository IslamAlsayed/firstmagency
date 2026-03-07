@extends('dashboard.layout.master')

@section('title', __('main.view_type', ['type' => __('main.features_hosting')]))
@section('page-title', '👁️ ' . __('main.view_type', ['type' => __('main.features_hosting')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.view_type', ['type' => __('main.features_hosting')]) }}</h3>

            <div class="flex gap-2">
                <a href="{{ route('dashboard.features-hostings.edit', $featuresHosting->id) }}" class="kt-btn kt-btn-outline-secondary">
                    <i class="fas fa-edit mr-2"></i>{{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.features-hostings.index') }}" class="kt-btn kt-btn-outline-primary">
                    {{ __('main.back_to_types', ['types' => __('main.features_hostings')]) }}
                </a>
            </div>
        </div>

        <div class="kt-card-body p-4">
            <div class="grid gap-6">
                <!-- Image -->
                @if ($featuresHosting->image)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('main.image') }}</label>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <img src="{{ asset('storage/' . $featuresHosting->image) }}" class="max-w-md rounded-lg shadow">
                        </div>
                    </div>
                @endif

                <!-- Order -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('main.order') }}</label>
                        <p class="text-gray-600">{{ $featuresHosting->order }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('main.created_by') }}</label>
                        <p class="text-gray-600">{{ $featuresHosting->creator?->name ?? '--' }}</p>
                    </div>
                </div>

                <!-- Arabic Content -->
                <div class="border-t pt-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">🇸🇦 {{ __('main.ar_content') }}</h4>
                    <div class="grid gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('main.title') }}</label>
                            <p class="text-gray-600">{{ $featuresHosting->translations['ar']['title'] ?? '--' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('main.description') }}</label>
                            <p class="text-gray-600 whitespace-pre-wrap">{{ $featuresHosting->translations['ar']['description'] ?? '--' }}</p>
                        </div>
                    </div>
                </div>

                <!-- English Content -->
                <div class="border-t pt-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">🇬🇧 {{ __('main.en_content') }}</h4>
                    <div class="grid gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('main.title') }}</label>
                            <p class="text-gray-600">{{ $featuresHosting->translations['en']['title'] ?? '--' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('main.description') }}</label>
                            <p class="text-gray-600 whitespace-pre-wrap">{{ $featuresHosting->translations['en']['description'] ?? '--' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
