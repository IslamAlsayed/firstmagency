@extends('dashboard.layout.master')

@section('title', __('main.tickets'))
@section('page-title', '🎫 ' . __('main.tickets'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800 tickets-count" id="stat-total">{{ count($tickets) }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_types', ['types' => __('main.tickets')]) }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-blue-600 tickets-count" id="stat-open">{{ $tickets->where('status', 'open')->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.open') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-yellow-600" id="stat-in_progress">{{ $tickets->where('status', 'in_progress')->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.in_progress') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-yellow-600" id="stat-processed">{{ $tickets->where('priority', 'processed')->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.processed') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-replied">{{ $tickets->where('priority', 'replied')->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.replied') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-600" id="stat-closed">{{ $tickets->where('priority', 'closed')->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.closed') }}</small>
            </div>
        </div>

        <div class="bg-white shadow-lg radius-lg">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-ticket-alt mr-2"></i> {{ __('main.tickets') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.tickets')]) }}">
                    <a href="{{ route('dashboard.tickets.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_type', ['type' => __('main.ticket')]) }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.number') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.name') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.subject') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.department') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition" id="row-{{ $ticket->id }}" data-status="{{ $ticket->status }}" data-priority="{{ $ticket->priority }}">
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
                                        'availableOptions' => \App\Models\Department::pluck('name', 'id')->toArray(),
                                    ])
                                    <span class="kt-badge text-white" style="background-color: {{ $ticket->department?->border_main_color ?? 'default' }};">
                                        {{ __('main.' . str_replace('-', '_', str_replace(' ', '_', $ticket->department?->name ?? 'no_department'))) }}
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
                                            'modelClass' => 'ticket',
                                        ])
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                    {{ __('messages.no_records_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($tickets->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Ably connection for real-time updates
            const apiKey = '{{ config('app.ably_key') }}';
            if (typeof Ably === 'undefined' || !apiKey) {
                console.warn('Ably is not available or ABLY_KEY is missing.');
                return;
            }

            const realtime = new Ably.Realtime(apiKey);
            const channel = realtime.channels.get('dashboard-tickets');
            channel.subscribe('new-ticket-created', function(message) {
                const newTicket = message.data;
                addNewTicketToTable(newTicket);
            });

            // Cleanup on page unload
            window.addEventListener('beforeunload', function() {
                realtime?.close();
            });
        });

        function addNewTicketToTable(ticket) {
            const tbody = document.querySelector('table tbody');

            if (!tbody) return;

            // Remove empty message if exists
            const emptyRow = tbody.querySelector('tr:has(td[colspan="8"])');
            if (emptyRow) {
                emptyRow.remove();
            }

            // Fetch the full row HTML from the authenticated dashboard endpoint
            const rowHtmlUrlTemplate = @json(route('api.tickets.row-html', ['id' => '__ID__']));
            fetch(rowHtmlUrlTemplate.replace('__ID__', ticket.id))
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.error || 'Failed to fetch row HTML');
                    }

                    // Create new row from server HTML
                    const newRow = document.createElement('tr');
                    newRow.id = 'row-' + ticket.id;
                    newRow.className = 'border-b border-gray-200 hover:bg-gray-50 transition new-ticket-row';
                    newRow.style.animation = 'slideInDown 0.3s ease-out';
                    newRow.innerHTML = data.html;

                    // Insert at the beginning of tbody
                    tbody.insertBefore(newRow, tbody.firstChild);

                    // Update statistics
                    updateStatisticsOnAdd(ticket.status, ticket.priority);

                    // Highlight the new row
                    highlightNewRow(newRow);
                })
                .catch(error => console.error('Error fetching ticket row:', error));
        }

        function updateStatisticsOnAdd(status, priority) {
            // Increase total
            const $total = document.getElementById('stat-total');
            if ($total) {
                let total = parseInt($total.textContent) || 0;
                $total.textContent = total + 1;
            }

            // Increase status-specific count
            const $statusStat = document.getElementById('stat-' + status);
            if ($statusStat) {
                let count = parseInt($statusStat.textContent) || 0;
                $statusStat.textContent = count + 1;
            }

            // Increase urgent priority count
            if (priority === 'urgent') {
                const $urgentStat = document.getElementById('stat-urgent');
                if ($urgentStat) {
                    let count = parseInt($urgentStat.textContent) || 0;
                    $urgentStat.textContent = count + 1;
                }
            }
        }

        function highlightNewRow(row) {
            row.style.backgroundColor = '#d1fae5';
            setTimeout(() => {
                row.style.transition = 'background-color 0.5s ease-out';
                row.style.backgroundColor = '';
            }, 2000);
        }

        // Add animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
@endpush
