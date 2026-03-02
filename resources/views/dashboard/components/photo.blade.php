@php
    $columnName = $column ?? 'photo';
@endphp

<div>
    <label for="{{ $columnName }}" class="kt-label">{{ __('main.' . $columnName) }}</label>
    <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
        data-input="{{ $columnName }}" @if (isset($record) && $record) data-preview="preview-{{ $columnName }}" @endif>
        <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
        <p class="mt-4">{{ __('main.click_or_drag_image_here') }}</p>
    </div>
    <input type="file" id="{{ $columnName }}" name="{{ $columnName }}" accept="image/*" hidden>

    {{-- Existing photo (edit mode) --}}
    @if (isset($record) && $record && !empty($record->{$columnName}) && checkExistFile($record->{$columnName}))
        <input type="hidden" name="remove_{{ $columnName }}" id="remove_{{ $columnName }}" value="0">
        <div id="existing-{{ $columnName }}" class="relative w-fit mt-8">
            <img src="{{ asset('storage/' . $record->{$columnName}) }}" class="h-32 w-32 rounded">
            <button type="button"
                class="remove-existing-{{ $columnName }} absolute -top-2 -right-2 bg-danger cursor-pointer text-white w-6 h-6 rounded-full">
                ×
            </button>
        </div>
        <div id="preview-{{ $columnName }}" class="hidden mt-8"></div>
    @else
        <div id="preview-{{ $columnName }}" class="hidden flex flex-wrap gap-4 mt-6"></div>
    @endif
</div>

@once
    @push('scripts')
        @include('dashboard.components.drag-drop-images')
    @endpush
@endonce
