<form method="POST" action="{{ route('dashboard.deleteRecord', [$model, $modelClass, $id]) }}" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
        @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
            {{ __('main.delete') }}
        @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
            <i class="fas fa-trash-can text-white"></i>
        @else
            <i class="fas fa-trash-can text-white"></i>
            {{ __('main.delete') }}
        @endif
    </button>
</form>
