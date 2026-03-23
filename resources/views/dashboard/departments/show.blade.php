@extends('dashboard.layout.master')

@section('title', __('main.department'))
@section('page-title', '🏢 ' . __('main.department'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded" style="background-color: {{ $department->bg_color ?? '#ccc' }}; border: 2px solid {{ $department->border_color ?? '#999' }};"></div>
                    <h1 class="text-xl font-medium leading-none text-mono">
                        {{ $department->user->name ?? __('main.department') }}
                    </h1>
                </div>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    🏢 {{ __('main.department') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.departments.edit', $department->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.departments.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.departments')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Support User Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.support_user')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($department->user)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $department->user->name ?: __('main.na') }}</p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="mailto:{{ $department->user->email }}" target="_blank" class="inline-block text-blue-600 hover:underline text-xs font-medium">
                                        {!! limitedText($department->user->email ?? '--', 30) !!}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                </p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $department->user->phone }}" target="_blank" class="inline-block text-blue-600 hover:underline text-xs font-medium">
                                        {!! limitedText($department->user->phone ?? '--', 30) !!}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                </p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.role') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $department->user->role }}
                                    </span>
                                </p>
                            </div>
                        @else
                            <div colspan="4" class="text-center text-gray-400">
                                {{ __('main.na') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colors Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.styling') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.bg_color') }}</label>
                            <div class="flex items-center gap-2">
                                <div class="w-12 h-12 rounded border-2" style="background-color: {{ $department->bg_color ?? '#ccc' }};"></div>
                                <p class="text-sm text-secondary-foreground font-mono">{{ $department->bg_color ?? __('main.na') }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.border_color') }}</label>
                            <div class="flex items-center gap-2">
                                <div class="w-12 h-12 rounded border-4" style="border-color: {{ $department->border_color ?? '#ccc' }}; background-color: transparent;"></div>
                                <p class="text-sm text-secondary-foreground font-mono">{{ $department->border_color ?? __('main.na') }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.border_main_color') }}</label>
                            <div class="flex items-center gap-2">
                                <div class="w-12 h-12 rounded border-l-4" style="border-left-color: {{ $department->border_main_color ?? '#ccc' }};"></div>
                                <p class="text-sm text-secondary-foreground font-mono">{{ $department->border_main_color ?? __('main.na') }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.badge_color') }}</label>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" style="background-color: {{ $department->badge_color ?? '#ccc' }};">
                                    {{ __('main.badge') }}
                                </span>
                                <p class="text-sm text-secondary-foreground font-mono">{{ $department->badge_color ?? __('main.na') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-4">
                @can('update', $department)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.departments',
                        'id' => $department->id,
                    ])
                @endcan
                @can('delete', $department)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.departments',
                        'modelClass' => 'department',
                        'id' => $department->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.departments.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.departments')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
