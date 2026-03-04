<script>
    $(document).ready(function() {
        // Handle delete button click
        $(document).on('click', '.delete-btn, .force-delete-btn', function(e) {
            e.preventDefault();

            const btn = $(this);
            const route = btn.data('route');
            const rowId = btn.data('row-id');
            const btnLoader = btn.find('.container-loader');
            const btnText = btn.find('.btn-text');

            // Confirm before delete
            // if (!confirm(`{{ __('main.are_you_sure') }}؟`)) {
            //     return;
            // }

            // Show loading state: hide text, show loader
            btnText.addClass('hidden');
            btnLoader.removeClass('hidden');
            btn.prop('disabled', true);

            // Make AJAX request
            $.ajax({
                url: route,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(response) {
                    // Remove the row from table with animation
                    $('#' + rowId).fadeOut(300, function() {
                        $(this).remove();

                        // Show success toast
                        window.showToast({
                            type: response.success ? 'success' : 'danger',
                            message: response.message ||
                                '{{ __('messages.type_deleted', ['type' => __('main.line_work')]) }}',
                        });
                    });
                },
                error: function(xhr, status, error) {
                    // Restore button
                    btnText.removeClass('hidden');
                    btnLoader.addClass('hidden');
                    btn.prop('disabled', false);

                    // Show error message
                    const errorMessage = xhr.responseJSON?.message || '{{ __('messages.error_occurred') }}';
                    window.showToast({
                        type: xhr.responseJSON?.success ? 'success' : 'danger',
                        message: errorMessage,
                    });
                }
            });
        });
    });
</script>
