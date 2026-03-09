@extends('dashboard.layout.master')

@section('title', $dashboardsAndSystem->translations[app()->getLocale()]['title'] ?? 'Dashboard/System')
@section('page-title', '🔧 ' . limitedText($dashboardsAndSystem->translations[app()->getLocale()]['title'] ?? 'Dashboard/System', 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $dashboardsAndSystem->translations[app()->getLocale()]['title'] ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $dashboardsAndSystem->creator?->name ?? 'N/A' }} • {{ $dashboardsAndSystem->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @if (getActiveUser()->can('update', $dashboardsAndSystem))
                    <a href="{{ route('dashboard.dashboards-and-systems.edit', $dashboardsAndSystem->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endif
                <a href="{{ route('dashboard.dashboards-and-systems.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.dashboards_and_apps')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.dashboards_and_app')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.slug') }}</p>
                            <p class="font-semibold text-gray-800 break-all">{{ $dashboardsAndSystem->slug ?? '--' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.type') }}</p>
                            <p class="font-semibold text-gray-800">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                    {{ $dashboardsAndSystem->type ?? '--' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $dashboardsAndSystem->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($dashboardsAndSystem->creator)
                                    <a href="{{ route('dashboard.users.show', $dashboardsAndSystem->creator->id) }}" class="text-primary hover:underline">
                                        {{ $dashboardsAndSystem->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $dashboardsAndSystem->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.updated_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $dashboardsAndSystem->updated_at?->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Card -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.content') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Language Tabs -->
                    <div class="flex gap-4 mb-6">
                        @foreach (array_keys(config('languages')) as $lang)
                            <button type="button"
                                class="language-tab cursor-pointer {{ $loop->first ? 'border-b-2 text-gray-900 font-semibold' : 'border-transparent text-gray-600' }} pb-2 px-2"
                                data-lang="{{ $lang }}">
                                {{ config("languages.$lang.flag") }} {{ __('main.' . $lang . '_content') }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Language Content -->
                    @foreach (array_keys(config('languages')) as $lang)
                        <div class="language-content{{ $loop->first ? '' : ' hidden' }}" data-lang="{{ $lang }}">
                            <div>
                                <p class="text-sm text-gray-500 mb-2">{{ __('main.title') }}</p>
                                <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">
                                    {{ $dashboardsAndSystem->translations[$lang]['title'] ?? '-' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Media Files -->
            @if (!empty($dashboardsAndSystem->image))
                @include('dashboard.components.display-photo', [
                    'record' => $dashboardsAndSystem,
                    'column' => 'image',
                    'alt' => $dashboardsAndSystem->translations[app()->getLocale()]['title'] ?? 'Image',
                ])
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $dashboardsAndSystem])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $dashboardsAndSystem)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.dashboards-and-systems',
                        'id' => $dashboardsAndSystem->id,
                    ])
                @endcan
                @can('delete', $dashboardsAndSystem)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.dashboards-and-systems',
                        'modelClass' => 'dashboardsAndSystem',
                        'id' => $dashboardsAndSystem->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.dashboards-and-systems.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.dashboards_and_apps')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
