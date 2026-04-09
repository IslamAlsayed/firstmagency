@extends('dashboard.layout.master')

@section('title', $partner->translations[app()->getLocale()]['name'] ?? 'Partner')
@section('page-title', '🤝 ' . limitedText($partner->translations[app()->getLocale()]['name'] ?? '', 30))

@section('content')
    <div class="shadow-md radius-lg p-6">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $partner->translations[app()->getLocale()]['name'] ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $partner->creator?->name ?? 'N/A' }} • {{ $partner->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $partner)
                    <a href="{{ route('dashboard.partners.edit', $partner->id) }}" class="kt-btn kt-btn-primary md:hidden" toggle-button>
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.partners.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_types', ['types' => __('main.partners')]) }}
                </a>
            </div>
        </div>

        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.partner')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $partner->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($partner->creator)
                                    <a href="{{ route('dashboard.users.show', $partner->creator->id) }}" class="text-primary hover:underline">
                                        {{ $partner->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $partner->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.status') }}</p>
                            <p class="text-sm text-secondary-foreground">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($partner->status === 'published') bg-green-100 text-green-800
                            @elseif($partner->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ __('main.' . $partner->status) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $partner->id,
                                'field' => 'is_active',
                                'value' => (bool) $partner->is_active,
                                'modelClass' => 'partner',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.partner_content') }}</h3>
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
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.name') }}</p>
                            <p class="text-gray-700 leading-relaxed">{!! $partner->translations['en']['name'] ?? '-' !!}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $partner->translations['en']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <!-- Arabic Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.name') }}</p>
                            <p class="text-gray-700 leading-relaxed">{!! $partner->translations['ar']['name'] ?? '-' !!}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $partner->translations['ar']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 pt-6 border-t">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.website') }}</label>
                            @if ($partner->website)
                                <a href="{{ $partner->website }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                    {{ $partner->website }}
                                </a>
                            @else
                                <p class="text-sm text-gray-400">-</p>
                            @endif
                        </div>

                        <div>
                            <label class="kt-label mb-1">{{ __('main.order') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $partner->order ?? 0 }}</p>
                        </div>

                        <div class="col-span-1 sm:col-span-2">
                            <label class="kt-label mb-1">{{ __('main.slug') }}</label>
                            <p class="text-sm text-gray-800 font-mono">{{ $partner->slug }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logo -->
            @if (!empty($partner->image))
                @include('dashboard.components.display-photo', [
                    'record' => $partner,
                    'column' => 'image',
                    'alt' => $partner->alt_text ?? ($partner->translations[app()->getLocale()]['name'] ?? 'Partner Logo'),
                ])
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $partner])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $partner)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.partners',
                        'id' => $partner->id,
                    ])
                @endcan
                @can('delete', $partner)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.partners',
                        'modelClass' => 'partner',
                        'id' => $partner->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.partners.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_types', ['types' => __('main.partners')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
