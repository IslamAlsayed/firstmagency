<tr class="border-b border-gray-200 hover:bg-gray-50 transition" id="row-{{ $ticket->id }}" data-status="{{ $ticket->status }}" data-priority="{{ $ticket->priority }}">
    <td class="p-4 text-sm text-gray-600">{{ $ticket->uuid }}</td>
    <td class="p-4 text-sm text-gray-600">
        <p>{{ $ticket->name }}</p>
        <p>
            <a href="mailto:{{ $ticket->email }}" target="_blank" class="inline-block text-primary hover:underline text-xs font-medium">
                {!! limitedText($ticket->email ?? '--', 30) !!}
                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
            </a>
        </p>
        <p>
            <a href="tel:{{ $ticket->phone }}" target="_blank" class="inline-block text-primary hover:underline text-xs font-medium">
                {!! limitedText($ticket->phone ?? '--', 30) !!}
                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
            </a>
        </p>
    </td>
    <td class="p-4 text-sm text-gray-600">{{ limitedText($ticket->subject ?? '', 30) }}</td>
    <td class="p-4 text-sm text-gray-600 font-semibold">{{ $ticket->department?->name ?? '-' }}</td>
    <td class="p-4 text-sm text-gray-600">{{ $ticket->created_at?->diffForHumans() }}</td>
    <td class="p-4 text-sm">
        <span class="kt-badge text-white {{ \App\Enum\TicketEnums::from($ticket->status)->badgeColor() }} rounded-full">
            {{ __('main.' . $ticket->status) }}
        </span>
    </td>
    <td class="p-4 text-sm">
        <div class="flex items-center gap-2 flex-wrap">
            @include('dashboard.components.status-actions', [
                'record' => $ticket,
                'models' => 'tickets',
                'modelClass' => 'ticket',
                'availableOptions' => array_column(\App\Enum\TicketEnums::cases(), 'value'),
            ])
            <a href="{{ route('dashboard.tickets.sendCopyToCustomer', ['ticketId' => $ticket->id]) }}" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-blue-500 text-white"
                title="{{ __('main.send_copy_to_customer') }}">
                <i class="fas fa-envelope text-white"></i>
            </a>
            <a href="{{ route('dashboard.tickets.support-reply', ['ticketId' => $ticket->id]) }}" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-blue-300 text-white"
                title="{{ __('main.support_reply') }}">
                @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                    {!! $text ?? __('main.chat') !!}
                @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                    <i class="fas fa-comments text-white"></i>
                @else
                    <i class="fas fa-comments text-white"></i>
                    {!! $text ?? __('main.chat') !!}
                @endif
            </a>

            @include('dashboard.components.permissions-actions', [
                'record' => $ticket,
                'models' => 'tickets',
            ])
        </div>
    </td>
</tr>
