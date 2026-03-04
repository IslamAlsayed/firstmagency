@extends('dashboard.layout.master')

@section('title', $review->name ?? 'Review')
@section('page-title', '⭐ ' . limitedText($review->name ?? '', 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $review->name ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    🌍 {{ $review->country }} • ⭐ {{ $review->rate }}/5 • {{ $review->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $review)
                    <a href="{{ route('dashboard.reviews.edit', $review->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.reviews.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.reviews')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.reviews')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Information Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.name') }}</p>
                            <p class="font-semibold text-gray-800">{{ $review->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.country') }}</p>
                            <p class="font-semibold text-gray-800">🌍 {{ $review->country ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.rating') }}</p>
                            <p class="font-semibold text-gray-800">
                                @for ($i = 0; $i < $review->rate; $i++)
                                    ⭐
                                @endfor
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ __('main.status') }}
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                @if ($review->status === 'approved') bg-green-100 text-green-800
                                @elseif($review->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                    @if ($review->status === 'pending')
                                        <i class="fas fa-clock text-yellow-500"></i> {{ __('main.pending') }}
                                    @elseif ($review->status === 'approved')
                                        <i class="fas fa-check-circle text-green-600"></i> {{ __('main.approved') }}
                                    @elseif ($review->status === 'rejected')
                                        <i class="fas fa-times-circle text-red-600"></i> {{ __('main.rejected') }}
                                    @endif
                                </span>
                            </p>
                            @include('dashboard.components.reviews-status-actions', [
                                'record' => $review,
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $review->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.updated_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $review->updated_at?->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Review Message --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.message') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">
                        {{ $review->comment }}
                    </div>
                </div>
            </div>

            <!-- Photo -->
            @if ($review->photo && checkExistFile($review->photo))
                @include('dashboard.components.display-photo', [
                    'record' => $review,
                    'column' => 'photo',
                    'alt' => $review->name ?? 'Review Photo',
                ])
            @endif

            <!-- Audio -->
            @if ($review->audio)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.audio') }}</h3>
                    </div>

                    <div class="kt-card-body p-4">
                        <div class="flex justify-start">
                            <audio controls class="w-full" style="max-width: 50%; border: 1px solid #cacacc; border-radius: 50px;">
                                <source src="{{ asset('storage/' . $review->audio) }}" type="audio/wav">
                                {{ __('main.audio_not_supported') }}
                            </audio>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $review])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $review)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.reviews',
                        'id' => $review->id,
                    ])
                @endcan
                @can('delete', $review)
                    @include('dashboard.components.delete-form', [
                        'model' => 'dashboard.reviews',
                        'id' => $review->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.reviews.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.reviews')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
