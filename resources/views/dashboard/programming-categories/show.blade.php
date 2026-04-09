@extends('dashboard.layout.master')

@section('title', __('main.type_details', ['type' => __('main.programming_category')]))
@section('page-title', '💻 ' . limitedText($programmingCategory->alt_text ?? __('main.programming_category'), 30))

@section('content')
    <div class="shadow-md radius-lg p-6">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $programmingCategory->alt_text ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $programmingCategory->creator?->name ?? 'N/A' }} • {{ $programmingCategory->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $programmingCategory)
                    <a href="{{ route('dashboard.programming-categories.edit', $programmingCategory->id) }}" class="kt-btn kt-btn-primary md:hidden" toggle-button>
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.programming-categories.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_types', ['types' => __('main.programming_categories')]) }}
                </a>
            </div>
        </div>

        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.programming_category')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.alt_text') }}</p>
                            <p class="font-semibold text-gray-800">{{ $programmingCategory->alt_text ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $programmingCategory->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($programmingCategory->creator)
                                    <a href="{{ route('dashboard.users.show', $programmingCategory->creator->id) }}" class="text-primary hover:underline">
                                        {{ $programmingCategory->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $programmingCategory->created_at?->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $programmingCategory->id,
                                'field' => 'is_active',
                                'value' => (bool) $programmingCategory->is_active,
                                'modelClass' => 'programmingCategory',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image -->
            @if (!empty($programmingCategory->image))
                @include('dashboard.components.display-photo', [
                    'record' => $programmingCategory,
                    'column' => 'image',
                    'alt' => $programmingCategory->alt_text ?? 'Our Programming',
                ])
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $programmingCategory)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.programming-categories',
                        'id' => $programmingCategory->id,
                    ])
                @endcan
                @can('delete', $programmingCategory)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.programming-categories',
                        'modelClass' => 'programmingCategory',
                        'id' => $programmingCategory->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.programming-categories.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_types', ['types' => __('main.programming_categories')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
