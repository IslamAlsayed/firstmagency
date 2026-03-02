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

    const searchBox = document.getElementById('searchBox');
    if (searchBox) {
        searchBox.addEventListener('keyup', function () {
            const search = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
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
});