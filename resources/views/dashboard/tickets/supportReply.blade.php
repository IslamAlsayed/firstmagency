@extends('dashboard.layout.master')

@section('title', __('main.ticket_details'))
@section('page-title', '🎫 ' . limitedText($ticket->subject, 30))

@section('content')
    <div class="bg-white group radius-lg shadow-sm p-6 border border-gray-100 mb-6">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $ticket->subject ?? __('main.ticket_details') }} - <span
                        class="px-3 py-1 rounded-full text-xs font-semibold text-white {{ \App\Enum\TicketEnums::from($ticket->status)->badgeColor() }}">
                        {{ __('main.' . $ticket->status) }} </span>
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $ticket->created_at?->format('d M Y') }} • <span class="font-semibold">#{{ $ticket->uuid }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                @can('update', $ticket)
                    <a href="{{ route('dashboard.tickets.edit', $ticket->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.tickets.show', $ticket->id) }}" class="kt-btn kt-btn-outline-primary">
                    {{ __('main.details') }}
                </a>
                <a href="{{ route('dashboard.tickets.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tickets')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white group radius-lg shadow-sm p-6 border border-gray-100">
        <div class="grid gap-4">
            {{-- Messages Section --}}
            <article id="messages-section" class="messages-section {{ $ticketData['messages'] && count($ticketData['messages']) > 0 ? '' : 'hidden' }}" style="padding-inline-end: 3px;">
                <div class="flex flex-col gap-4 messages-container">
                    @foreach ($ticketData['messages'] as $message)
                        <div class="flex justify-between gap-4 client {{ $message['sender_type'] == 'customer' ? 'customer' : '' }}" data-message-id="{{ $message['id'] }}"
                            style="background-color: {{ $message['department']['bg_color'] ?? 'var(--light-color)' }}; border: 1px solid {{ $message['department']['border_color'] ?? 'var(--color-gray-300)' }}; border-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 4px solid {{ $message['department']['border_main_color'] ?? 'var(--dash_primary_color)' }};">
                            <div class="flex gap-4">
                                <div class="avatar">
                                    @php
                                        if ($message['sender_type'] == 'customer') {
                                            $imagePath = asset('assets/images/avatars/avatar.png');
                                            $alt = __('main.client_icon');
                                        } else {
                                            $imagePath = $message['user']['photo'] ? $message['user']['photo'] : asset('assets/images/avatars/avatar.png');
                                            $alt = __('main.support_icon');
                                        }
                                    @endphp
                                    <a href="{{ $imagePath }}" class="client-avatar block">
                                        <img decoding="async" src="{{ $imagePath }}" alt="{{ $alt }}" class="fal-content-img">
                                    </a>
                                </div>
                                <div class="body">
                                    <div class="meta">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="who font-semibold">
                                                {{ $message['sender_type'] == 'customer' ? $ticket->name : $message['user']['name'] ?? __('main.support') }}
                                            </span>
                                            <span class="time mt-1">
                                                {{ $message['created_at'] }} - {{ $message['human_readable_date'] }}
                                            </span>
                                        </div>

                                        <div class="flex gap-2">
                                            <span class="w-fit block text-xs px-2 py-1 rounded-full badge-message"
                                                style="color: var(--light-color); background-color: {{ $message['department']['badge_color'] ?? 'var(--dash_primary_color)' }};">
                                                {{ $message['sender_type'] == 'customer' ? __('main.customer') : $message['department']['name'] ?? __('main.support') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="content">{!! $message['message'] !!}</div>
                                    <div class="files flex items-center gap-2">
                                        @if ($message['attachments'] && is_array($message['attachments']) && count($message['attachments']) > 0)
                                            @foreach ($message['attachments'] as $attachment)
                                                <div class="client-attachment flex items-center gap-2 clickable-img" data-src="{{ asset('storage/' . $attachment) }}">
                                                    <img draggable="false" role="img" alt="📎" src="https://s.w.org/images/core/emoji/17.0.2/svg/1f4ce.svg">
                                                    {{ __('main.attachment') }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    @if ($message['sender_type'] == 'support')
                                        <div class="edit-form" style="display:none;">
                                            <div class="mt-3 p-3 bg-gray-50 rounded border border-gray-200">
                                                <textarea class="edit-textarea w-full p-2 border rounded" rows="4">{{ strip_tags($message['message']) }}</textarea>
                                                <div class="edit-buttons flex gap-2 mt-3">
                                                    <button class="message-save-btn cursor-pointer px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700" data-message-id="{{ $message['id'] }}">
                                                        {{ __('main.save') }}
                                                    </button>
                                                    <button class="message-cancel-btn cursor-pointer px-4 py-1 bg-gray-400 text-white rounded hover:bg-gray-500">
                                                        {{ __('main.cancel') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($message['sender_type'] == 'support')
                                <div class="actions {{ $ticket->status == \App\Enum\TicketEnums::CLOSED->value ? 'hidden' : 'flex' }}">
                                    <button type="button" class="message-edit-btn px-4 py-2" data-message-id="{{ $message['id'] }}">
                                        {{ __('main.edit') }}
                                    </button>
                                    <button type="button" class="message-delete-btn px-4 py-2" data-message-id="{{ $message['id'] }}">
                                        {{ __('main.delete') }}
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </article>

            {{-- Reply Form --}}
            <article class="{{ $ticket->status == \App\Enum\TicketEnums::CLOSED->value ? 'hidden' : '' }}">
                @include('dashboard.tickets.reply-form', ['ticket' => $ticket])
            </article>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let addAttachmentBtn = document.getElementById('add-attachment-btn');
            addAttachmentBtn?.addEventListener('click', function() {
                const container = document.getElementById('attachments-container');

                for (let i = 0; i < 1; i++) {
                    const div = document.createElement('div');
                    div.className = 'input flex w-half p-2 rounded-[9px]';
                    div.style = 'border: 1px solid var(--color-gray-300);';
                    div.innerHTML = '<input type="file" name="attachments[]">';
                    container.appendChild(div);
                }
            });
        });

        // Helper function to strip HTML tags
        function stripHtmlTags(html) {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            return tempDiv.textContent || tempDiv.innerText || '';
        }
    </script>

    @include('dashboard.components.messages-action')

    <script>
        // Translation variables for JavaScript
        const translations = {
            customer: '{{ __('main.customer') }}',
            support: '{{ __('main.support') }}',
            clientIcon: '{{ __('main.client_icon') }}'
        };

        // Initialize Ably for real-time ticket updates
        const ablyKey = '{{ config('app.ably_key') }}';
        if (typeof Ably == 'undefined' || !ablyKey) {
            console.warn('Ably is not available or ABLY_KEY is missing.');
        } else {
            const ticketUpdates = new Ably.Realtime({
                key: ablyKey,
                logLevel: 1
            });
            window.ticketUpdatesChannel = ticketUpdates.channels.get('ticket-updates');
            window.dispatchEvent(new CustomEvent('ticket-channel-ready'));
            const ticketUpdatesChannel = window.ticketUpdatesChannel;

            // Subscribe to ticket deletion events
            ticketUpdatesChannel.subscribe('ticket-deleted', (ablyMessage) => {
                const deletedData = ablyMessage.data;

                // If the deleted ticket is the current one, redirect user
                if (deletedData.uuid == '{{ $ticket->uuid }}') {
                    // Show notification
                    if (window.showToast && typeof window.showToast == 'function') {
                        window.showToast({
                            type: 'warning',
                            message: '{{ __('main.ticket_deleted_by_admin') }}'
                        });
                    }

                    // Redirect after 3 seconds
                    setTimeout(() => {
                        window.location.href = '{{ route('tickets.inquiry') }}';
                    }, 3000);
                }
            });

            // Subscribe to new customer replies
            ticketUpdatesChannel.subscribe('new-customer-reply', (ablyMessage) => {
                const messageData = ablyMessage.data;
                let messagesSection = document.getElementById('messages-section');
                messagesSection.classList.remove('hidden');

                // Only add message if it belongs to current ticket
                if (messageData.ticket_uuid == '{{ $ticket->uuid }}') {
                    addNewMessageToPage(messageData);
                }
            });

            // Subscribe to message updates
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

            // Subscribe to message deletions
            ticketUpdatesChannel.subscribe('message-deleted', (ablyMessage) => {
                const messageData = ablyMessage.data;
                const messageElement = document.querySelector(`[data-message-id="${messageData.id}"]`);

                let messagesSection = document.getElementById('messages-section');
                if (messagesSection) {
                    const remainingMessages = messagesSection.querySelectorAll('.client');
                    if (remainingMessages.length == 1 && remainingMessages[0].dataset.messageId == messageData.id) {
                        messagesSection.classList.add('hidden');
                    }
                }

                if (messageElement) {
                    messageElement.style.opacity = '0.3';
                    messageElement.style.textDecoration = 'line-through';
                    setTimeout(() => messageElement.remove(), 300);
                }
            });

            // Subscribe to ticket status updates
            ticketUpdatesChannel.subscribe('ticket-status-updated', (ablyMessage) => {
                const updateData = ablyMessage.data;

                // Only update if it belongs to current ticket
                if (updateData.uuid == '{{ $ticket->uuid }}') {
                    // Update status if field is 'status'
                    if (updateData.field == 'status') {
                        const statusBadge = document.getElementById('ticket-status-badge');
                        if (statusBadge) {
                            // Get the color class based on the new status
                            const statusColorMap = {
                                'open': 'bg-yellow-600',
                                'in_progress': 'bg-blue-600',
                                'processed': 'bg-violet-600',
                                'replied': 'bg-green-600',
                                'closed': 'bg-red-600'
                            };

                            // Update badge text and color
                            statusBadge.textContent = updateData.status_label;

                            // Remove all status color classes
                            statusBadge.className = 'kt-badge text-white rounded-full';

                            // Add the new color class
                            const newColorClass = statusColorMap[updateData.new_status] || 'bg-gray-600';
                            statusBadge.classList.add(newColorClass);
                        }

                        // Get all reply forms
                        const replyForms = document.querySelectorAll('.tickets-message-form');
                        replyForms.forEach(form => {
                            form.closest('article').classList.toggle('hidden');
                        });

                        // Get all action buttons (edit/delete) for messages
                        const messageActions = document.querySelectorAll('.client .actions');
                        messageActions.forEach(actions => {
                            actions.classList.toggle('hidden');
                        });
                    }

                    // Update department if field is 'department.id'
                    if (updateData.field == 'department.id') {
                        const departmentElement = document.getElementById('ticket-department');
                        if (departmentElement) {
                            departmentElement.textContent = updateData.status_label;
                            window.showToast({
                                type: 'success',
                                message: '{{ __('main.ticket_transferred', ['department' => ':department']) }}'.replace(':department', updateData
                                    .status_label)
                            });
                        }
                    }
                }
            });
        }

        /**
         * Add new message to the messages container without page reload
         */
        function addNewMessageToPage(messageData) {
            const messagesContainer = document.querySelector('.messages-container');
            if (!messagesContainer) return;

            // Current locale for border direction
            const locale = '{{ app()->getLocale() }}';
            const borderDirection = locale == 'ar' ? 'left' : 'right';

            const isCustomer = messageData.sender_type == 'customer';

            // User & Department
            const user = messageData.user ?? {};
            const department = messageData.department ?? {};

            // Photo
            const photoUrl = isCustomer ? '{{ asset('assets/images/avatars/avatar.png') }}' : (user.photo ? '{{ asset('storage/') }}' + user.photo : '{{ asset('assets/images/avatars/avatar.png') }}');

            // Display Name
            const displayName = isCustomer ? messageData.customer_name || '{{ __('main.customer') }}' : user.name || '{{ __('main.support') }}';

            // Sender Label
            const senderLabel = isCustomer ? '{{ __('main.customer') }}' : department.name || '{{ __('main.support') }}';

            // Styling
            const backgroundColor = `background-color: ${department.bg_color || "var(--light-color)"};`;
            const borderColor = `border: 1px solid ${department.border_color || "var(--color-gray-300)"};`;
            const borderMainColor = `border-${borderDirection}: 4px solid ${department.border_main_color || "var(--dash_primary_color)"};`;
            const badgeColor = `background-color: ${department.badge_color || "var(--dash_primary_color)"}; color: var(--light-color);`;
            const ticketStatus = '{{ $ticket->status == \App\Enum\TicketEnums::CLOSED->value ? 'hidden' : 'flex' }}';

            // Create message HTML
            const messageHtml = `
                <div class="flex justify-between gap-4 client ${isCustomer ? 'customer' : ''}" data-message-id="${messageData.id}" style="${backgroundColor} ${borderColor} ${borderMainColor}">
                    <div class="flex gap-4">
                        <div class="avatar">
                            <a href="${photoUrl}" class="client-avatar block">
                                <img decoding="async" src="${photoUrl}" alt="${isCustomer ? '{{ __('main.client_icon') }}' : '{{ __('main.support_icon') }}'}" class="fal-content-img">
                            </a>
                        </div>
                        <div class="body">
                            <div class="meta">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="who font-semibold">${displayName}</span>
                                    <span class="time mt-1">${messageData.created_at} - ${messageData.human_readable_date}</span>
                                </div>
                                <div class="flex gap-2">
                                    <span class="w-fit block text-xs px-2 py-1 rounded-full badge-message" style="${badgeColor}">
                                        ${senderLabel}
                                    </span>
                                </div>
                            </div>
                            <div class="content">${messageData.message}</div>
                            <div class="files flex items-center gap-2">
                                ${messageData.attachments && Array.isArray(messageData.attachments) && messageData.attachments.length > 0
                                    ? messageData.attachments.map(att => `
                                                                                                                                                                                                <div class="client-attachment flex items-center gap-2 clickable-img" data-src="{{ asset('storage/') }}${att}">
                                                                                                                                                                                                    <img draggable="false" role="img" alt="📎" src="https://s.w.org/images/core/emoji/17.0.2/svg/1f4ce.svg">
                                                                                                                                                                                                    {{ __('main.attachment') }}
                                                                                                                                                                                                </div>`).join('')
                                    : ''
                                }
                            </div>

                    ${!isCustomer ? `
                                                                                                                            <div class="edit-form" style="display:none;">
                                                                                                                                <div class="mt-3 p-3 bg-gray-50 rounded border border-gray-200">
                                                                                                                                    <textarea class="edit-textarea w-full p-2 border rounded" rows="4">${stripHtmlTags(messageData.message)}</textarea>
                                                                                                                                    <div class="edit-buttons flex gap-2 mt-3">
                                                                                                                                        <button class="message-save-btn cursor-pointer px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700" data-message-id="${messageData.id}">{{ __('main.save') }}</button>
                                                                                                                                        <button class="message-cancel-btn cursor-pointer px-4 py-1 bg-gray-400 text-white rounded hover:bg-gray-500">{{ __('main.cancel') }}</button>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                </div>` : ''}
                        </div>
                    </div>

                    ${!isCustomer ? `
                                                                                                                                            <div class="actions ${ticketStatus}">
                                                                                                                                                <button type="button" class="message-edit-btn px-4 py-2" data-message-id="${messageData.id}">{{ __('main.edit') }}</button>
                                                                                                                                                <button type="button" class="message-delete-btn px-4 py-2" data-message-id="${messageData.id}">{{ __('main.delete') }}</button>
                                                                                                                                            </div>
                                                                                                                                        </div>` : ''}
                `;

            // Append message
            messagesContainer.insertAdjacentHTML('beforeend', messageHtml);

            // Rebind handlers if needed
            if (typeof rebindMessageHandlers == 'function') rebindMessageHandlers();

            // Scroll smoothly
            setTimeout(() => {
                messagesContainer.lastElementChild?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                });
            }, 100);
        }
    </script>
@endpush
