@extends('dashboard.layout.master')

@section('title', __('main.our_programming_details'))
@section('page-title', '💻 ' . limitedText($ourProgramming->alt_text ?? 'Our Programming', 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $ourProgramming->alt_text ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $ourProgramming->creator?->name ?? 'N/A' }} • {{ $ourProgramming->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $ourProgramming)
                    <a href="{{ route('dashboard.our-programmings.edit', $ourProgramming->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.our-programmings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.our_programmings')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.our_programming')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.alt_text') }}</p>
                            <p class="font-semibold text-gray-800">{{ $ourProgramming->alt_text ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $ourProgramming->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($ourProgramming->creator)
                                    <a href="{{ route('dashboard.users.show', $ourProgramming->creator->id) }}" class="text-primary hover:underline">
                                        {{ $ourProgramming->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $ourProgramming->created_at?->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $ourProgramming->id,
                                'field' => 'is_active',
                                'value' => (bool) $ourProgramming->is_active,
                                'modelClass' => 'ourProgramming',
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.featured') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $ourProgramming->id,
                                'field' => 'is_featured',
                                'value' => (bool) $ourProgramming->is_featured,
                                'modelClass' => 'ourProgramming',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image -->
            @if (!empty($ourProgramming->image))
                @include('dashboard.components.display-photo', [
                    'record' => $ourProgramming,
                    'column' => 'image',
                    'alt' => $ourProgramming->alt_text ?? 'Our Programming',
                ])
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $ourProgramming)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.our-programmings',
                        'id' => $ourProgramming->id,
                    ])
                @endcan
                @can('delete', $ourProgramming)
                    @include('dashboard.components.delete-form', [
                        'model' => 'dashboard.our-programmings',
                        'id' => $ourProgramming->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.our-programmings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.our_programmings')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
