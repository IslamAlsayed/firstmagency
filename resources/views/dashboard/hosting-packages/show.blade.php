@extends('dashboard.layout.master')

@section('title', limitedText($hostingPackage->translations[app()->getLocale()]['title'] ?? '--', 50))
@section('page-title', '📦 ' . limitedText($hostingPackage->translations[app()->getLocale()]['title'] ?? '--', 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $hostingPackage->translations[app()->getLocale()]['title'] ?? '--' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $hostingPackage->creator?->name ?? 'N/A' }} • {{ $hostingPackage->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @if (getActiveUser()->can('update', $hostingPackage))
                    <a href="{{ route('dashboard.hosting-packages.edit', $hostingPackage->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endif
                <a href="{{ route('dashboard.hosting-packages.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.hosting_packages')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.hosting_package')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.category') }}</p>
                            <p class="font-semibold text-gray-800">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                @if ($hostingPackage->category === 'hosting') bg-blue-100 text-blue-800
                                @elseif($hostingPackage->category === 'reseller') bg-green-100 text-green-800
                                @elseif($hostingPackage->category === 'vps') bg-purple-100 text-purple-800
                                @else bg-orange-100 text-orange-800 @endif">
                                    {{ __('main.' . str_replace('-', '_', $hostingPackage->category)) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.monthly_price') }}</p>
                            <p class="font-semibold text-gray-800">${{ number_format($hostingPackage->monthly_price, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.yearly_price') }}</p>
                            <p class="font-semibold text-gray-800">${{ number_format($hostingPackage->yearly_price, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $hostingPackage->order ?? 0 }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($hostingPackage->creator)
                                    <a href="{{ route('dashboard.users.show', $hostingPackage->creator->id) }}" class="text-primary hover:underline">
                                        {{ $hostingPackage->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $hostingPackage->created_at?->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-2">{{ __('main.popular') }}</p>
                            @if ($hostingPackage->is_popular)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-star mr-1"></i>{{ __('main.yes') }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">{{ __('main.no') }}</span>
                            @endif
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $hostingPackage->id,
                                'field' => 'is_active',
                                'value' => (bool) $hostingPackage->is_active,
                                'modelClass' => 'hostingPackage',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.package_content') }}</h3>
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

                    <!-- Content for each Language -->
                    @foreach (array_keys(config('languages')) as $lang)
                        <div class="language-content" data-lang="{{ $lang }}" style="display: {{ $loop->first ? 'block' : 'none' }};">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                                    <div class="text-gray-700 bg-white p-3 rounded border border-gray-200">
                                        {{ $hostingPackage->translations[$lang]['title'] ?? '-' }}</div>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                                    <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">
                                        {!! nl2br($hostingPackage->translations[$lang]['description'] ?? '-') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pricing Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.monthly_price') }}</label>
                            <p class="text-lg font-bold text-blue-600">${{ number_format($hostingPackage->monthly_price, 2) }}</p>
                        </div>

                        <div>
                            <label class="kt-label mb-1">{{ __('main.yearly_price') }}</label>
                            <p class="text-lg font-bold text-green-600">${{ number_format($hostingPackage->yearly_price, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            @if (!empty($hostingPackage->features) && count($hostingPackage->features) > 0)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.features') }} ({{ count($hostingPackage->features) }})</h3>
                    </div>

                    <div class="kt-card-body p-4">
                        <div class="space-y-3">
                            @foreach ($hostingPackage->features as $index => $feature)
                                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs font-semibold text-gray-600 mb-1">{{ config('languages.en.flag') }} English</p>
                                            <p class="font-semibold text-gray-800">{{ $feature['title_en'] ?? '-' }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $feature['label_en'] ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-600 mb-1">{{ config('languages.ar.flag') }} Arabic</p>
                                            <p class="font-semibold text-gray-800">{{ $feature['title_ar'] ?? '-' }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $feature['label_ar'] ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Media Files -->
            @if (!empty($hostingPackage->image))
                @include('dashboard.components.display-photo', [
                    'record' => $hostingPackage,
                    'column' => 'image',
                    'alt' => $hostingPackage->translations[app()->getLocale()]['title'] . ' Image',
                ])
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $hostingPackage])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $hostingPackage)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.hosting-packages',
                        'id' => $hostingPackage->id,
                    ])
                @endcan
                @can('delete', $hostingPackage)
                    <a href="{{ route('dashboard.deleteRecord', ['modelClass' => 'hosting-packages', 'id' => $hostingPackage->id]) }}"
                        class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white delete-btn">
                        @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                            {{ __('main.delete') }}
                        @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                            <i class="fas fa-trash-can text-white"></i>
                        @else
                            <i class="fas fa-trash-can text-white"></i>
                            {{ __('main.delete') }}
                        @endif
                    </a>
                @endcan
                <a href="{{ route('dashboard.hosting-packages.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.hosting_packages')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
