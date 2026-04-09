@php
    $columnName = $column ?? 'photo';
@endphp

<!-- Media Files -->
<div class="shadow-md radius-lg">
    <div class="kt-card-header">
        <h3 class="kt-card-title">{{ __('main.' . $columnName) }}</h3>
    </div>
    <div class="kt-card-body p-4">
        <div class="flex flex-col gap-6">
            @if ($record->$columnName && checkExistFile($record->$columnName))
                <div class="flex flex-col w-fit">
                    <div class="image-container">
                        @if ($record->$columnName)
                            <img src="{{ asset('storage/' . $record->$columnName) }}" alt="{{ $alt ?? '' }}" class="w-auto h-[250px] object-cover shadow" loading="lazy">
                        @else
                            <div class="h-40 bg-gray-200 flex items-center justify-center">
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            </div>
                        @endif
                        <div class="image-overlay">
                            <a href="{{ $record->$columnName ? asset('storage/' . $record->$columnName) : '#' }}" download="{{ $record->$columnName }}" class="kt-btn kt-btn-sm kt-btn-primary"
                                toggle-button>
                                <i class="fas fa-download text-sm me-1"></i>
                                <span>{{ __('main.download') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div>
                    <p class="text-sm text-secondary-foreground">{{ __('messages.no_data_available') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
