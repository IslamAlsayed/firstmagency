/**
 * Generic Toggle Field Handler
 * Usage: initializeToggleFields(options)
 * 
 * Options:
 * - selector: CSS selector for toggle inputs (default: '.toggle-input')
 * - getRouteUrl: Function to generate the route URL (required)
 * 
 * Example:
 * initializeToggleFields({
 *     selector: '.toggle-input',
 *     getRouteUrl: (modelId, field) => {
 *         return route('dashboard.services.toggleField', [modelId, field]);
 *     }
 * });
 */
function initializeToggleFields(options = {}) {
    const {
        selector = '.toggle-input',
        getRouteUrl = null
    } = options;

    if (!getRouteUrl) {
        console.error('initializeToggleFields: getRouteUrl function is required');
        return;
    }

    // Use event delegation to handle dynamically added elements
    $(document).on('change', selector, function () {
        const checkbox = $(this);
        const id = checkbox.attr('id');

        // Parse id: toggle-{table}-{modelId}-{field}
        const parts = id.split('-');
        if (parts.length < 4) {
            console.error('Invalid toggle ID format:', id);
            return;
        }

        const modelId = parts[2];
        const field = parts[3];

        // Store original checked state for reverting on error
        const originalState = checkbox.prop('checked');

        // Get the route URL
        const url = getRouteUrl(modelId, field);

        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    // Show success notification
                    if (window.showToast) {
                        window.showToast({
                            type: 'success',
                            message: response.message
                        });
                    } else {
                        console.log('Success:', response.message);
                    }
                } else {
                    // Revert checkbox on failure
                    checkbox.prop('checked', !originalState);

                    if (window.showToast) {
                        window.showToast({
                            type: 'error',
                            message: response.message
                        });
                    } else {
                        console.error('Error:', response.message);
                    }
                }
            },
            error: function (xhr) {
                // Revert checkbox on error
                checkbox.prop('checked', !originalState);

                const errorMessage = xhr.responseJSON?.message || 'An error occurred';

                if (window.showToast) {
                    window.showToast({
                        type: 'error',
                        message: errorMessage
                    });
                } else {
                    console.error('Error:', errorMessage);
                }
            }
        });
    });
}
