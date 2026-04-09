@php
    $columnName = $column ?? 'files';
    $record = $record ?? null;
@endphp

<div class="shadow-md radius-lg">
    <div class="kt-card-header">
        <h3 class="kt-card-title">{{ __('main.' . $columnName) }} <span class="font-semibold text-primary">({{ count($record->{$columnName}) ?? 0 }})</span></h3>
    </div>
    <div class="kt-card-body p-4">
        <div class="flex flex-col gap-6">
            @if ($record->{$columnName} && count($record->{$columnName}) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($record->{$columnName} as $index => $file)
                        <div class="image-container shadow-sm">
                            @if ($file)
                                <img src="{{ asset('storage/' . $file) }}" alt="{{ __('main.' . $columnName) }} {{ $index + 1 }}" class="w-full h-32 object-cover" loading="lazy">
                            @else
                                <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                    <p class="text-xs text-secondary-foreground">{{ __('main.na') }}</p>
                                </div>
                            @endif
                            <div class="image-overlay">
                                <a href="{{ $file ? asset('storage/' . $file) : '#' }}" download="{{ $file }}" class="kt-btn kt-btn-sm kt-btn-primary" toggle-button>
                                    <i class="fas fa-download text-sm me-1"></i>
                                    <span>{{ __('main.download') }}</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
