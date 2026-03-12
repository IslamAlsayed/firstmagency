@extends('dashboard.layout.master')

@section('title', __('main.tickets'))
@section('page-title', '🎫 ' . __('main.tickets'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800">{{ count($tickets) }}</div>
                <small class="text-primary font-semibold">{{ __('main.total_types', ['types' => __('main.tickets')]) }}</small>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-blue-600">{{ $tickets->where('status', 'open')->count() }}</div>
                <small class="text-primary font-semibold">{{ __('main.open') }}</small>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-yellow-600">{{ $tickets->where('status', 'in_progress')->count() }}</div>
                <small class="text-primary font-semibold">{{ __('main.in_progress') }}</small>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600">{{ $tickets->where('priority', 'urgent')->count() }}</div>
                <small class="text-primary font-semibold">{{ __('main.urgent') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-b border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-ticket-alt mr-2"></i> {{ __('main.tickets') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox"
                        class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.tickets')]) }}">
                    <a href="{{ route('dashboard.tickets.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_type', ['type' => __('main.ticket')]) }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <div class="p-4">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.number') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.name') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.subject') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.department') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="p-4 text-sm text-gray-600">{{ $ticket->uuid }}</td>
                                    <td class="p-4 text-sm text-gray-600">
                                        <p>{{ $ticket->name }}</p>
                                        <p>
                                            <a href="mailto:{{ $ticket->email }}" target="_blank"
                                                class="inline-block text-primary hover:underline text-xs font-medium">
                                                {!! limitedText($ticket->email ?? '--', 30) !!}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                            </a>
                                        </p>
                                        <p>
                                            <a href="tel:{{ $ticket->phone }}" target="_blank"
                                                class="inline-block text-primary hover:underline text-xs font-medium">
                                                {!! limitedText($ticket->phone ?? '--', 30) !!}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                            </a>
                                        </p>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ limitedText($ticket->subject ?? '', 30) }}</td>
                                    <td class="p-4 text-sm text-gray-600 font-semibold">{{ $ticket->department ?? '-' }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $ticket->created_at?->diffForHumans() }}</td>
                                    <td class="p-4 text-sm">
                                        <span class="kt-badge text-white {{ \App\Enum\TicketEnums::from($ticket->status)->badgeColor() }} rounded-full">
                                            {{ __('main.' . $ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.status-actions', [
                                            'record' => $ticket,
                                            'models' => 'tickets',
                                            'modelClass' => 'ticket',
                                            'availableOptions' => array_column(\App\Enum\TicketEnums::cases(), 'value'),
                                        ])
                                        <a href="{{ route('dashboard.tickets.sendCopyToCustomer', ['ticketId' => $ticket->id]) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-blue-500 text-white" title="{{ __('main.send_copy_to_customer') }}">
                                            <i class="fas fa-envelope text-white"></i>
                                        </a>
                                        <a href="{{ route('dashboard.tickets.support-reply', ['ticketId' => $ticket->id]) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-blue-300 text-white" title="{{ __('main.support_reply') }}">
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($tickets->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
