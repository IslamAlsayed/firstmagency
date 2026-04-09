@extends('dashboard.layout.master')

@section('title', $service->slug)
@section('page-title', '📄 ' . $service->slug)

@section('content')
    <div class="shadow-md radius-lg p-6">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $service->slug }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $service->author?->name ?? 'N/A' }} • {{ $service->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @if (getActiveUser()->can('update', $service))
                    <a href="{{ route('dashboard.services.edit', $service->id) }}" class="kt-btn kt-btn-primary md:hidden" toggle-button>
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endif
                <a href="{{ route('dashboard.services.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_types', ['types' => __('main.services')]) }}
                </a>
            </div>
        </div>

        <div class="grid gap-4 lg:gap-6">
            <!-- Main Content -->
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.service')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $service->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($service->creator)
                                    <a href="{{ route('dashboard.users.show', $service->creator->id) }}" class="text-primary hover:underline">
                                        {{ $service->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $service->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $service->id,
                                'field' => 'is_active',
                                'value' => (bool) $service->is_active,
                                'modelClass' => 'service',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Translations with Language Tabs -->
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title"><i class="fas fa-language mr-2"></i>{{ __('main.translations') }}</h3>
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
                        <div class="grid gap-4">
                            <div>
                                <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                                <p class="font-semibold text-gray-800">{{ $service->translations['en']['title'] ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                                <p class="text-gray-700 leading-relaxed">{!! $service->translations['en']['description'] ?? '-' !!}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('main.content') }}</p>
                                <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $service->translations['en']['content'] ?? '-' !!}</div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('main.keywords') }}</p>
                                    <p class="text-gray-700">{{ $service->translations['en']['keywords'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('main.meta_description') }}</p>
                                    <p class="text-gray-700">{{ $service->translations['en']['meta_description'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Arabic Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div class="grid gap-4">
                            <div>
                                <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                                <p class="font-semibold text-gray-800">{{ $service->translations['ar']['title'] ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                                <p class="text-gray-700 leading-relaxed">{!! $service->translations['ar']['description'] ?? '-' !!}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('main.content') }}</p>
                                <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $service->translations['ar']['content'] ?? '-' !!}</div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('main.keywords') }}</p>
                                    <p class="text-gray-700">{{ $service->translations['ar']['keywords'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('main.meta_description') }}</p>
                                    <p class="text-gray-700">{{ $service->translations['ar']['meta_description'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Files -->
            @if (!empty($service->icon))
                @include('dashboard.components.display-photo', [
                    'record' => $service,
                    'column' => 'icon',
                    'alt' => $service->title . ' Icon',
                ])
            @endif

            <!-- Media Files -->
            @if (!empty($service->image))
                @include('dashboard.components.display-photo', [
                    'record' => $service,
                    'column' => 'image',
                    'alt' => $service->title . ' Image',
                ])
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $service])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $service)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.services',
                        'id' => $service->id,
                    ])
                @endcan
                @can('delete', $service)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.services',
                        'modelClass' => 'service',
                        'id' => $service->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.services.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_types', ['types' => __('main.services')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
