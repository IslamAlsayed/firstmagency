@extends('dashboard.layout.master')

@section('title', __('main.deleted') . ' ' . __('main.tickets'))
@section('page-title', '🗑️ ' . __('main.deleted') . ' ' . __('main.tickets'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #059669;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-trash-restore"></i>
                        {{ __('main.deleted_tickets') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.deleted_tickets') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.deleted') }} {{ __('main.tickets') }} - {{ __('main.restore') }}</p>

                    <div class="entity-hero-actions">
                        <a href="{{ route('dashboard.tickets.index') }}" class="entity-hero-action">
                            <i class="fas fa-ticket-alt"></i>
                            {{ __('main.tickets') }}
                        </a>
                    </div>
                </div>

                <div class="entity-hero-side">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-bold text-white/85">{{ __('main.last_update') }}</p>
                            <p class="text-xs text-white/70">{{ now()->format('d M Y - H:i A') }}</p>
                        </div>
                        <div class="text-4xl text-white/20">
                            <i class="fas fa-box-archive"></i>
                        </div>
                    </div>

                    <div class="entity-hero-side-grid">
                        <div class="entity-hero-side-item">
                            <strong id="stat-total">{{ count($tickets) }}</strong>
                            <span class="text-sm text-white/80">{{ __('main.total_tickets') }}</span>
                        </div>
                        <div class="entity-hero-side-item">
                            <strong id="stat-open">{{ $tickets->where('status', 'open')->count() }}</strong>
                            <span class="text-sm text-white/80">{{ __('main.open') }}</span>
                        </div>
                        <div class="entity-hero-side-item">
                            <strong id="stat-in_progress">{{ $tickets->where('status', 'in_progress')->count() }}</strong>
                            <span class="text-sm text-white/80">{{ __('main.in_progress') }}</span>
                        </div>
                        <div class="entity-hero-side-item">
                            <strong id="stat-closed">{{ $tickets->where('priority', 'closed')->count() }}</strong>
                            <span class="text-sm text-white/80">{{ __('main.closed') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="entity-stat-grid">
            <article class="entity-stat-card">
                <span><i class="fas fa-box-archive"></i> {{ __('main.total_tickets') }}</span>
                <strong>{{ count($tickets) }}</strong>
            </article>
            <article class="entity-stat-card">
                <span><i class="fas fa-circle text-blue-500"></i> {{ __('main.open') }}</span>
                <strong>{{ $tickets->where('status', 'open')->count() }}</strong>
            </article>
            <article class="entity-stat-card">
                <span><i class="fas fa-clock text-amber-500"></i> {{ __('main.in_progress') }}</span>
                <strong>{{ $tickets->where('status', 'in_progress')->count() }}</strong>
            </article>
            <article class="entity-stat-card">
                <span><i class="fas fa-reply text-emerald-500"></i> {{ __('main.replied') }}</span>
                <strong>{{ $tickets->where('priority', 'replied')->count() }}</strong>
            </article>
            <article class="entity-stat-card">
                <span><i class="fas fa-lock text-slate-500"></i> {{ __('main.closed') }}</span>
                <strong>{{ $tickets->where('priority', 'closed')->count() }}</strong>
            </article>
        </section>

        <section class="entity-panel">
            <div class="entity-panel-header">
                <div class="entity-panel-title">
                    <span class="entity-panel-title-icon"><i class="fas fa-trash-restore"></i></span>
                    <div>
                        <h2>{{ __('main.deleted_tickets') }}</h2>
                        <p>{{ __('main.restore') }}</p>
                    </div>
                </div>
            </div>

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.tickets')]) }}">

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
                    <a href="{{ route('dashboard.tickets.index') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.tickets') }}
                    </a>
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
                                <th>{{ __('main.deleted') }}</th>
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
                                <td>
                                    <span class="kt-badge text-white" style="background-color: {{ $ticket->department?->border_main_color ?? 'default' }};">
                                        {{ __('main.' . str_replace('-', '_', str_replace(' ', '_', $ticket->department?->name ?? 'no_department'))) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="kt-badge text-white {{ \App\Enum\TicketEnums::from($ticket->status)->badgeColor() }} rounded-full">
                                        {{ __('main.' . $ticket->status) }}
                                    </span>
                                </td>
                                <td><span class="entity-secondary-text">{{ $ticket->deleted_at?->diffForHumans() }}</span></td>
                                <td>
                                    <div class="entity-actions">
                                        <form action="{{ route('dashboard.tickets.restore', $ticket->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-green-600 text-white" title="{{ __('main.restore') }}">
                                                <i class="fas fa-trash-restore text-white"></i>
                                                {{ __('main.restore') }}
                                            </button>
                                        </form>
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
