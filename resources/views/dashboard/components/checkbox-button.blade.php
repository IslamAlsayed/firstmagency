<div class="custom-input {{ isset($disabled) && $disabled ? 'disabled-option' : '' }}" wire:ignore>
    <input type="{{ isset($type) ? $type : 'checkbox' }}" name="{{ isset($name) ? $name : '' }}" class="{{ isset($classes) && $classes ? str_replace(',', ' ', $classes) : '' }}"
        id="{{ isset($id) ? $id : '' }}" wire:model.live='selectedIds' value="{{ isset($value) ? $value : '' }}" {{ isset($checked) && $checked ? 'checked' : '' }}
        {{ isset($disabled) && $disabled ? 'disabled' : '' }} {!! isset($customize) && $customize ? $customize : '' !!} data-kt-datatable-row-check="true">
    <label for="{{ isset($id) ? $id : '' }}">{{ isset($label) ? $label : '' }}</label>
    @if (isset($checkboxSlot))
        {{ $checkboxSlot }}
    @endif
</div>
