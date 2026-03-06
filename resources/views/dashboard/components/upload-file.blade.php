@php
    $columnName = $column ?? 'gallery';
    $multiple = $multiple ?? true;
@endphp

<div>
    <label class="kt-label">{{ __('main.' . $columnName) }}</label>
    <div class="dropzone mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary cursor-pointer"
        data-input="{{ $columnName }}">
        <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
        <p class="mt-4">
            {{ $multiple ? __('main.click_or_drag_image_here_multiple') : __('main.click_or_drag_image_here') }}
        </p>
    </div>

    <input type="file" id="{{ $columnName }}" name="{{ $multiple ? $columnName . '[]' : $columnName }}" accept="image/*" hidden
        {{ $multiple ? 'multiple' : '' }}>

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
                        <button type="button" class="remove-existing absolute -top-2 -right-2 bg-danger text-white w-6 h-6 rounded-full"
                            data-column="{{ $columnName }}" data-index="{{ $index }}">
                            ×
                        </button>

                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <div id="preview-{{ $columnName }}" class="hidden flex flex-wrap gap-4 mt-6"></div>

</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const dropzones = document.querySelectorAll('.dropzone');
                dropzones.forEach(zone => {
                    const inputId = zone.dataset.input;
                    const input = document.getElementById(inputId);
                    const preview = document.getElementById('preview-' + inputId);
                    zone.addEventListener('click', () => input.click());
                    zone.addEventListener('dragover', e => {
                        e.preventDefault();
                    });

                    zone.addEventListener('drop', e => {
                        e.preventDefault();
                        const files = e.dataTransfer.files;

                        const dt = new DataTransfer();
                        if (input.multiple) {
                            for (let f of files) {
                                dt.items.add(f);
                            }
                        } else {
                            dt.items.add(files[0]);
                        }
                        input.files = dt.files;
                        renderPreview(input, preview);
                    });

                    input.addEventListener('change', () => {
                        renderPreview(input, preview);
                    });
                });


                function renderPreview(input, preview) {
                    preview.innerHTML = '';
                    preview.classList.remove('hidden');
                    const files = [...input.files];
                    if (!files.length) {
                        preview.classList.add('hidden');
                        return;
                    }

                    files.forEach((file, index) => {
                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.innerHTML =
                            `
                            <img src="${URL.createObjectURL(file)}" class="h-24 w-24 object-cover rounded">
                            <button type="button" data-index="${index}" data-input="${input.id}" class="remove-new absolute -top-2 -right-2 bg-danger text-white w-6 h-6 rounded-full">×</button>`;
                        preview.appendChild(div);
                    });
                }

                document.addEventListener('click', e => {
                    /* remove new uploaded image */
                    if (e.target.classList.contains('remove-new')) {
                        const index = +e.target.dataset.index;
                        const inputId = e.target.dataset.input;
                        const input = document.getElementById(inputId);
                        const preview = document.getElementById('preview-' + inputId);
                        const dt = new DataTransfer();
                        [...input.files].forEach((file, i) => {
                            if (i !== index) dt.items.add(file);
                        });
                        input.files = dt.files;
                        renderPreview(input, preview);
                    }

                    /* remove existing image */
                    if (e.target.classList.contains('remove-existing')) {
                        const column = e.target.dataset.column;
                        const index = parseInt(e.target.dataset.index);
                        const wrapper = e.target.closest('.existing-item');

                        wrapper.remove();
                        const input = document.getElementById('removed_' + column);
                        let data = JSON.parse(input.value);
                        if (!data.includes(index)) {
                            data.push(index);
                        }
                        input.value = JSON.stringify(data);
                    }
                });
            });
        </script>
    @endpush
@endonce
