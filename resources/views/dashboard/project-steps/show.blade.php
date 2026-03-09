@extends('dashboard.layout.master')

@section('title', __('main.project_step_details'))
@section('page-title', '📋 ' . limitedText($projectStep->translations[app()->getLocale()]['title'] ?? 'Project Step', 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $projectStep->translations[app()->getLocale()]['title'] ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $projectStep->creator?->name ?? 'N/A' }} • {{ $projectStep->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $projectStep)
                    <a href="{{ route('dashboard.project-steps.edit', $projectStep->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.project-steps.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.project_steps')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Arabic Content --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">🇸🇦 {{ __('main.arabic_content') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                            <p class="font-semibold text-gray-800">{{ $projectStep->translations['ar']['title'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.icon') }}</p>
                            <p class="font-semibold text-gray-800">
                                <i class="{{ $projectStep->icon ?? 'fas fa-folder' }}"></i>
                                {{ $projectStep->icon ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $projectStep->order ?? 0 }}</p>
                        </div>
                    </div>

                    @if (!empty($projectStep->translations['ar']['content']))
                        <div>
                            <p class="text-sm text-gray-500 mb-2">{{ __('main.content') }}</p>
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $projectStep->translations['ar']['content'] }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- English Content --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">🇬🇧 {{ __('main.english_content') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                            <p class="font-semibold text-gray-800">{{ $projectStep->translations['en']['title'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.icon') }}</p>
                            <p class="font-semibold text-gray-800">
                                <i class="{{ $projectStep->icon ?? 'fas fa-folder' }}"></i>
                                {{ $projectStep->icon ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $projectStep->order ?? 0 }}</p>
                        </div>
                    </div>

                    @if (!empty($projectStep->translations['en']['content']))
                        <div>
                            <p class="text-sm text-gray-500 mb-2">{{ __('main.content') }}</p>
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $projectStep->translations['en']['content'] }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $projectStep)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.project-steps',
                        'id' => $projectStep->id,
                    ])
                @endcan
                @can('delete', $projectStep)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.project-steps',
                        'modelClass' => 'projectStep',
                        'id' => $projectStep->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.project-steps.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.project_steps')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
