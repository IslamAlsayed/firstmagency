@extends('dashboard.layout.master')

@section('title', $officialDomain->translations[app()->getLocale()]['badge'] ?? 'Official Domain')
@section('page-title', '🌐 ' . limitedText($officialDomain->translations[app()->getLocale()]['badge'] ?? '', 30))

@section('content')
    <div class="shadow-md radius-lg p-6">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $officialDomain->translations[app()->getLocale()]['badge'] ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $officialDomain->creator?->name ?? 'N/A' }} • {{ $officialDomain->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $officialDomain)
                    <a href="{{ route('dashboard.official-domains.edit', $officialDomain->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.official-domains.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.official_domains')]) }}
                </a>
            </div>
        </div>

        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.official_domain')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $officialDomain->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($officialDomain->creator)
                                    <a href="{{ route('dashboard.users.show', $officialDomain->creator->id) }}" class="text-primary hover:underline">
                                        {{ $officialDomain->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $officialDomain->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ __('main.status') }}
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($officialDomain->status === 'published') bg-green-100 text-green-800
                            @elseif($officialDomain->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ __('main.' . $officialDomain->status) }}
                                </span>
                            </p>
                            @include('dashboard.components.status-actions', [
                                'record' => $officialDomain,
                                'models' => 'official-domains',
                                'modelClass' => 'officialDomain',
                                'availableOptions' => array_column(\App\Enum\PestDomainEnums::cases(), 'value'),
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $officialDomain->id,
                                'field' => 'is_active',
                                'value' => (bool) $officialDomain->is_active,
                                'modelClass' => 'officialDomain',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.official_domain_content') }}</h3>
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
                            <p class="text-gray-700 leading-relaxed">{!! $officialDomain->translations['en']['badge'] ?? '-' !!}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $officialDomain->translations['en']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <!-- Arabic Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.name') }}</p>
                            <p class="text-gray-700 leading-relaxed">{!! $officialDomain->translations['ar']['badge'] ?? '-' !!}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $officialDomain->translations['ar']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <div class="grid flex flex-wrap gap-4 mt-6 pt-6 border-t">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.order') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $officialDomain->order ?? 0 }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.slug') }}</label>
                            <p class="text-sm text-gray-800 font-mono">{{ $officialDomain->slug }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logo -->
            @if (!empty($officialDomain->image))
                @include('dashboard.components.display-photo', [
                    'record' => $officialDomain,
                    'column' => 'image',
                    'alt' => $officialDomain->alt_text ?? ($officialDomain->translations[app()->getLocale()]['badge'] ?? 'Official Domain Logo'),
                ])
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $officialDomain])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $officialDomain)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.official-domains',
                        'id' => $officialDomain->id,
                    ])
                @endcan
                @can('delete', $officialDomain)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.official-domains',
                        'modelClass' => 'officialDomain',
                        'id' => $officialDomain->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.official-domains.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.official_domains')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
