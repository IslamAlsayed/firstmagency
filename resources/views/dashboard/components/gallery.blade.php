@php
    $columnName = $column ?? 'gallery';
@endphp

<div>
    <label for="{{ $columnName }}" class="kt-label">{{ __('main.' . $columnName) }}</label>
    <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer" data-input="{{ $columnName }}"
        @if (isset($record) && $record) data-preview="preview-{{ $columnName }}" @endif>
        <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
        <p class="mt-4">{{ __('main.click_or_drag_image_here_multiple') }}</p>
    </div>
    <input type="file" id="{{ $columnName }}" name="{{ $columnName }}[]" accept="image/*" hidden multiple>

    {{-- Existing (edit mode) --}}
    @if (isset($record) && $record && is_array($record->{$columnName}))
        <div class="mt-4 flex flex-wrap gap-4">
            <input type="hidden" id="remove_{{ $columnName }}" name="remove_{{ $columnName }}" value="0">
            @foreach ($record->{$columnName} as $index => $img)
                <div id="existing-{{ $columnName }}-{{ $index }}" class="relative w-fit mt-8">
                    <img src="{{ asset('storage/' . $img) }}" class="h-32 w-32 rounded">
                    <button type="button" class="remove-existing-{{ $columnName }} absolute -top-2 -right-2 bg-danger text-white w-6 h-6 rounded-full">
                        ×
                    </button>
                </div>
            @endforeach
        </div>
    @endif

    <div id="preview-{{ $columnName }}" class="hidden flex flex-wrap gap-4 mt-6"></div>
</div>
