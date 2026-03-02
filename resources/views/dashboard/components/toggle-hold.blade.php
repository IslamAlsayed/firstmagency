<div class="toggle-hold mt-1">
    <input type="checkbox" data-route="{{ route('dashboard.toggleField', ['modelClass' => $modelClass, 'id' => $modelId, 'field' => $field]) }}"
        id="toggle-{{ isset($modelClass) && $modelClass ? $modelClass : '' }}-{{ isset($modelId) && $modelId ? $modelId : '' }}-{{ isset($field) && $field ? $field : '' }}"
        class="toggle-input" {{ isset($value) && $value ? 'checked' : '' }}>

    <label
        for="toggle-{{ isset($modelClass) && $modelClass ? $modelClass : '' }}-{{ isset($modelId) && $modelId ? $modelId : '' }}-{{ isset($field) && $field ? $field : '' }}">
        <span></span>
    </label>
</div>
