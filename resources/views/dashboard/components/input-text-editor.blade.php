<div class="{{ isset($classes) ? $classes : '' }}">
    <label for="{{ $name ?? $column }}" class="kt-label mb-2">
        {{ __('main.' . ($name ?? $column)) }}
        @if (isset($placeholder) && $placeholder)
            <span class="text-sm text-primary">({{ $placeholder }})</span>
        @endif
    </label>

    <textarea id="{{ $name ?? $column }}" name="{{ $name ?? $column }}" class="ckeditor" placeholder="{{ isset($placeholder) && $placeholder ? $placeholder : '' }}"
        style="min-height:{{ isset($height) ? $height : '500px' }};">{{ $value ?? (old($name ?? $column) ?? '') }}</textarea>

    @error($name ?? $column)
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
