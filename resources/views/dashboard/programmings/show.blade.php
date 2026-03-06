@extends('dashboard.layout.master')

@section('title', __('main.programming_details'))
@section('page-title', '💻 ' . limitedText($programming->translations[app()->getLocale()]['name'] ?? '', 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $programming->translations[app()->getLocale()]['name'] ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $programming->creator?->name ?? 'N/A' }} • {{ $programming->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $programming)
                    <a href="{{ route('dashboard.programmings.edit', $programming->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.programmings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.programmings')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.programming')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $programming->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($programming->creator)
                                    <a href="{{ route('dashboard.users.show', $programming->creator->id) }}" class="text-primary hover:underline">
                                        {{ $programming->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $programming->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.status') }}</p>
                            <p class="text-sm text-secondary-foreground">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($programming->status === 'published') bg-green-100 text-green-800
                            @elseif($programming->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ __('main.' . $programming->status) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $programming->id,
                                'field' => 'is_active',
                                'value' => (bool) $programming->is_active,
                                'modelClass' => 'programming',
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.featured') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $programming->id,
                                'field' => 'is_featured',
                                'value' => (bool) $programming->is_featured,
                                'modelClass' => 'programming',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image -->
            @if (!empty($programming->image))
                @include('dashboard.components.display-photo', [
                    'record' => $programming,
                    'column' => 'image',
                    'alt' => $programming->translations[app()->getLocale()]['name'] ?? 'Programming',
                ])
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $programming)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.programmings',
                        'id' => $programming->id,
                    ])
                @endcan
                @can('delete', $programming)
                    @include('dashboard.components.delete-form', [
                        'model' => 'dashboard.programmings',
                        'id' => $programming->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.programmings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.programmings')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
