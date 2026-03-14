@extends('layouts.master')

@push('styles')
    <style>
        .ticket-show-sections {
            .print-ticket {
                display: none;
            }
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
    <section class="ticket-show-sections relative">
        <article>
            <div class="flex items-center justify-between gap-4">
                <h2 class="font-semibold">{{ __('main.support_ticket') }}</h2>
                <button class="btn-link print-btn" onclick="window.print()">{{ __('main.print_pdf') }}</button>
            </div>
        </article>

        <article>
            <div class="articles grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="article-item">
                    <div class="text-sm">{{ __('main.ticket_number') }}</div>
                    <div class="font-semibold">{{ $ticket->uuid }}</div>
                </div>
                <div class="article-item">
                    <div class="text-sm">{{ __('main.status') }}</div>
                    <div class="font-semibold">
                        <span id="ticket-status-badge" class="kt-badge text-white {{ \App\Enum\TicketEnums::from($ticket->status)->badgeColor() }} rounded-full">
                            {{ __('main.' . $ticket->status) }}
                        </span>
                    </div>
                </div>
                <div class="article-item">
                    <div class="text-sm">{{ __('main.department') }}</div>
                    <div class="font-semibold" id="ticket-department">{{ $ticket->department?->name ?? __('main.no_department') }}</div>
                </div>
                <div class="article-item">
                    <div class="text-sm">{{ __('main.whatsapp') }}</div>
                    <div class="font-semibold">{{ $ticket->phone }}</div>
                </div>
                <div class="article-item">
                    <div class="text-sm">{{ __('main.subject') }}</div>
                    <div class="font-semibold">{{ $ticket->subject }}</div>
                </div>
                <div class="article-item">
                    <div class="text-sm">{{ __('main.date') }}</div>
                    <div class="font-semibold">{{ $ticket->created_at->format('d/m/Y H:i') }} - {{ $ticket->created_at->diffForHumans() }}</div>
                </div>
            </div>
        </article>

        @if ($ticket->messages && count($ticket->messages) > 0)
            <article style="padding-inline-end: 3px;">
                <div class="flex flex-col gap-4 messages-container">
                    @foreach ($ticket->messages as $message)
                        <div class="flex justify-between gap-4 client {{ $message->sender_type == 'customer' ? 'bg-gray-100 border-gray-600 text-gray-800' : \App\Enum\DepartmentEnums::from($message->department?->slug)->badgeStyle() }}"
                            data-message-id="{{ $message->id }}">
                            <div class="flex gap-4">
                                <div class="avatar">
                                    <a href="{{ asset('assets/images/avatar.png') }}" class="client-avatar block">
                                        @if ($message->sender_type == 'customer')
                                            <img decoding="async" src="{{ asset('assets/images/avatar.png') }}" alt="{{ __('main.client_icon') }}"
                                                class="fal-content-img">
                                        @elseif($message->sender_type == 'support')
                                            <img decoding="async" src="{{ asset('assets/images/avatars/' . $message->department?->image) }}"
                                                alt="{{ __('main.support_icon') }}" class="fal-content-img">
                                        @else
                                            <img decoding="async" src="{{ asset('assets/images/avatar.png') }}" alt="{{ __('main.client_icon') }}"
                                                class="fal-content-img">
                                        @endif
                                    </a>
                                </div>
                                <div class="body">
                                    <div class="meta flex items-start gap-2">
                                        <div class="flex flex-col gap-2">
                                            <span
                                                class="who font-semibold">{{ $message->sender_type == 'customer' ? $ticket->name : $message->department?->name ?? __('main.support') }}</span>
                                            <div class="flex gap-2">
                                                <span
                                                    class="w-fit block text-xs px-2 py-1 rounded-full {{ $message->sender_type == 'customer' ? 'bg-blue-100 text-blue-800' : \App\Enum\DepartmentEnums::from($message->department?->slug)->badgeColor() }}">
                                                    {{ $message->sender_type == 'customer' ? __('main.customer') : __('main.' . $message->department?->title) ?? __('main.' . $message->department?->slug) }}
                                                </span>
                                            </div>
                                        </div>
                                        <span class="time mt-1">{{ $message->created_at->format('d/m/Y H:i') }} -
                                            {{ $message->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="content">{!! $message->message !!}</div>
                                    <div class="files flex items-center gap-2">
                                        @if ($message->attachments && is_array($message->attachments) && count($message->attachments) > 0)
                                            @foreach ($message->attachments as $attachment)
                                                <div class="client-attachment flex items-center gap-2 clickable-img"
                                                    data-src="{{ asset('storage/' . $attachment) }}">
                                                    <img draggable="false" role="img" alt="📎"
                                                        src="https://s.w.org/images/core/emoji/17.0.2/svg/1f4ce.svg">
                                                    {{ __('main.attachment') }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="edit-form" style="display:none;">
                                        <div class="mt-3 p-3 bg-gray-50 rounded border border-gray-200">
                                            <textarea class="edit-textarea w-full p-2 border rounded" rows="4">{{ strip_tags($message->message) }}</textarea>
                                            <div class="edit-buttons flex gap-2 mt-3">
                                                <button class="message-save-btn cursor-pointer px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700"
                                                    data-message-id="{{ $message->id }}">
                                                    {{ __('main.save') }}
                                                </button>
                                                <button class="message-cancel-btn cursor-pointer px-4 py-1 bg-gray-400 text-white rounded hover:bg-gray-500">
                                                    {{ __('main.cancel') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="actions {{ !in_array($ticket->status, ['open', 'in_progress', 'replied']) ? 'hidden' : '' }}">
                                <button type="button" class="message-edit-btn px-4 py-2" data-message-id="{{ $message->id }}">
                                    {{ __('main.edit') }}
                                </button>
                                <button type="button" class="message-delete-btn px-4 py-2" data-message-id="{{ $message->id }}">
                                    {{ __('main.delete') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        @else
            <article>
                <p class="text-gray-500 text-center py-4">{{ __('main.no_messages_yet') }}</p>
            </article>
        @endif

        <article class="{{ !in_array($ticket->status, ['open', 'in_progress', 'replied']) ? 'hidden' : '' }}">
            <form action="{{ route('tickets.message', $ticket->uuid) }}" method="POST" enctype="multipart/form-data" class="tickets-message-form">
                @csrf
                @include('dashboard.components.input-text-editor', [
                    'name' => 'your_reply',
                    'value' => old('your_reply'),
                ])

                <div class="group mt-4">
                    {{-- Optional Attachment --}}
                    <label for="attachments" class="font-semibold mb-2 block">{{ __('main.contact_form_attachment') }}</label>
                    <div class="attachments flex flex-col gap-4" id="attachments-container">
                        <div class="input flex w-half p-2 rounded-[9px]" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
                            data-message="{{ __('messages.no_file_chosen') }}"
                            style="text-align: {{ app()->getLocale() == 'ar' ? 'end' : 'start' }} !important; border: 1px solid var(--dark-muted-color); @error('attachments') border: 1px solid red !important @enderror">
                            <input type="file" id="attachments" name="attachments[]">
                        </div>
                    </div>

                    <div class="add-attachment-input mt-2" id="add-attachment-btn" style="cursor: pointer;">
                        {{ __('main.contact_form_add_attachment') }}
                    </div>
                </div>

                <button class="submit btn-link light-main-color font-semibold">
                    {{ __('main.send_reply') }}
                </button>
            </form>
        </article>

        {{-- This Part to Print Ticket --}}
        <div class="print-ticket">
            <!-- title -->
            <h1 class="text-3xl font-bold text-right mb-6">{{ __('main.ticket') }} #{{ $ticket->uuid }}</h1>

            <!-- ticket info -->
            <div class="border rounded-xl p-4 mb-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <p class="mb-1"><b>{{ __('main.status') }}:</b> {{ $ticket->status }}</p>
                        <p class="mb-1"><b>{{ __('main.customer') }}:</b> {{ $ticket->name }}</p>
                        <p class="mb-1"><b>{{ __('main.subject') }}:</b> {{ $ticket->subject }}</p>
                    </div>
                    <div class="space-y-2">
                        <p class="mb-1"><b>{{ __('main.department') }}:</b> {{ $ticket->department?->name ?? __('main.no_department') }}</p>
                        <p class="mb-1"><b>{{ __('main.email_') }}:</b> {{ $ticket->email }}</p>
                        <p class="mb-1"><b>{{ __('main.date') }}:</b> {{ $ticket->created_at }}</p>
                    </div>
                </div>
            </div>

            <!-- messages -->
            <div class="flex flex-col gap-4">
                @foreach ($ticket->messages as $message)
                    <div class="border rounded-xl p-2 {{ $message->sender_type == 'customer' ? 'bg-blue-50' : 'bg-red-50' }}">
                        <div class="text-sm text-gray-700">
                            {{ $message->sender_type == 'customer' ? $message->ticket->name : $message->user->name }}
                            —
                            {{ $message->created_at }}
                        </div>
                        <div class="text-gray-800">
                            {!! $message->message !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            header?.setAttribute('data-force-scrolled', 'true');
            header?.classList.add('scrolled');

            let addAttachmentBtn = document.getElementById('add-attachment-btn');
            addAttachmentBtn?.addEventListener('click', function() {
                const container = document.getElementById('attachments-container');

                for (let i = 0; i < 1; i++) {
                    const div = document.createElement('div');
                    div.className = 'input flex w-half p-2 rounded-[9px]';
                    div.style = 'border: 1px solid var(--dark-muted-color);';
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
        const ticketUpdates = new Ably.Realtime({
            key: '{{ config('app.ably_key') }}',
            logLevel: 1
        });
        const ticketUpdatesChannel = ticketUpdates.channels.get('ticket-updates');

        // Subscribe to ticket deletion events
        ticketUpdatesChannel.subscribe('ticket-deleted', (ablyMessage) => {
            const deletedData = ablyMessage.data;

            // If the deleted ticket is the current one, redirect user
            if (deletedData.uuid === '{{ $ticket->uuid }}') {
                // Show notification
                if (window.showToast && typeof window.showToast === 'function') {
                    window.showToast({
                        type: 'warning',
                        message: '{{ __('main.ticket_deleted_by_admin') }}'
                    });
                }

                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = '{{ route('tickets.inquiry') }}';
                }, 2000);
            }
        });

        // Subscribe to new support replies
        ticketUpdatesChannel.subscribe('new-support-reply', (ablyMessage) => {
            const messageData = ablyMessage.data;
            console.log('customerMessageData', messageData);

            // Only add message if it belongs to current ticket
            if (messageData.ticket_uuid === '{{ $ticket->uuid }}') {
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

            if (messageElement) {
                messageElement.style.opacity = '0.5';
                messageElement.style.textDecoration = 'line-through';
                setTimeout(() => messageElement.remove(), 1000);
            }
        });

        // Subscribe to ticket status updates
        ticketUpdatesChannel.subscribe('ticket-status-updated', (ablyMessage) => {
            const updateData = ablyMessage.data;

            // Only update if it belongs to current ticket
            if (updateData.uuid === '{{ $ticket->uuid }}') {
                // Update status if field is 'status'
                if (updateData.field === 'status') {
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

                    // Update form and action buttons visibility based on new status
                    const activeStatuses = ['open', 'in_progress', 'replied'];
                    const isActive = activeStatuses.includes(updateData.new_status);

                    // Get all reply forms
                    const replyForms = document.querySelectorAll('.tickets-message-form');
                    replyForms.forEach(form => {
                        form.closest('article').style.display = isActive ? 'block' : 'none';
                    });

                    // Get all action buttons (edit/delete) for messages
                    const messageActions = document.querySelectorAll('.client .actions');
                    messageActions.forEach(actions => {
                        actions.style.display = isActive ? 'block' : 'none';
                    });
                }

                // Update department if field is 'department_id'
                if (updateData.field === 'department_id') {
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

        /**
         * Add new message to the messages container without page reload
         */
        function addNewMessageToPage(messageData) {
            const messagesContainer = document.querySelector('.messages-container');
            if (!messagesContainer) return;

            // Determine photo URL based on sender type
            let photo = '{{ asset('assets/images/avatar.png') }}';
            if (messageData.sender_type === 'support' && messageData.user_photo) {
                // user_photo already contains 'storage/' prefix
                photo = messageData.user_photo.startsWith('storage/') ?
                    '{{ asset('') }}' + messageData.user_photo :
                    '{{ asset('storage/') }}' + messageData.user_photo;
            }

            // Determine sender name based on message type
            const senderName = messageData.sender_type === 'customer' ?
                messageData.ticket_name :
                messageData.user_name;

            // Create message element HTML
            const messageHtml = `
                <div class="flex justify-between gap-4 client {{ $message->sender_type == 'customer' ? 'bg-gray-100 border-gray-600 text-gray-800' : \App\Enum\DepartmentEnums::from($message->department?->slug)->badgeStyle() }}" data-message-id="${messageData.id}">
                    <div class="flex gap-4">
                        <div class="avatar">
                            <a href="${photo}" class="client-avatar block">
                                ${messageData.sender_type === 'customer' 
                                    ? `<img decoding="async" src="{{ asset('assets/images/avatar.png') }}" alt="${translations.clientIcon}" class="fal-content-img">` 
                                    : `<img decoding="async" src="{{ asset('assets/images/avatars/') }}${messageData.department_image || 'support.png'}" alt="${translations.support}" class="fal-content-img">`
                                }
                            </a>
                        </div>
                        <div class="body">
                            <div class="meta flex items-start gap-2">
                                <div class="flex flex-col gap-2">
                                    <span class="who font-semibold">${senderName}</span>
                                    <div class="flex gap-2">
                                        <span
                                            class="w-fit block text-xs px-2 py-1 rounded-full ${messageData.sender_type == 'customer' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'}">
                                            {{ $message->sender_type == 'customer' ? __('main.customer') : __('main.support') }}
                                        </span>
                                        ${messageData.department_name && messageData.sender_type === 'support' ? `<span class="w-fit block text-xs px-2 py-1 rounded-full bg-purple-100 text-purple-800">${messageData.department_name}</span>` : ''}
                                    </div>
                                </div>
                                <span class="time mt-1">${messageData.formatted_date} -
                                    ${messageData.human_readable_date}</span>
                            </div>
                            <div class="content">${messageData.message}</div>
                            <div class="files flex items-center gap-2">
                                ${messageData.attachments && Array.isArray(messageData.attachments) && messageData.attachments.length > 0
                                    ? messageData.attachments.map(attachment => `
                                                                                <div class="client-attachment flex items-center gap-2 clickable-img" data-src="{{ asset('storage/') }}${attachment}">
                                                                                    <img draggable="false" role="img" alt="📎" src="https://s.w.org/images/core/emoji/17.0.2/svg/1f4ce.svg">
                                                                                    {{ __('main.attachment') }}
                                                                                </div>
                                                                            `).join('')
                                    : ''
                                }
                            </div>
                            <div class="edit-form" style="display:none;">
                                <div class="mt-3 p-3 bg-gray-50 rounded border border-gray-200">
                                    <textarea class="edit-textarea w-full p-2 border rounded" rows="4">${stripHtmlTags(messageData.message)}</textarea>
                                    <div class="edit-buttons flex gap-2 mt-3">
                                        <button class="message-save-btn cursor-pointer px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700" data-message-id="${messageData.id}">
                                            {{ __('main.save') }}
                                        </button>
                                        <button class="message-cancel-btn cursor-pointer px-4 py-1 bg-gray-400 text-white rounded hover:bg-gray-500">
                                            {{ __('main.cancel') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="actions ${'{{ !in_array($ticket->status, ['open', 'in_progress', 'replied']) ? 'hidden' : '' }}'}">
                        <button type="button" class="message-edit-btn px-4 py-2" data-message-id="${messageData.id}">
                            {{ __('main.edit') }}
                        </button>
                        <button type="button" class="message-delete-btn px-4 py-2" data-message-id="${messageData.id}">
                            {{ __('main.delete') }}
                        </button>
                    </div>
                </div>
            `;

            // Insert the new message at the end of messages container
            messagesContainer.insertAdjacentHTML('beforeend', messageHtml);

            // Rebind message handlers for the new message
            if (typeof rebindMessageHandlers === 'function') {
                rebindMessageHandlers();
            }

            // Scroll to the new message smoothly
            setTimeout(() => {
                messagesContainer.lastElementChild?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                });
            }, 100);
        }
    </script>
@endpush
