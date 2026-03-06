<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ================= GLOBAL DRAG ================= */
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => {
            document.addEventListener(e, ev => {
                ev.preventDefault();
                ev.stopPropagation();
            });
        });
        // ['dragenter', 'dragover'].forEach(e => {
        //     document.addEventListener(e, ev => {
        //         ev.preventDefault();
        //     });
        // });

        /* ================= DROPZONE ================= */
        const dropzones = document.querySelectorAll('.dropzone');

        dropzones.forEach(zone => {
            const inputId = zone.dataset.input;
            const input = document.getElementById(inputId);
            const previewId = 'preview-' + inputId;
            const preview = document.getElementById(previewId);

            if (!input) {
                console.error('Input not found for:', inputId);
                return;
            }

            if (!preview) {
                console.error('Preview not found for:', previewId);
                return;
            }

            // Click handler to open file dialog
            zone.addEventListener('click', (e) => {
                input.click();
            });

            // drag UI only (no file injection for single)
            ['dragenter', 'dragover'].forEach(e =>
                zone.addEventListener(e, () => {
                    zone.classList.add('drag');
                })
            );
            ['dragleave', 'drop'].forEach(e =>
                zone.addEventListener(e, () => {
                    zone.classList.remove('drag');
                })
            );

            // Handle drop for single and multiple files
            zone.addEventListener('drop', e => {
                const files = e.dataTransfer.files;
                if (!files.length) return;

                // For single photo: take only the first file
                if (!input.multiple) {
                    const dt = new DataTransfer();
                    dt.items.add(files[0]);
                    input.files = dt.files;
                } else {
                    // For multiple files: take all files
                    const dt = new DataTransfer();

                    for (let i = 0; i < files.length; i++) {
                        dt.items.add(files[i]);
                    }

                    input.files = dt.files;
                }
                renderFiles(input, preview);
            });

            // File change event (when user selects via dialog)
            input.addEventListener('change', () => {

                // If there is an existing photo, remove it
                // const existingDiv = document.getElementById('existing-' + inputId);
                const existingDivs = document.querySelectorAll('[id^="existing-' + inputId + '"]');
                if (existingDivs.length > 0 && input.files.length > 0) {
                    existingDivs.forEach(div => div.remove());
                    const removeInput = document.getElementById('remove_' + inputId);
                    if (removeInput) {
                        removeInput.value = 1;
                    }
                }

                renderFiles(input, preview);
            });
        });


        /* ================= RENDER FILES ================= */
        function renderFiles(input, preview) {
            preview.innerHTML = '';
            preview.classList.remove('hidden');

            const files = [...input.files];
            console.log(input.files);

            if (files.length === 0) {
                preview.classList.add('hidden');
                return;
            }

            // استخدم DataTransfer لحفظ الملفات في الـ input
            const dt = new DataTransfer();
            files.forEach(file => dt.items.add(file));
            input.files = dt.files;

            files.forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'relative w-fit';

                const displayIndex = input.multiple ? index : 0;

                div.innerHTML = `
            <img src="${URL.createObjectURL(file)}"
                 class="h-24 w-24 object-cover rounded">
            <button type="button"
                    class="remove-new absolute -top-2 -right-2 bg-danger text-white w-6 h-6 rounded-full"
                    data-index="${displayIndex}"
                    data-input-id="${input.id}">
                ×
            </button>
        `;
                preview.appendChild(div);
            });
        }

        /* ================= REMOVE LOGIC ================= */
        document.addEventListener('click', function(e) {

            /* ---- remove existing file ---- */
            if (e.target.classList.contains('remove-existing-photo') ||
                e.target.classList.contains('remove-existing-gallery') ||
                e.target.getAttribute('class')?.includes('remove-existing-')) {

                // الحصول على اسم العمود من class
                const classList = Array.from(e.target.classList);
                const removeExistingClass = classList.find(c => c.startsWith('remove-existing-'));

                if (removeExistingClass) {
                    const columnName = removeExistingClass.replace('remove-existing-', '');

                    // لـ photo
                    if (columnName === 'photo' || !columnName.includes('_')) {
                        const existingDiv = document.getElementById('existing-' + columnName);
                        if (existingDiv) existingDiv.remove();

                        const removeInput = document.getElementById('remove_' + columnName);
                        if (removeInput) removeInput.value = 1;
                    }
                    // for Multiple
                    else {
                        const index = e.target.dataset.index;
                        const path = e.target.dataset.path;
                        document.getElementById('existing_' + columnName + '_' + index)?.remove();

                        const input = document.getElementById('removed_' + columnName);
                        if (input) {
                            const data = JSON.parse(input.value);
                            data.push(path);
                            input.value = JSON.stringify(data);
                        }
                    }
                }
                return;
            }

            /* ================= REMOVE NEW UPLOADED FILE ================= */
            if (e.target.classList.contains('remove-new')) {
                const index = +e.target.dataset.index;
                const inputId = e.target.dataset.inputId;
                const input = document.getElementById(inputId);
                if (!input) return;

                const preview = document.getElementById('preview-' + inputId);
                if (!preview) return;


                const dt = new DataTransfer();
                [...input.files].forEach((file, i) => {
                    if (i !== index) dt.items.add(file);
                });

                input.files = dt.files;
                renderFiles(input, preview);
            }
        });
    });
</script>
