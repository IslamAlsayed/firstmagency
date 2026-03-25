@extends('dashboard.layout.master')

@section('title', __('main.tickets'))
@section('page-title', '🎫 ' . __('main.tickets'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #ea580c;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-headset"></i>
                        {{ __('main.ticket_network') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.tickets') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.ticket_network') }}</p>

                    <div class="entity-hero-actions">
                        @if (auth()->user()->can('tickets-create'))
                            <a href="{{ route('dashboard.tickets.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_type', ['type' => __('main.ticket')]) }}
                            </a>
                        @endif
                        @if (auth()->user()->can('tickets-restore'))
                            <a href="{{ route('dashboard.tickets.deleted') }}" class="entity-hero-action">
                                <i class="fas fa-trash-restore"></i>
                                {{ __('main.deleted_tickets') }}
                            </a>
                        @endif
                    </div>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-ticket-alt',
                    'items' => [
                        ['id' => 'stat-total', 'class' => 'tickets-count', 'value' => count($tickets), 'label' => __('main.total_tickets')],
                        ['id' => 'stat-open', 'value' => $tickets->where('status', 'open')->count(), 'label' => __('main.open')],
                        ['id' => 'stat-in_progress', 'value' => $tickets->where('status', 'in_progress')->count(), 'label' => __('main.in_progress')],
                        ['id' => 'stat-closed', 'value' => $tickets->where('priority', 'closed')->count(), 'label' => __('main.closed')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-ticket-alt',
                'title' => __('main.tickets'),
                'description' => __('main.ticket_network'),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.tickets')]) }}">

                    <select id="statusFilter" class="entity-select">
                        <option value="">{{ __('main.all') }} - {{ __('main.status') }}</option>
                        <option value="open">{{ __('main.open') }}</option>
                        <option value="in_progress">{{ __('main.in_progress') }}</option>
                        <option value="processed">{{ __('main.processed') }}</option>
                        <option value="replied">{{ __('main.replied') }}</option>
                        <option value="closed">{{ __('main.closed') }}</option>
                    </select>
                </div>

                <div class="entity-toolbar-group">
                    @if (auth()->user()->can('tickets-create'))
                        <a href="{{ route('dashboard.tickets.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                            {{ __('main.create_type', ['type' => __('main.ticket')]) }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table">
                        <thead>
                            <tr>
                                <th>{{ __('main.number') }}</th>
                                <th>{{ __('main.name') }}</th>
                                <th>{{ __('main.subject') }}</th>
                                <th>{{ __('main.department') }}</th>
                                <th>{{ __('main.status') }}</th>
                                <th>{{ __('main.created_at') }}</th>
                                <th>{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr id="row-{{ $ticket->id }}" data-status="{{ $ticket->status }}" data-priority="{{ $ticket->priority }}">
                                    <td><span class="entity-primary-text">{{ $ticket->uuid }}</span></td>
                                    <td>
                                        <p class="entity-primary-text">{{ $ticket->name }}</p>
                                        <p class="entity-secondary-text">
                                            <a href="mailto:{{ $ticket->email }}" target="_blank" class="entity-contact-link">
                                                {!! limitedText($ticket->email ?? '--', 30) !!}
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </a>
                                        </p>
                                        <p class="entity-secondary-text">
                                            <a href="tel:{{ $ticket->phone }}" target="_blank" class="entity-contact-link">
                                                {!! limitedText($ticket->phone ?? '--', 30) !!}
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </a>
                                        </p>
                                    </td>
                                    <td><span class="entity-primary-text">{{ limitedText($ticket->subject ?? '', 40) }}</span></td>
                                    <td class="font-semibold">
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
                                    <td>
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
                                    <td><span class="entity-secondary-text">{{ $ticket->created_at?->diffForHumans() }}</span></td>
                                    <td>
                                        <div class="entity-actions">
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
                                    <td colspan="7" class="entity-empty">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($tickets->hasPages())
                    <div class="entity-pagination">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </section>
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
            const emptyRow = tbody.querySelector('tr:has(td[colspan])');
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
            function incrementText(selector) {
                document.querySelectorAll(selector).forEach(function(element) {
                    const current = parseInt(element.textContent) || 0;
                    element.textContent = current + 1;
                });
            }

            incrementText('#stat-total');

            // Increase status-specific count
            const statusTargets = {
                open: '#stat-open',
                in_progress: '#stat-in_progress',
                replied: '#stat-replied',
                closed: '#stat-closed',
                processed: '#stat-processed',
            };

            if (statusTargets[status]) {
                incrementText(statusTargets[status]);
            }

            if (priority === 'replied') {
                incrementText('#stat-replied');
            }

            if (priority === 'processed') {
                incrementText('#stat-processed');
            }

            if (priority === 'closed') {
                incrementText('#stat-closed');
            }
        }

        function highlightNewRow(row) {
            row.style.backgroundColor = '#d1fae5';
            setTimeout(() => {
                row.style.transition = 'background-color 0.5s ease-out';
                row.style.backgroundColor = '';
            }, 2000);
        }

        // Search + status filter (status uses ticket status or priority when needed)
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchBox');
            const statusFilter = document.getElementById('statusFilter');

            if (!searchBox || !statusFilter) return;

            function applyTicketFilters() {
                const searchValue = (searchBox.value || '').trim().toLowerCase();
                const selectedStatus = statusFilter.value;
                const rows = document.querySelectorAll('tbody tr[id^="row-"]');

                rows.forEach(row => {
                    const rowText = (row.textContent || '').toLowerCase();
                    const rowStatus = row.getAttribute('data-status') || '';
                    const rowPriority = row.getAttribute('data-priority') || '';

                    const matchesSearch = !searchValue || rowText.includes(searchValue);
                    const matchesStatus = !selectedStatus || rowStatus === selectedStatus || rowPriority === selectedStatus;

                    row.style.display = matchesSearch && matchesStatus ? '' : 'none';
                });
            }

            searchBox.addEventListener('keyup', applyTicketFilters);
            statusFilter.addEventListener('change', applyTicketFilters);

            // Keep filter effect after dynamic updates.
            const originalAddRow = window.addNewTicketToTable;
            if (typeof originalAddRow === 'function') {
                window.addNewTicketToTable = function(ticket) {
                    originalAddRow(ticket);
                    setTimeout(applyTicketFilters, 200);
                };
            }
        });

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
