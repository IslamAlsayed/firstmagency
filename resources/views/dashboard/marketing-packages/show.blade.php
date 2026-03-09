@extends('dashboard.layout.master')

@section('title', __('main.view_type', ['type' => __('main.marketing_package')]))
@section('page-title', '📦 ' . __('main.view_type', ['type' => __('main.marketing_package')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.view_type', ['type' => __('main.marketing_package')]) }}</h3>

            <div class="flex gap-2">
                <a href="{{ route('dashboard.marketing-packages.edit', $marketingPackage->id) }}" class="kt-btn kt-btn-outline-info">
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.marketing-packages.index') }}" class="kt-btn kt-btn-outline-primary">
                    {{ __('main.back_to_marketing_package') }}
                </a>
            </div>
        </div>

        <div class="kt-card-body p-4">
            <!-- Tabs Navigation -->
            @include('dashboard.components.tabs-navigation')

            <!-- English Tab Content -->
            <div class="language-content mt-4" data-lang="en">
                <div class="grid gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.title') }}</label>
                        <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-800">
                            {{ $marketingPackage->translations['en']['title'] ?? '--' }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.description') }}</label>
                        <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-800 whitespace-pre-wrap">
                            {{ $marketingPackage->translations['en']['description'] ?? '--' }}
                        </p>
                    </div>

                    @if ($marketingPackage->features && is_array($marketingPackage->features) && count($marketingPackage->features) > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.features') }}</label>
                            <div class="px-4 py-2 bg-gray-50 rounded-lg">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($marketingPackage->features as $feature)
                                        <li class="text-gray-800">
                                            <strong>{{ $feature['title_' . app()->getLocale()] ?? ($feature['title_ar'] ?? '') }}:</strong>
                                            {{ $feature['label_' . app()->getLocale()] ?? ($feature['label_ar'] ?? '') }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Arabic Tab Content -->
            <div class="language-content hidden mt-4" data-lang="ar">
                <div class="grid gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.title') }}</label>
                        <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-800">
                            {{ $marketingPackage->translations['ar']['title'] ?? '--' }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.description') }}</label>
                        <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-800 whitespace-pre-wrap">
                            {{ $marketingPackage->translations['ar']['description'] ?? '--' }}
                        </p>
                    </div>

                    @if ($marketingPackage->features && is_array($marketingPackage->features) && count($marketingPackage->features) > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.features') }}</label>
                            <div class="px-4 py-2 bg-gray-50 rounded-lg">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($marketingPackage->features as $feature)
                                        <li class="text-gray-800">
                                            <strong>{{ $feature['title_ar'] ?? '' }}:</strong>
                                            {{ $feature['label_ar'] ?? '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Image Display -->
            @if ($marketingPackage->image && checkExistFile($marketingPackage->image))
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-600 mb-3">{{ __('main.image') }}</label>
                    <div class="border border-gray-300 rounded-lg overflow-hidden max-w-md">
                        <img src="{{ asset('storage/' . $marketingPackage->image) }}"
                            alt="{{ $marketingPackage->alt_text ?? ($marketingPackage->translations[app()->getLocale()]['title'] ?? '') }}" class="w-full h-auto">
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-4 border-t pt-6">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.category') }}</label>
                    <p class="mt-1 text-sm text-gray-800">{{ $marketingPackage->category ?? 'marketing' }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.monthly_price') }}</label>
                    <p class="mt-1 text-sm text-gray-800">${{ number_format($marketingPackage->monthly_price, 2) }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.yearly_price') }}</label>
                    <p class="mt-1 text-sm text-gray-800">${{ number_format($marketingPackage->yearly_price, 2) }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.alt_text') }}</label>
                    <p class="mt-1 text-sm text-gray-800">{{ $marketingPackage->alt_text ?? '--' }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.order') }}</label>
                    <p class="mt-1 text-sm text-gray-800">{{ $marketingPackage->order ?? 0 }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.active') }}</label>
                    <p class="mt-1">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                            @if ($marketingPackage->is_active) bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            @if ($marketingPackage->is_active)
                                <i class="fas fa-check"></i> {{ __('main.yes') }}
                            @else
                                <i class="fas fa-times"></i> {{ __('main.no') }}
                            @endif
                        </span>
                    </p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.popular') }}</label>
                    <p class="mt-1">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                            @if ($marketingPackage->is_popular) bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            @if ($marketingPackage->is_popular)
                                <i class="fas fa-star"></i> {{ __('main.yes') }}
                            @else
                                <i class="fas fa-circle-notch"></i> {{ __('main.no') }}
                            @endif
                        </span>
                    </p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.created_by') }}</label>
                    <p class="mt-1">
                        @if ($marketingPackage->creator)
                            <a href="{{ route('dashboard.users.show', $marketingPackage->creator->id) }}" class="text-primary hover:underline text-sm">
                                {{ $marketingPackage->creator->name }}
                            </a>
                        @else
                            <span class="text-gray-400 italic text-sm">N/A</span>
                        @endif
                    </p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.created_at') }}</label>
                    <p class="mt-1 text-sm text-gray-800">{{ $marketingPackage->created_at?->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.updated_at') }}</label>
                    <p class="mt-1 text-sm text-gray-800">{{ $marketingPackage->updated_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
