@extends('dashboard.layout.master')

@section('title', $pestDomain->alt_text ?? 'Pest Domain')
@section('page-title', '🌐 ' . limitedText($pestDomain->alt_text ?? '', 30))

@section('content')
    <div class="shadow-md radius-lg p-6">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $pestDomain->alt_text ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $pestDomain->creator?->name ?? 'N/A' }} • {{ $pestDomain->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $pestDomain)
                    <a href="{{ route('dashboard.pest-domains.edit', $pestDomain->id) }}" class="kt-btn kt-btn-primary md:hidden" toggle-button>
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.pest-domains.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_types', ['types' => __('main.pest_domains')]) }}
                </a>
            </div>
        </div>

        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.pest_domain')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $pestDomain->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($pestDomain->creator)
                                    <a href="{{ route('dashboard.users.show', $pestDomain->creator->id) }}" class="text-primary hover:underline">
                                        {{ $pestDomain->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $pestDomain->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ __('main.status') }}
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($pestDomain->status === 'published') bg-green-100 text-green-800
                            @elseif($pestDomain->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ __('main.' . $pestDomain->status) }}
                                </span>
                            </p>
                            @include('dashboard.components.status-actions', [
                                'record' => $pestDomain,
                                'models' => 'pest-domains',
                                'modelClass' => 'pestDomain',
                                'availableOptions' => array_column(\App\Enum\PestDomainEnums::cases(), 'value'),
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $pestDomain->id,
                                'field' => 'is_active',
                                'value' => (bool) $pestDomain->is_active,
                                'modelClass' => 'pest_domain',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.pest_domain_content') }}</h3>
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 pt-6 border-t">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.order') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $pestDomain->order ?? 0 }}</p>
                        </div>

                        <div class="col-span-1 sm:col-span-2">
                            <label class="kt-label mb-1">{{ __('main.slug') }}</label>
                            <p class="text-sm text-gray-800 font-mono">{{ $pestDomain->slug }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logo -->
            @if (!empty($pestDomain->image))
                @include('dashboard.components.display-photo', [
                    'record' => $pestDomain,
                    'column' => 'image',
                    'alt' => $pestDomain->alt_text ?? 'Pest Domain Logo',
                ])
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $pestDomain])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $pestDomain)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.pest-domains',
                        'id' => $pestDomain->id,
                    ])
                @endcan
                @can('delete', $pestDomain)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.pest-domains',
                        'modelClass' => 'pestDomain',
                        'id' => $pestDomain->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.pest-domains.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_types', ['types' => __('main.pest_domains')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
