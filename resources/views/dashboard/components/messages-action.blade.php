<script>
    // Function to bind/rebind message handlers
    function rebindMessageHandlers() {
        // Edit message functionality
        const editBtns = document.querySelectorAll('.message-edit-btn');
        editBtns.forEach(btn => {
            btn.removeEventListener('click', handleEditClick);
            btn.addEventListener('click', handleEditClick);
        });

        // Cancel edit
        const cancelBtns = document.querySelectorAll('.message-cancel-btn');
        cancelBtns.forEach(btn => {
            btn.removeEventListener('click', handleCancelClick);
            btn.addEventListener('click', handleCancelClick);
        });

        // Save edited message
        const saveBtns = document.querySelectorAll('.message-save-btn');
        saveBtns.forEach(btn => {
            btn.removeEventListener('click', handleSaveClick);
            btn.addEventListener('click', handleSaveClick);
        });

        // Delete message
        const deleteBtns = document.querySelectorAll('.message-delete-btn');
        deleteBtns.forEach(btn => {
            btn.style.userSelect = 'none';
            btn.removeEventListener('click', handleDeleteClick);
            btn.addEventListener('click', handleDeleteClick);
        });
    }

    // Event handler for edit button
    function handleEditClick(e) {
        e.preventDefault();
        const messageContainer = this.closest('.client');
        const contentDiv = messageContainer.querySelector('.content');
        const editForm = messageContainer.querySelector('.edit-form');
        const textarea = messageContainer.querySelector('.edit-textarea');

        if (editForm && contentDiv && textarea) {
            contentDiv.style.display = 'none';
            editForm.style.display = 'block';
            textarea.focus();
        }
    }

    // Event handler for cancel button
    function handleCancelClick(e) {
        e.preventDefault();
        const messageContainer = this.closest('.client');
        const contentDiv = messageContainer.querySelector('.content');
        const editForm = messageContainer.querySelector('.edit-form');

        if (contentDiv && editForm) {
            contentDiv.style.display = 'block';
            editForm.style.display = 'none';
        }
    }

    // Event handler for save button
    function handleSaveClick(e) {
        e.preventDefault();
        const messageId = this.getAttribute('data-message-id');
        const messageContainer = this.closest('.client');
        const textarea = messageContainer.querySelector('.edit-textarea');
        const newMessage = textarea.value.trim();

        if (!newMessage) {
            window.showToast({
                type: 'error',
                message: '{{ __('messages.validation_required', ['attribute' => __('main.message')]) }}',
            });
            return;
        }

        // Send AJAX request to update message
        fetch(`{{ route('tickets.messages.update', ':id') }}`.replace(':id', messageId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    message: newMessage,
                    _method: 'PUT'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update message content
                    const contentDiv = messageContainer.querySelector('.content');
                    contentDiv.innerText = newMessage;

                    // Hide edit form
                    const editForm = messageContainer.querySelector('.edit-form');
                    contentDiv.style.display = 'block';
                    editForm.style.display = 'none';
                } else {
                    window.showToast({
                        type: data.status ?? 'error',
                        message: data.message ?? '{{ __('messages.unknown_error') }}',
                    });
                }
            })
            .catch(error => {
                window.showToast({
                    type: 'error',
                    message: '{{ __('messages.unknown_error') }}',
                });
            });
    }

    // Event handler for delete button
    function handleDeleteClick(e) {
        e.preventDefault();
        const messageId = this.getAttribute('data-message-id');

        fetch(`{{ route('tickets.messages.delete', ':id') }}`.replace(':id', messageId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    window.showToast({
                        type: 'error',
                        message: data.message ?? 'حدث خطأ في الحذف',
                    });
                }
            })
            .catch(error => {
                window.showToast({
                    type: 'error',
                    message: '{{ __('messages.unknown_error') }}',
                });
            });
    }

    // Initialize handlers on page load
    document.addEventListener('DOMContentLoaded', function() {
        rebindMessageHandlers();
    });

    // Listen for real-time message updates via Ably
    function setupAblyMessageListeners() {
        // Only setup if Ably is available and ticket info exists
        if (typeof ticketUpdatesChannel === 'undefined') return;

        // Listen for message updates
        ticketUpdatesChannel.subscribe('message-updated', (ablyMessage) => {
            const messageData = ablyMessage.data;
            const messageElement = document.querySelector(`[data-message-id="${messageData.id}"]`);

            if (messageElement) {
                const contentDiv = messageElement.querySelector('.content');
                if (contentDiv) {
                    contentDiv.innerHTML = messageData.message;
                }
            }
        });

        // Listen for message deletions
        ticketUpdatesChannel.subscribe('message-deleted', (ablyMessage) => {
            const messageData = ablyMessage.data;
            const messageElement = document.querySelector(`[data-message-id="${messageData.id}"]`);

            if (messageElement) {
                messageElement.style.opacity = '0.3';
                messageElement.style.textDecoration = 'line-through';

                setTimeout(() => messageElement.remove(), 300);
            }
        });
    }

    // Call setup on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupAblyMessageListeners);
    } else {
        setupAblyMessageListeners();
    }
</script>
