<button style="{{ isset($styles) ? $styles : '' }}" class="kt-btn kt-btn-sm kt-btn-outline m-0 text-white bg-red-800" toggle-button>
    @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
        {!! $text ?? __('main.force_delete') !!}
    @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
        <i class="fas fa-trash text-white"></i>
    @else
        <i class="fas fa-trash text-white"></i>
        {!! $text ?? __('main.force_delete') !!}
    @endif
</button>
