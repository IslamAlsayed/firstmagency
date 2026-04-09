@if (isset($model) && isset($id))
    <button type="button" class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white delete-btn" data-route="{{ route("$model.destroy", $id) }}" data-row-id="row-{{ $id }}"
        title={{ __('main.delete') }} toggle-button>

        <span class="btn-text">
            @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                {{ __('main.delete') }}
            @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                <i class="fas fa-trash-can text-white"></i>
            @else
                <i class="fas fa-trash-can text-white"></i>
                {{ __('main.delete') }}
            @endif
        </span>

        @include('dashboard.components.loader', ['width' => '15px', 'height' => '15px', 'color' => '#fff'])
    </button>
@endif
