<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_received') }}</title>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}" rel="stylesheet">
    <style>
        body {
            background: #ebebeb;
            width: 100%;
            min-height: 100vh;
            padding: 20px;
            margin: 0;
            font-family: '{{ $settings->font_name ?? 'Tajawal' }}', system-ui, -apple-system, Segoe UI, Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">
    <div style="max-width: 700px; margin: auto; padding: 30px; border-radius: 10px; background: #fff; box-shadow: 0 8px 24px rgba(2,6,23,0.06); position: relative; width: 100%;">
        <!-- title -->
        <h1 style="font-size: 28px; font-weight: bold; text-align: right; margin-bottom: 24px; margin-top: 0;">{{ __('main.ticket_copy') }} #{{ $ticket->uuid }}</h1>
        <p style="margin-bottom: 12px; color: #333; font-size: 15px;">{{ __('main.ticket_copy_message') }}</p>

        <!-- ticket info -->
        <div style="border: 1px solid #eae8e8; border-radius: 12px; padding: 16px; margin-bottom: 18px;">
            <div style="display: flex; flex-wrap: wrap; gap: 24px;">
                <div style="flex: 1 1 200px; min-width: 180px;">
                    <p style="margin-bottom: 6px; color: #222; font-size: 14px;"><b>{{ __('main.status') }}:</b> {{ $ticket->status }}</p>
                    <p style="margin-bottom: 6px; color: #222; font-size: 14px;"><b>{{ __('main.customer') }}:</b> {{ $ticket->name }}</p>
                    <p style="margin-bottom: 6px; color: #222; font-size: 14px;"><b>{{ __('main.subject') }}:</b> {{ $ticket->subject }}</p>
                </div>
                <div style="flex: 1 1 200px; min-width: 180px;">
                    <p style="margin-bottom: 6px; color: #222; font-size: 14px;"><b>{{ __('main.department') }}:</b> {{ $ticket->department?->name }}</p>
                    <p style="margin-bottom: 6px; color: #222; font-size: 14px;"><b>{{ __('main.email_') }}:</b> {{ $ticket->email }}</p>
                    <p style="margin-bottom: 6px; color: #222; font-size: 14px;"><b>{{ __('main.date') }}:</b> {{ $ticket->created_at }}</p>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 18px;">
            <a href="{{ route('tickets.show', $ticket->uuid) }}"
                style="display: inline-block; background: #f97316; color: #fff; font-weight: 600; border-radius: 24px; padding: 10px 28px; text-decoration: none; font-size: 15px;">{{ __('main.contact_ticket_inquiry') }}</a>
        </div>

        <h2 style="margin-bottom: 12px; color: #222; font-size: 18px; font-weight: bold;">{{ __('main.full_conversation') }}</h2>

        <!-- messages -->
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach ($ticket->messages as $message)
                <div style="border: 1px solid #eae8e8; border-radius: 12px; padding: 10px 14px; background: {{ $message->sender_type == 'customer' ? '#eff6ff' : '#fef2f2' }};">
                    <div style="font-size: 13px; color: #555; margin-bottom: 6px;">
                        {{ $message->sender_type == 'customer' ? $message->ticket->name : $message->user->name }} — {{ $message->created_at }}
                    </div>
                    <div style="color: #222; font-size: 15px;">
                        {!! $message->message !!}
                        <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            @if ($message->attachments && is_array($message->attachments) && count($message->attachments) > 0)
                                @foreach ($message->attachments as $attachment)
                                    <a href="{{ asset('storage/' . $attachment) }}" target="_blank"
                                        style="min-height: 30px; font-size: 12px; padding: 5px 10px; border-radius: 50px; background: #fff; border: 1px solid #e5e7eb; box-shadow: 0 8px 24px rgba(2,6,23,0.06); color: #f97316; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; margin-bottom: 4px;">
                                        <img draggable="false" role="img" alt="📎" src="https://s.w.org/images/core/emoji/17.0.2/svg/1f4ce.svg" style="width: 16px; height: 16px;">
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
