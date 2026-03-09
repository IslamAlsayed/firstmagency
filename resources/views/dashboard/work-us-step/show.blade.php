@extends('dashboard.layout.master')

@section('title', __('main.view_type', ['type' => __('main.work_us_step')]))
@section('page-title', '👔 ' . __('main.view_type', ['type' => __('main.work_us_step')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.view_type', ['type' => __('main.work_us_step')]) }}</h3>

            <div class="flex gap-2">
                <a href="{{ route('dashboard.work-us-step.edit', $workUsStep->id) }}" class="kt-btn kt-btn-outline-info">
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.work-us-step.index') }}" class="kt-btn kt-btn-outline-primary">
                    {{ __('main.back_to_work_us_step') }}
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
                            {{ $workUsStep->translations['en']['title'] ?? '--' }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.description') }}</label>
                        <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-800 whitespace-pre-wrap">
                            {{ $workUsStep->translations['en']['description'] ?? '--' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Arabic Tab Content -->
            <div class="language-content hidden mt-4" data-lang="ar">
                <div class="grid gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.title') }}</label>
                        <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-800">
                            {{ $workUsStep->translations['ar']['title'] ?? '--' }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.description') }}</label>
                        <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-800 whitespace-pre-wrap">
                            {{ $workUsStep->translations['ar']['description'] ?? '--' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Image Display -->
            @if ($workUsStep->image && checkExistFile($workUsStep->image))
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-600 mb-3">{{ __('main.image') }}</label>
                    <div class="border border-gray-300 rounded-lg overflow-hidden max-w-md">
                        <img src="{{ asset('storage/' . $workUsStep->image) }}"
                            alt="{{ $workUsStep->alt_text ?? ($workUsStep->translations[app()->getLocale()]['title'] ?? '') }}" class="w-full h-auto">
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-4 border-t pt-6">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.alt_text') }}</label>
                    <p class="mt-1 text-sm text-gray-800">{{ $workUsStep->alt_text ?? '--' }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.order') }}</label>
                    <p class="mt-1 text-sm text-gray-800">{{ $workUsStep->order ?? 0 }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.status') }}</label>
                    <p class="mt-1">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($workUsStep->status === 'published') bg-green-100 text-green-800
                            @elseif($workUsStep->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ __('main.' . $workUsStep->status) }}
                        </span>
                    </p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.active') }}</label>
                    <p class="mt-1">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                            @if ($workUsStep->is_active) bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            @if ($workUsStep->is_active)
                                <i class="fas fa-check"></i> {{ __('main.yes') }}
                            @else
                                <i class="fas fa-times"></i> {{ __('main.no') }}
                            @endif
                        </span>
                    </p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.featured') }}</label>
                    <p class="mt-1">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                            @if ($workUsStep->is_featured) bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            @if ($workUsStep->is_featured)
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
                        @if ($workUsStep->creator)
                            <a href="{{ route('dashboard.users.show', $workUsStep->creator->id) }}" class="text-primary hover:underline text-sm">
                                {{ $workUsStep->creator->name }}
                            </a>
                        @else
                            <span class="text-gray-400 italic text-sm">N/A</span>
                        @endif
                    </p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.created_at') }}</label>
                    <p class="mt-1 text-sm text-gray-800">{{ $workUsStep->created_at?->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase">{{ __('main.updated_at') }}</label>
                    <p class="mt-1 text-sm text-gray-800">{{ $workUsStep->updated_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
