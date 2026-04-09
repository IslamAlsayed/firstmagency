<div class="flex items-center gap-4">
    <button id="formButtonSaveRecord" type="submit" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
        <i class="fas fa-check text-sm me-2"></i>
        {{ __('main.save_type', ['type' => __('main.' . (isset($model) ? $model : singularLowerCaseName($models)))]) }}
    </button>
    <button type="submit" name="save_and_add" value="1" class="kt-btn kt-btn-outline kt-btn-outline-primary" toggle-button>
        <i class="fas fa-plus text-sm me-2"></i>
        {{ __('main.save_and_add_another') }}
    </button>
    <a href="{{ route("$models.index") }}" class="kt-btn kt-btn-outline" toggle-button>
        {{ __('main.cancel') }}
    </a>
</div>
