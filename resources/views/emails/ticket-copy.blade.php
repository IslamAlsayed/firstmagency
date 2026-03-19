<!DOCTYPE html>
<html class="h-full" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_received') }}</title>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">
    <style>
        :root {
            --font-family: "{{ $settings->font_name ?? 'Tajawal' }}", system-ui, -apple-system, Segoe UI, Aria !important;
        }

        * {
            font-family: var(--font-family) !important;
        }
    </style>

    <!-- Tailwind CSS -->
    <link href="{{ asset('assets/plugins/tailwind/tailwind.css') }}" rel="stylesheet">
    {{-- custom css --}}
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

    <style>
        .client-attachment {
            min-height: 30px;
            font-size: 12px;
            padding: 5px 10px;
            width: fit-content;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.1s ease;
            background-color: var(--light-color);
            border: 1px solid var(--color-gray-300);
            box-shadow: 0 8px 24px rgba(2, 6, 23, .06);

            &:hover {
                background-color: var(--color-blue-50);
                border: 1px solid var(--color-blue-200);
            }

            img {
                width: 16px;
                height: 16px;
            }
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
    </style>
</head>

<body>
    <div class="print-ticket">
        <!-- title -->
        <h1 class="text-3xl font-bold text-right mb-6">{{ __('main.ticket_copy') }} #{{ $ticket->uuid }}</h1>
        <p class="mb-2">{{ __('main.ticket_copy_message') }}</p>

        <!-- ticket info -->
        <div class="border rounded-xl p-4 mb-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <p class="mb-1"><b>{{ __('main.status') }}:</b> {{ $ticket->status }}</p>
                    <p class="mb-1"><b>{{ __('main.customer') }}:</b> {{ $ticket->name }}</p>
                    <p class="mb-1"><b>{{ __('main.subject') }}:</b> {{ $ticket->subject }}</p>
                </div>
                <div class="space-y-2">
                    <p class="mb-1"><b>{{ __('main.department') }}:</b> {{ $ticket->department?->name }}</p>
                    <p class="mb-1"><b>{{ __('main.email_') }}:</b> {{ $ticket->email }}</p>
                    <p class="mb-1"><b>{{ __('main.date') }}:</b> {{ $ticket->created_at }}</p>
                </div>
            </div>
        </div>

        <div class="flex justify-center mb-4">
            <button class="btn-link light-main-color font-semibold">
                <a href="{{ route('tickets.show', $ticket->uuid) }}">{{ __('main.contact_ticket_inquiry') }}</a>
            </button>
        </div>

        <h2 class="mb-2">{{ __('main.full_conversation') }}</h2>

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
                        <div class="files flex items-center gap-2 mt-3">
                            @if ($message->attachments && is_array($message->attachments) && count($message->attachments) > 0)
                                @foreach ($message->attachments as $attachment)
                                    <a href="{{ asset('storage/' . $attachment) }}" class="client-attachment flex items-center gap-2" target="_blank" download>
                                        <img draggable="false" role="img" alt="📎" src="https://s.w.org/images/core/emoji/17.0.2/svg/1f4ce.svg">
                                        {{ __('main.attachment') }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
