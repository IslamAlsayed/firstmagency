<a href="{{ route("{$models}.edit", $id) }}" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-primary text-white" style="{{ $styles ?? '' }}">
    @if (getActiveUser()->button_display_mode === 'text')
        {!! $text ?? __('main.edit') !!}
    @elseif (getActiveUser()->button_display_mode === 'icon')
        <i class="fas fa-edit text-white"></i>
    @else
        <i class="fas fa-edit text-white"></i>
        {!! $text ?? __('main.edit') !!}
    @endif
</a>
