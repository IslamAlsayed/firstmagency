<div class="{{ isset($classes) ? $classes : '' }}">
    <label for="{{ $name ?? $column }}" class="kt-label mb-2">
        {{ __('main.' . ($name ?? $column)) }}
        @if (isset($placeholder) && $placeholder)
            <span class="text-sm text-primary">({{ $placeholder }})</span>
        @endif
    </label>

    <textarea id="{{ $name ?? $column }}" name="{{ $name ?? $column }}" class="ckeditor" placeholder="{{ isset($placeholder) && $placeholder ? $placeholder : '' }}">{{ $value ?? (old($name ?? $column) ?? '') }}</textarea>

    @error($name ?? $column)
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
    <script src="/assets/plugins/ckeditor/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.CKEDITOR) {
                document.querySelectorAll('.ckeditor').forEach(function(el) {
                    if (!el.classList.contains('ckeditor-initialized')) {
                        CKEDITOR.replace(el.id);
                        el.classList.add('ckeditor-initialized');
                    }
                });
            }
        });
    </script>
@endpush
