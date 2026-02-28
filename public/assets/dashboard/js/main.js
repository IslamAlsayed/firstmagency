document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function () {
        let multiples = [
            document.querySelectorAll(".basic-multiple"),
            document.querySelectorAll(".basic-single"),
        ];
        multiples.forEach((multiple) => {
            multiple.forEach((select) => {
                $(select).select2();
            });
        });
    });
});