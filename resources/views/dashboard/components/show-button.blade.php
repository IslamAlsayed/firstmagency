<a href="{{ route("{$models}.show", $id) }}" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-yellow-500 text-white" style="{{ $styles ?? '' }}"
    title={{ __('main.show') }}>
    @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
        {!! $text ?? __('main.show') !!}
    @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
        <i class="fas fa-eye text-white"></i>
    @else
        <i class="fas fa-eye text-white"></i>
        {!! $text ?? __('main.show') !!}
    @endif
</a>
