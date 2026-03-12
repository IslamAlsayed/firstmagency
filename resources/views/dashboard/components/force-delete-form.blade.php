@if (isset($model) && isset($id))
    @php
        // Extract model name from format "dashboard.roles" or "dashboard.articles"
        $modelName = str_replace('dashboard.', '', $model);
    @endphp

    <button type="button" class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white bg-red-800 force-delete-btn"
        data-route="{{ route('dashboard.forceDestroy', [$modelName, $id]) }}" data-row-id="row-{{ $id }}" data-force="true"
        title={{ __('main.force_delete') }}>

        <span class="btn-text">
            @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                {{ __('main.force_delete') }}
            @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                <i class="fas fa-trash-can text-white"></i>
            @else
                <i class="fas fa-trash-can text-white"></i>
                {{ __('main.force_delete') }}
            @endif
        </span>

        @include('dashboard.components.loader', ['width' => '15px', 'height' => '15px', 'color' => '#fff'])
    </button>
@endif
