<div class="print-ticket">
    <!-- title -->
    <h1 class="text-3xl font-bold text-right mb-6">{{ __('main.ticket') }} #{{ $ticketData['uuid'] }}</h1>

    <!-- ticket info -->
    <div class="border rounded-xl p-4 mb-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <p class="mb-1"><b>{{ __('main.status') }}:</b> {{ __('main.' . $ticketData['status']) }}</p>
                <p class="mb-1"><b>{{ __('main.customer') }}:</b> {{ $ticketData['name'] }}</p>
                <p class="mb-1"><b>{{ __('main.subject') }}:</b> {{ $ticketData['subject'] }}</p>
            </div>
            <div class="space-y-2">
                <p class="mb-1"><b>{{ __('main.department') }}:</b> {{ $ticketData['department']['name'] ?? __('main.no_department') }}</p>
                <p class="mb-1"><b>{{ __('main.email_') }}:</b> {{ $ticketData['email'] }}</p>
                <p class="mb-1"><b>{{ __('main.date') }}:</b> {{ $ticketData['created_at'] }}</p>
            </div>
        </div>
    </div>

    <!-- messages -->
    <div class="flex flex-col gap-4">
        @foreach ($ticketData['messages'] as $message)
            <div class="border rounded-xl p-2 {{ $message['sender_type'] == 'customer' ? 'bg-blue-50' : 'bg-red-50' }}">
                <div class="text-sm text-gray-700">
                    {{ $message['sender_type'] == 'customer' ? $ticketData['name'] : $message['department']['name'] ?? __('main.support') }}
                    —
                    {{ $message['created_at'] }}
                </div>
                <div class="text-gray-800">
                    {!! $message['message'] !!}
                </div>
            </div>
        @endforeach
    </div>
</div>
