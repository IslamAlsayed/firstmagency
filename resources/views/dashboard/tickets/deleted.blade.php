@extends('dashboard.layout.master')

@section('title', __('main.deleted') . ' ' . __('main.tickets'))
@section('page-title', '🗑️ ' . __('main.deleted') . ' ' . __('main.tickets'))

@section('content')
    <div class="w-full">
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ count($tickets) }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_types', ['types' => __('main.tickets')]) }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-blue-600" id="stat-open">{{ $tickets->where('status', 'open')->count() }}</div>
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
                <h5 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-trash-restore mr-2"></i> {{ __('main.deleted') }} {{ __('main.tickets') }}
                </h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 radius-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.tickets')]) }}">

                    <select id="statusFilter" class="w-[180px] px-4 py-2 border border-gray-300 radius-lg focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">{{ __('main.all') }} - {{ __('main.status') }}</option>
                        <option value="open">{{ __('main.open') }}</option>
                        <option value="in_progress">{{ __('main.in_progress') }}</option>
                        <option value="processed">{{ __('main.processed') }}</option>
                        <option value="replied">{{ __('main.replied') }}</option>
                        <option value="closed">{{ __('main.closed') }}</option>
                    </select>

                    <a href="{{ route('dashboard.tickets.index') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.tickets') }}
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
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.deleted') }}</th>
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
                                <td class="p-4 text-sm text-gray-600">
                                    <span class="kt-badge text-white" style="background-color: {{ $ticket->department?->border_main_color ?? 'default' }};">
                                        {{ __('main.' . str_replace('-', '_', str_replace(' ', '_', $ticket->department?->name ?? 'no_department'))) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    <span class="kt-badge text-white {{ \App\Enum\TicketEnums::from($ticket->status)->badgeColor() }} rounded-full">
                                        {{ __('main.' . $ticket->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600">{{ $ticket->deleted_at?->diffForHumans() }}</td>
                                <td class="p-4 text-sm text-gray-600">
                                    <form action="{{ route('dashboard.tickets.restore', $ticket->id) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('main.are_you_sure') }}');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-green-600 text-white" title="{{ __('main.restore') }}">
                                            <i class="fas fa-trash-restore text-white"></i>
                                            {{ __('main.restore') }}
                                        </button>
                                    </form>
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
        });
    </script>
@endpush
