@php
    $label = $label ?? 'gallery';
    $columnName = $column ?? 'gallery';
    $multiple = $multiple ?? true;
@endphp

<div>
    <label class="kt-label">{{ __('main.' . $label) }}</label>
    <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary cursor-pointer" data-input="{{ $columnName }}">
        <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
        <p class="mt-4">
            {{ $multiple ? __('main.click_or_drag_image_here_multiple') : __('main.click_or_drag_image_here') }}
        </p>
    </div>

    <input type="file" id="{{ $columnName }}" name="{{ $multiple ? $columnName . '[]' : $columnName }}" accept="image/*" hidden {{ $multiple ? 'multiple' : '' }}>

    {{-- array of removed indexes --}}
    <input type="hidden" id="removed_{{ $columnName }}" name="removed_{{ $columnName }}" value="[]">

    @if (isset($record) && $record)
        @php
            $images = is_array($record->{$columnName}) ? $record->{$columnName} : [$record->{$columnName}];
        @endphp

        <div class="flex flex-wrap gap-4 mt-4">
            @foreach ($images as $index => $img)
                @if (!empty($img))
                    <div class="relative existing-item" id="existing-{{ $columnName }}-{{ $index }}">
                        <img src="{{ asset('storage/' . $img) }}" class="h-32 w-32 object-cover rounded">
                        <button type="button" class="remove-existing-{{ $columnName }} absolute -top-2 -right-2 cursor-pointer bg-danger text-white w-6 h-6 rounded-full"
                            data-column="{{ $columnName }}" data-index="{{ $index }}" data-path="{{ $img }}">
                            ×
                        </button>

                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <div id="preview-{{ $columnName }}" class="hidden flex flex-wrap gap-4 mt-6"></div>

</div>
