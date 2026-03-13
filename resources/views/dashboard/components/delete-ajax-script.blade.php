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
                    // Get the row to extract status and active before deletion
                    const $row = $('#' + rowId);
                    const status = $row.data('status');
                    const active = $row.data('active');
                    const priority = $row.data('priority');

                    // Remove the row from table with animation
                    console.log('rowId: ', rowId);
                    $row.fadeOut(300, function() {
                        $(this).remove();

                        // Update statistics
                        updateStatistics(status, active, priority);

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

        // Function to update statistics after deletion
        function updateStatistics(status, active) {
            // Decrease total
            const $total = $('#stat-total');
            if ($total.length) {
                let total = parseInt($total.text()) || 0;
                $total.text(Math.max(0, total - 1));
            }

            // Decrease status-specific count
            if (status) {
                const $statusStat = $('#stat-' + status);
                if ($statusStat.length) {
                    let count = parseInt($statusStat.text()) || 0;
                    $statusStat.text(Math.max(0, count - 1));
                }
            }

            // Decrease active/inactive count
            if (active !== undefined) {
                const activeKey = active == 1 ? 'active' : 'inactive';
                const $activeStat = $('#stat-' + activeKey);
                if ($activeStat.length) {
                    let count = parseInt($activeStat.text()) || 0;
                    $activeStat.text(Math.max(0, count - 1));
                }
            }

            // Decrease urgent priority count (for tickets)
            const $urgentStat = $('#stat-urgent');
            if ($urgentStat.length) {
                let count = parseInt($urgentStat.text()) || 0;
                $urgentStat.text(Math.max(0, count - 1));
            }
        }
    });
</script>
