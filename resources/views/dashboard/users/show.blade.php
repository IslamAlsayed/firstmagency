@extends('dashboard.layout.master')

@section('title', __('main.view_user'))
@section('page-title', '👤 ' . __('main.view_user'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $user->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground email">
                    {{ $user->email }} • {{ $user->phone }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.users.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.users')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
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
                                <p class="text-sm text-secondary-foreground">{{ $user->email ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($user->phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $user->phone ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($user->mobile)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $user->mobile }}</p>
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
                <a href="{{ route('dashboard.users.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.users')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
