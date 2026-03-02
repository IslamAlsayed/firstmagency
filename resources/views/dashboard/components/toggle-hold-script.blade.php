<script>
    $(document).ready(function() {
        // Remove any existing handlers to prevent duplicates
        $(document).off('change', '.toggle-input');
        
        // Bind the change event using event delegation
        $(document).on('change', '.toggle-input', function() {
            const checkbox = $(this);
            const route = checkbox.attr('data-route');
            $.ajax({
                url: route,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Show toast notification
                        window.showToast({
                            type: response.status ?? 'success',
                            message: response.message ?? '{{ __('messages.updated_successfully') }}'
                        });
                    } else {
                        checkbox.prop('checked', !checkbox.prop('checked'));
                        window.showToast({
                            type: response.status ?? 'error',
                            message: response.message ?? '{{ __('messages.error_occurred') }}'
                        });
                    }
                },
                error: function(xhr) {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    const errorMessage = xhr.responseJSON?.message || '{{ __('messages.error_occurred') }}';
                    window.showToast({
                        type: xhr.responseJSON?.status ?? 'error',
                        message: errorMessage ?? '{{ __('messages.error_occurred') }}'
                    });
                }
            });
        });
    });
</script>
