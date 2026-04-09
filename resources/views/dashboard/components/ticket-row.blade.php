<tr class="border-b border-gray-200 hover:bg-gray-50 transition" id="row-{{ $ticket->id }}" data-status="{{ $ticket->status }}" data-priority="{{ $ticket->priority }}">
    <td class="p-4 text-sm text-gray-600">{{ $ticket->id }}</td>
    <td class="p-4 text-sm text-gray-600">{{ $ticket->uuid }}</td>
    <td class="p-4 text-sm text-gray-600">
        <p>{{ $ticket->name }}</p>
        <p>
            <a href="mailto:{{ $ticket->email }}" target="_blank" class="inline-block text-blue-600 hover:underline text-xs font-medium">
                {!! limitedText($ticket->email ?? '--', 30) !!}
                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
            </a>
        </p>
        <p>
            <a href="tel:{{ $ticket->phone }}" target="_blank" class="inline-block text-blue-600 hover:underline text-xs font-medium">
                {!! limitedText($ticket->phone ?? '--', 30) !!}
                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
            </a>
        </p>
    </td>
    <td class="p-4 text-sm text-gray-600">{{ limitedText($ticket->subject ?? '', 30) }}</td>
    <td class="p-4 text-sm text-gray-600 font-semibold">
        @include('dashboard.components.department-actions', [
            'record' => $ticket,
            'models' => 'tickets',
            'modelClass' => 'ticket',
            'availableOptions' => \App\Models\Department::get(['id', 'name', 'name_ar', 'user_id'])->toArray(),
        ])
        <span class="kt-badge text-white" style="background-color: {{ $ticket->department?->border_main_color ?? 'default' }};">
            {{ app()->getLocale() == 'ar' ? $ticket->department?->name_ar : $ticket->department?->name ?? 'no_department' }}
        </span>
    </td>
    <td class="p-4 text-sm text-gray-600">
        @include('dashboard.components.status-actions', [
            'record' => $ticket,
            'models' => 'tickets',
            'modelClass' => 'ticket',
            'availableOptions' => array_column(\App\Enum\TicketEnums::cases(), 'value'),
        ])
        <span class="kt-badge text-white {{ \App\Enum\TicketEnums::from($ticket->status)->badgeColor() }} rounded-full">
            {{ __('main.' . $ticket->status) }}
        </span>
    </td>
    <td class="p-4 text-sm text-gray-600">{{ $ticket->created_at?->diffForHumans() }}</td>
    <td class="p-4 text-sm text-gray-600">
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('dashboard.tickets.sendCopyToCustomer', ['ticketId' => $ticket->id]) }}" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-blue-500 text-white"
                title="{{ __('main.send_copy_to_customer') }}" toggle-button>
                <i class="fas fa-envelope text-white"></i>
            </a>
            <a href="{{ route('dashboard.tickets.support-reply', ['ticketId' => $ticket->id]) }}" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-blue-300 text-white"
                title="{{ __('main.support_reply') }}" toggle-button>
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
                'modelClass' => 'ticket',
            ])
        </div>
    </td>
</tr>
