document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function () {
        let multiples = [
            document.querySelectorAll(".basic-multiple"),
            document.querySelectorAll(".basic-single"),
        ];
        if (multiples.length > 0) {
            multiples.forEach((multiple) => {
                multiple.forEach((select) => {
                    $(select).select2();
                });
            });
        }
    });

    function normalizeSearchText(value) {
        if (!value) return '';

        return value
            .toString()
            .toLowerCase()
            .normalize('NFKC')
            // Remove Arabic diacritics and tatweel.
            .replace(/[\u064B-\u065F\u0670\u06D6-\u06ED\u0640]/g, '')
            // Normalize common Arabic letter variants.
            .replace(/[أإآٱ]/g, 'ا')
            .replace(/[ؤئ]/g, 'ء')
            .replace(/ى/g, 'ي')
            .replace(/ة/g, 'ه')
            // Normalize Arabic/Persian digits to Western digits.
            .replace(/[٠-٩]/g, d => '٠١٢٣٤٥٦٧٨٩'.indexOf(d))
            .replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
    }

    const searchBox = document.getElementById('searchBox');
    if (searchBox) {
        searchBox.addEventListener('input', function () {
            const search = normalizeSearchText(this.value.trim());
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = normalizeSearchText(row.textContent);
                const match = text.includes(search);
                row.style.display = match ? '' : 'none';
            });
        });
    }

    const languageTabs = document.querySelectorAll('.language-tab');
    const languageContents = document.querySelectorAll('.language-content');

    if (languageTabs.length > 0 && languageContents.length > 0) {
        languageTabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const lang = this.getAttribute('data-lang');

                // Remove active state from all tabs
                languageTabs.forEach(t => {
                    t.classList.remove('border-b-2', 'text-gray-900', 'font-semibold');
                    t.classList.add('border-transparent', 'text-gray-600');
                });

                // Hide all content
                languageContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Activate selected tab and content
                this.classList.remove('border-transparent', 'text-gray-600');
                this.classList.add('border-b-2', 'text-gray-900', 'font-semibold');

                document.querySelector(`.language-content[data-lang="${lang}"]`)?.classList.remove('hidden');
            });
        });
    }

    const viewer = document.getElementById('imageViewer');
    const viewerImg = document.getElementById('viewerImg');

    if (viewer && viewerImg) {
        document.querySelectorAll('.clickable-img').forEach(img => {
            img.addEventListener('click', () => {
                viewerImg.src = img.dataset.src;
                viewer.classList.add('active');
            });
        });

        viewer.addEventListener('click', (e) => {
            if (e.target === viewer) {
                viewer.classList.remove('active');
            }
        });
    }
});