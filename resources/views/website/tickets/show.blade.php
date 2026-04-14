@extends('layouts.master')

@push('styles')
    <style>
        .ticket-show-sections {
            .print-ticket {
                display: none;
            }
        }

        textarea {
            min-height: 150px;
            background-color: #ffffff;
        }

        textarea:focus,
        textarea:focus-visible {
            border: #e7e7e7 1px solid !important;
            box-shadow: #e7e7e7 0px 0px 0px 1px !important;
        }

        @media print {
            .ticket-show-sections {
                padding: 15px;

                article {
                    display: none;
                }

                .print-ticket {
                    width: 100%;
                    padding: 20px;
                    display: block;
                    position: relative;

                    .date,
                    .page {
                        position: absolute;
                        left: 20px;
                    }

                    .date {
                        top: 20px;
                    }

                    .page {
                        bottom: 20px;
                    }
                }
            }

            body {
                background: white;
            }

            .header,
            .footer {
                display: none !important;
            }
        }
    </style>
@endpush

@section('content')
    <section class="ticket-show-sections relative" style="background-image: url('{{ \App\Helpers\CrossDeviceHelper::getSupportImage('logo') }}');">
        {{-- Heading --}}
        <article>
            <div class="flex items-center justify-between gap-4">
                <h2 class="font-semibold">{{ __('main.support_ticket') }}</h2>
                <button class="btn-link print-btn" onclick="window.print()">{{ __('main.print_pdf') }}</button>
            </div>
        </article>

        {{-- Ticket Details --}}
        <article>
            <div class="articles grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="article-item">
                    <div class="text-sm">{{ __('main.ticket_number') }}</div>
                    <div class="font-semibold">{{ $ticketData['uuid'] }}</div>
                </div>
                <div class="article-item">
                    <div class="text-sm">{{ __('main.status') }}</div>
                    <div class="font-semibold">
                        <span id="ticket-status-badge" class="kt-badge text-white {{ \App\Enum\TicketEnums::from($ticketData['status'])->badgeColor() }} rounded-full">
                            {{ __('main.' . $ticketData['status']) }}
                        </span>
                    </div>
                </div>
                <div class="article-item">
                    <div class="text-sm">{{ __('main.department') }}</div>
                    <div class="font-semibold">
                        <span id="ticket-department" class="kt-badge text-white rounded-full" style="background-color: {{ $ticketData['department']['border_main_color'] }}">
                            {{ app()->getLocale() == 'ar' ? $ticketData['department']['name_ar'] : $ticketData['department']['name'] ?? __('main.no_department') }}
                        </span>
                    </div>
                </div>
                <div class="article-item">
                    <div class="text-sm">{{ __('main.whatsapp') }}</div>
                    <div class="font-semibold">{{ $ticketData['phone'] }}</div>
                </div>
                <div class="article-item">
                    <div class="text-sm">{{ __('main.subject') }}</div>
                    <div class="font-semibold">{{ $ticketData['subject'] }}</div>
                </div>
                <div class="article-item">
                    <div class="text-sm">{{ __('main.date') }}</div>
                    <div class="font-semibold" style="font-size: 12px;">
                        @php
                            $createdAt = is_string($ticketData['created_at']) ? \Carbon\Carbon::parse($ticketData['created_at']) : $ticketData['created_at'];
                        @endphp
                        {{ $createdAt->format('d/m/Y H:i') }} - {{ $createdAt->diffForHumans() }}
                    </div>
                </div>
            </div>
        </article>

        {{-- Messages Section --}}
        <article id="messages-section" class="messages-section {{ $ticketData['messages'] && count($ticketData['messages']) > 0 ? '' : 'hidden' }}" style="padding-inline-end: 3px;">
            <div class="flex flex-col gap-4 messages-container">
                @foreach ($ticketData['messages'] as $message)
                    <div class="flex justify-between gap-4 client {{ $message['sender_type'] == 'customer' ? 'customer' : '' }}" data-message-id="{{ $message['id'] }}"
                        style="background-color: {{ $message['department']['bg_color'] ?? '' }}; border: 1px solid {{ $message['department']['border_color'] ?? 'var(--main-color)' }}; border-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 4px solid {{ $message['department']['border_main_color'] ?? 'var(--main-color)' }};">
                        <div class="flex gap-4">
                            <div class="avatar">
                                @php
                                    if ($message['sender_type'] == 'customer') {
                                        $imagePath = asset('assets/images/avatars/avatar.png');
                                        $alt = __('main.client_icon');
                                    } else {
                                        $imagePath = checkExistFile($message['user']['photo']) ? asset('storage/' . $message['user']['photo']) : asset('assets/images/avatars/avatar.png');
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
                                            {{ $message['sender_type'] == 'customer' ? $ticket->name : $message['user']['name'] ?? __('main.support_') }}
                                        </span>
                                        <span class="time mt-1">
                                            {{ $message['created_at'] }} - {{ $message['human_readable_date'] }}
                                        </span>
                                    </div>

                                    <div class="flex gap-2">
                                        <span class="w-fit block text-xs px-2 py-1 rounded-full badge-message"
                                            style="color: var(--light-color); background-color: {{ $message['department']['badge_color'] ?? 'var(--main-color)' }};">
                                            {{ $message['sender_type'] == 'customer' ? __('main.customer') : (app()->getLocale() == 'ar' ? $message['department']['name_ar'] : $message['department']['name'] ?? __('main.support_')) }}
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

                                @if ($message['sender_type'] == 'customer')
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

                        @if ($message['sender_type'] == 'customer')
                            <div class="actions {{ $ticket->status == \App\Enum\TicketEnums::CLOSED->value ? 'hidden' : 'grid' }}">
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
        <article class="{{ $ticketData['status'] == \App\Enum\TicketEnums::CLOSED->value ? 'hidden' : '' }}">
            <form action="{{ route('tickets.message', $ticketData['uuid']) }}" method="POST" enctype="multipart/form-data" class="tickets-message-form">
                @csrf
                <div class="{{ isset($classes) ? $classes : '' }}">
                    <label for="your_reply" class="kt-label mb-2">
                        {{ __('main.your_reply') }}
                        @if (isset($placeholder) && $placeholder)
                            <span class="text-sm text-primary">({{ $placeholder }})</span>
                        @endif
                    </label>
                    <textarea id="your_reply" name="your_reply" class="kt-textarea" required placeholder="{{ __('main.type_placeholder', ['type' => __('main.your_reply')]) }}">{{ old('your_reply') }}</textarea>
                    @error('your_reply')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="group mt-4">
                    {{-- Optional Attachment --}}
                    <label for="attachments" class="font-semibold mb-2 block">{{ __('main.contact_form_attachment') }}</label>
                    <div class="attachments flex flex-col gap-4" id="attachments-container">
                        <div class="input attachment-item flex items-center gap-2 p-2 rounded-[9px]" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
                            data-message="{{ __('messages.no_file_chosen') }}"
                            style="text-align: {{ app()->getLocale() == 'ar' ? 'end' : 'start' }} !important; border: 1px solid var(--dark-muted-color); @error('attachments') border: 1px solid red !important @enderror">
                            <input type="file" id="attachments" name="attachments[]" class="flex-1">
                        </div>
                    </div>

                    <div class="add-attachment-input mt-2" id="add-attachment-btn" style="cursor: pointer;" toggle-button>
                        {{ __('main.contact_form_add_attachment') }}
                    </div>
                </div>

                <button class="submit btn-link light-main-color font-semibold" toggle-button>
                    {{ __('main.send_reply') }}
                </button>
            </form>
        </article>

        {{-- Print Ticket --}}
        @include('website.tickets.print-ticket', ['ticket' => $ticketData])
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            header?.setAttribute('data-force-scrolled', 'true');
            header?.classList.add('scrolled');

            const addAttachmentBtn = document.getElementById('add-attachment-btn');
            const attachmentsContainer = document.getElementById('attachments-container');

            addAttachmentBtn?.addEventListener('click', function() {
                const div = document.createElement('div');
                div.className = 'input attachment-item flex items-center gap-2 p-2 rounded-[9px]';
                div.setAttribute('dir', "{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}");
                div.style = 'text-align: {{ app()->getLocale() == 'ar' ? 'end' : 'start' }} !important; border: 1px solid var(--dark-muted-color);';
                div.dataset.message = '{{ __('messages.no_file_chosen') }}';
                div.innerHTML = `
                    <input type="file" name="attachments[]" class="flex-1">
                    <button type="button" class="remove-attachment-btn cursor-pointer absolute text-red-600 text-lg leading-none z-999" aria-label="{{ __('main.delete') }}">
                        <i class="fas fa-xmark"></i>
                    </button>
                `;
                div.dataset.message = '{{ __('messages.no_file_chosen') }}';
                attachmentsContainer?.appendChild(div);
            });

            attachmentsContainer?.addEventListener('click', function(event) {
                const removeBtn = event.target.closest('.remove-attachment-btn');

                if (!removeBtn) {
                    return;
                }

                const attachmentItem = removeBtn.closest('.attachment-item');
                if (!attachmentItem) {
                    return;
                }

                const allAttachmentItems = attachmentsContainer.querySelectorAll('.attachment-item');
                if (allAttachmentItems.length == 0) {
                    const fileInput = attachmentItem.querySelector('input[type="file"]');
                    if (fileInput) {
                        fileInput.value = '';
                    }
                    return;
                }

                attachmentItem.remove();
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
            support: '{{ __('main.support_') }}',
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

            // Subscribe to new support replies
            ticketUpdatesChannel.subscribe('new-support-reply', (ablyMessage) => {
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
                        console.log('updateData: ', updateData);
                        const departmentElement = document.getElementById('ticket-department');
                        if (departmentElement) {
                            departmentElement.textContent = updateData.status_label;
                            departmentElement.style.backgroundColor = updateData.department.bg_color || '#f3f4f6';
                        }

                        // Show success message
                        if (window.showToast && typeof window.showToast == 'function') {
                            window.showToast({
                                type: 'success',
                                message: '{{ __('main.ticket_transferred', ['department' => ':department']) }}'.replace(':department', updateData.status_label)
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
            // const photoUrl = isCustomer ? '{{ asset('assets/images/avatars/avatar.png') }}' : user.photo || '{{ asset('assets/images/avatars/avatar.png') }}';
            const photoUrl = isCustomer ? '{{ asset('assets/images/avatars/avatar.png') }}' : user.photo ?? '{{ asset('assets/images/avatars/avatar.png') }}';

            // Display Name
            const displayName = isCustomer ? messageData.customer_name || '{{ __('main.customer') }}' : user.name || '{{ __('main.support_') }}';

            // Sender Label
            const senderLabel = isCustomer ? '{{ __('main.customer') }}' : (locale == 'ar' ? department.name_ar : department.name) || '{{ __('main.support') }}';

            // Styling
            const backgroundColor = `background-color: ${department.bg_color || "#f3f4f6"};`;
            const borderColor = `border: 1px solid ${department.border_color || "var(--main-color)"};`;
            const borderMainColor = `border-${borderDirection}: 4px solid ${department.border_main_color || "var(--main-color)"};`;
            const badgeColor = `background-color: ${department.badge_color || "var(--main-color)"}; color: var(--light-color);`;
            const ticketStatus = '{{ $ticket->status == \App\Enum\TicketEnums::CLOSED->value ? 'hidden' : 'grid' }}';

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

                ${isCustomer ? `
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
                            
                            ${isCustomer ? `
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
