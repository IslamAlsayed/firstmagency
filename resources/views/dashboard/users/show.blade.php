@extends('dashboard.layout.master')

@section('title', __('main.view_type', ['type' => __('main.user')]))
@section('page-title', '👤 ' . __('main.view_type', ['type' => __('main.user')]))

@section('content')
    <div class="shadow-md radius-lg p-6">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $user->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground email">
                    <a href="mailto:{{ $user->email }}" target="_blank" class="text-blue-600 hover:underline">
                        {!! limitedText($user->email ?? '--', 30) !!}
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                    •
                    <a href="tel:{{ $user->phone }}" target="_blank" class="text-blue-600 hover:underline">
                        {!! limitedText($user->phone ?? '--', 30) !!}
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('permissions-update')
                    <a href="{{ route('dashboard.users.editPermissions', $user->id) }}" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-pink-500 text-white" toggle-button>
                        <i class="fas fa-key text-white"></i>
                        {{ __('main.permissions') }}
                    </a>
                @endcan
                @can('update', $user)
                    <a href="{{ route('dashboard.users.edit', $user->id) }}" class="kt-btn kt-btn-primary md:hidden" toggle-button>
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.users.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_types', ['types' => __('main.users')]) }}
                </a>
            </div>
        </div>

        <div class="grid gap-4 lg:gap-6">
            <!-- Basic Information -->
            <div class="shadow-md radius-lg p-4">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($user->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $user->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($user->email)
                            <div class="email">
                                <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="mailto:{{ $user->email }}" target="_blank" class="text-blue-600 hover:underline">
                                        {!! limitedText($user->email ?? '--', 30) !!}
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($user->phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $user->phone }}" target="_blank" class="text-blue-600 hover:underline">
                                        {!! limitedText($user->phone ?? '--', 30) !!}
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($user->mobile)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $user->mobile }}" target="_blank" class="text-blue-600 hover:underline">
                                        {!! limitedText($user->mobile ?? '--', 30) !!}
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </p>
                            </div>
                        @endif
                        @include('dashboard.components.displayable-rich-text', [
                            'record' => $user,
                            'column' => 'description',
                        ])
                        @include('dashboard.components.displayable-rich-text', [
                            'record' => $user,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Media Files -->
            @if (!empty($user->photo))
                @include('dashboard.components.display-photo', ['record' => $user, 'alt' => $user->name])
            @endif

            <!-- Metadata -->
            @include('dashboard.components.metadata', ['record' => $user])

            {{-- Action Buttons --}}
            <div class="flex items-center gap-4">
                @can('update', $user)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.users',
                        'id' => $user->id,
                    ])
                @endcan
                @can('delete', $user)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.users',
                        'modelClass' => 'user',
                        'id' => $user->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.users.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_types', ['types' => __('main.users')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
