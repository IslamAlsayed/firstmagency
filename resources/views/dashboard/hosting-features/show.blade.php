@extends('dashboard.layout.master')

@section('title', __('main.view_type', ['type' => __('main.hosting_feature')]))
@section('page-title', '👁️ ' . __('main.view_type', ['type' => __('main.hosting_feature')]))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $hostingFeature->translations[app()->getLocale()]['title'] ?? '--' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $hostingFeature->creator?->name ?? 'N/A' }} • {{ $hostingFeature->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @if (getActiveUser()->can('update', $hostingFeature))
                    <a href="{{ route('dashboard.hosting-features.edit', $hostingFeature->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endif
                <a href="{{ route('dashboard.hosting-features.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.hosting_features')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.hosting_feature')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $hostingFeature->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($hostingFeature->creator)
                                    <a href="{{ route('dashboard.users.show', $hostingFeature->creator->id) }}" class="text-primary hover:underline">
                                        {{ $hostingFeature->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $hostingFeature->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.hosting_feature_information') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Language Tabs -->
                    <div class="flex gap-4 mb-6">
                        @foreach (array_keys(config('languages')) as $lang)
                            <button type="button" class="language-tab cursor-pointer {{ $loop->first ? 'border-b-2 text-gray-900 font-semibold' : 'border-transparent text-gray-600' }} pb-2 px-2"
                                data-lang="{{ $lang }}">
                                {{ config("languages.$lang.flag") }} {{ __('main.' . $lang . '_content') }}
                            </button>
                        @endforeach
                    </div>

                    <!-- English Content -->
                    <div class="language-content" data-lang="en">
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">
                                {{ $hostingFeature->translations['en']['title'] ?? '-' }}</div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $hostingFeature->translations['en']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <!-- Arabic Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">
                                {{ $hostingFeature->translations['ar']['title'] ?? '-' }}</div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $hostingFeature->translations['ar']['description'] ?? '-' !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Files -->
            @if (!empty($hostingFeature->image))
                @include('dashboard.components.display-photo', [
                    'record' => $hostingFeature,
                    'column' => 'image',
                    'alt' => $hostingFeature->translations[app()->getLocale()]['title'] . ' Image',
                ])
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $hostingFeature])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $hostingFeature)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.hosting-features',
                        'id' => $hostingFeature->id,
                    ])
                @endcan
                @can('delete', $hostingFeature)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.hosting-features',
                        'modelClass' => 'hostingFeature',
                        'id' => $hostingFeature->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.hosting-features.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.hosting_features')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
