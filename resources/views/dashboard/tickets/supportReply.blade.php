@extends('dashboard.layout.master')

@section('title', __('main.ticket_details'))
@section('page-title', '🎫 ' . limitedText($ticket->subject, 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $ticket->subject ?? __('main.ticket_details') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $ticket->user?->name ?? '-' }} • {{ $ticket->created_at?->format('d M Y') }}
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
                    {{ __('main.show') }}
                </a>
                <a href="{{ route('dashboard.tickets.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tickets')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4">
            @if ($ticket->messages && count($ticket->messages) > 0)
                <article>
                    <div class="flex flex-col gap-4 messages-container">
                        @foreach ($ticket->messages as $message)
                            <div class="flex justify-between gap-4 client {{ $message->sender_type }}" data-message-id="{{ $message->id }}">
                                <div class="flex gap-4">
                                    <div class="avatar">
                                        <a href="{{ asset('assets/images/avatar.png') }}" class="client-avatar block">
                                            <img decoding="async" src="{{ asset('assets/images/avatar.png') }}" alt="أيقونة العميل" class="fal-content-img">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="meta flex items-center gap-2">
                                            <span class="who font-semibold">{{ $ticket->name ?? __('main.user') }}</span>
                                            <span class="time">{{ $message->created_at->format('d/m/Y H:i') }} -
                                                {{ $message->created_at->diffForHumans() }}</span>
                                            <span
                                                class="text-xs px-2 py-1 rounded-full {{ $message->sender_type == 'customer' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $message->sender_type == 'customer' ? 'عميل' : 'دعم' }}
                                            </span>
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

                                <div class="actions flex gap-2">
                                    <div class="message-edit-btn px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700"
                                        data-message-id="{{ $message->id }}">
                                        {{ __('main.edit') }}
                                    </div>
                                    <div class="message-delete-btn px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" data-message-id="{{ $message->id }}">
                                        {{ __('main.delete') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>
            @else
                <article>
                    <p class="text-gray-500 text-center py-4">لا توجد رسائل حتى الآن</p>
                </article>
            @endif

            <article>
                <form action="{{ route('dashboard.tickets.support-reply.store', ['ticketId' => $ticket->id]) }}" method="POST" enctype="multipart/form-data"
                    class="tickets-message-form">
                    @csrf
                    @include('dashboard.components.input-text-editor', [
                        'name' => 'your_reply',
                        'value' => old('your_reply'),
                    ])

                    <div class="group my-4">
                        {{-- Optional Attachment --}}
                        <label for="attachments" class="font-semibold mb-2 block">{{ __('main.contact_form_attachment') }}</label>
                        <div class="attachments flex flex-col gap-4" id="attachments-container">
                            <div class="input flex w-half p-2 rounded-[9px]"
                                style="border: 1px solid var(--primary); @error('attachments') border: 1px solid red !important @enderror">
                                <input type="file" id="attachments" name="attachments[]">
                            </div>
                        </div>

                        <div class="add-attachment-input mt-4" id="add-attachment-btn">
                            {{ __('main.contact_form_add_attachment') }}
                        </div>
                    </div>

                    <button class="kt-btn kt-btn-outline-primary font-semibold">
                        {{ __('main.send_reply') }}
                    </button>
                </form>
            </article>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('add-attachment-btn').addEventListener('click', function() {
            const container = document.getElementById('attachments-container');

            if (container) {
                const div = document.createElement('div');
                div.className = 'input flex w-half p-2 rounded-[9px]';
                div.style = 'border: 1px solid var(--primary);';
                div.innerHTML = '<input type="file" name="attachments[]">';
                container.appendChild(div);
            }
        });

        // Helper function to strip HTML tags
        function stripHtmlTags(html) {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            return tempDiv.textContent || tempDiv.innerText || '';
        }
    </script>

    <script>
        // Initialize Ably for real-time ticket updates
        const ticketUpdates = new Ably.Realtime({
            key: '{{ config('app.ably_key') }}',
            logLevel: 1
        });
        const ticketUpdatesChannel = ticketUpdates.channels.get('ticket-updates');

        // Subscribe to new customer replies
        ticketUpdatesChannel.subscribe('new-customer-reply', (ablyMessage) => {
            const messageData = ablyMessage.data;

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

        /**
         * Add new message to the messages container without page reload
         */
        function addNewMessageToPage(messageData) {
            const messagesContainer = document.querySelector('.messages-container');
            if (!messagesContainer) return;

            // Create message element HTML
            const messageHtml = `
                <div class="flex justify-between gap-4 client ${messageData.sender_type}" data-message-id="${messageData.id}">
                    <div class="flex gap-4">
                        <div class="avatar">
                            <a href="{{ asset('assets/images/avatar.png') }}" class="client-avatar block">
                                <img decoding="async" src="{{ asset('assets/images/avatar.png') }}" alt="أيقونة العميل" class="fal-content-img">
                            </a>
                        </div>
                        <div class="body">
                            <div class="meta flex items-center gap-2">
                                <span class="who font-semibold">${messageData.ticket_name || messageData.user_name}</span>
                                <span class="time">${messageData.formatted_date} - ${messageData.human_readable_date}</span>
                                <span class="text-xs px-2 py-1 rounded-full ${messageData.sender_type == 'customer' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'}">
                                    ${messageData.sender_type == 'customer' ? 'عميل' : 'دعم'}
                                </span>
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

                    <div class="actions flex gap-2">
                        <div class="message-edit-btn px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700" data-message-id="${messageData.id}">
                            {{ __('main.edit') }}
                        </div>
                        <div class="message-delete-btn px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" data-message-id="${messageData.id}">
                            {{ __('main.delete') }}
                        </div>
                    </div>
                </div>
            `;

            // Insert the new message at the end of messages container
            messagesContainer.insertAdjacentHTML('beforeend', messageHtml);

            // Rebind message handlers for the new message
            rebindMessageHandlers();

            // Scroll to the new message smoothly
            setTimeout(() => {
                messagesContainer.lastElementChild?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                });
            }, 100);
        }
    </script>

    @include('dashboard.components.messages-action')
@endpush
