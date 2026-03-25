@extends('dashboard.layout.master')

@section('title', __('main.reviews'))
@section('page-title', '⭐ ' . __('main.reviews'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #ca8a04;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-star"></i>
                        {{ __('main.reviews') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.reviews') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.reviews') }}</p>

                    @if (auth()->user()->can('reviews-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.reviews.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_type', ['type' => __('main.review')]) }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-line',
                    'items' => [
                        ['id' => 'stat-total', 'value' => $reviews->total(), 'label' => __('main.reviews')],
                        ['id' => 'stat-pending', 'value' => $pendingCount, 'label' => __('main.pending')],
                        ['id' => 'stat-approved', 'value' => $approvedCount, 'label' => __('main.approved')],
                        ['id' => 'stat-rejected', 'value' => $rejectedCount, 'label' => __('main.rejected')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-star',
                'title' => __('main.reviews'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.reviews')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.reviews')]) }}">

                    <select id="statusFilter" class="entity-select">
                        <option value="">{{ __('main.all') }} - {{ __('main.status') }}</option>
                        <option value="pending">{{ __('main.pending') }}</option>
                        <option value="approved">{{ __('main.approved') }}</option>
                        <option value="rejected">{{ __('main.rejected') }}</option>
                    </select>
                </div>

                @if (auth()->user()->can('reviews-create'))
                    <div class="entity-toolbar-group">
                        <a href="{{ route('dashboard.reviews.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                            {{ __('main.create_type', ['type' => __('main.review')]) }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table">
                        <thead>
                            <tr>
                                <th>{{ __('main.name') }}</th>
                                <th>{{ __('main.country') }}</th>
                                <th>{{ __('main.rating') }}</th>
                                <th>{{ __('main.message') }}</th>
                                <th>{{ __('main.status') }}</th>
                                <th>{{ __('main.created_at') }}</th>
                                <th>{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr id="row-{{ $review->id }}" data-status="{{ $review->status }}">
                                    <td><span class="entity-primary-text">{{ limitedText($review->name, 25) }}</span></td>
                                    <td>
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            🌍 {{ $review->country }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $stars = '';
                                            for ($i = 0; $i < $review->rate; $i++) {
                                                $stars .= '⭐ ';
                                            }
                                        @endphp
                                        {!! $stars !!}
                                    </td>
                                    <td title="{{ $review->comment }}"><span class="entity-secondary-text">{{ limitedText($review->comment, 40) }}</span></td>
                                    <td>
                                        @include('dashboard.components.status-actions', [
                                            'record' => $review,
                                            'models' => 'reviews',
                                            'modelClass' => 'review',
                                            'availableOptions' => array_column(\App\Enum\ReviewEnums::cases(), 'value'),
                                        ])
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if ($review->status === 'pending') bg-blue-100 text-blue-800
                                            @elseif($review->status === 'approved') bg-green-100 text-green-800
                                            @elseif($review->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ __('main.' . $review->status) }}
                                        </span>
                                    </td>
                                    <td><span class="entity-secondary-text">{{ $review->created_at?->format('d/m/Y') }}</span></td>
                                    <td>
                                        <div class="entity-actions">
                                            @include('dashboard.components.permissions-actions', [
                                                'record' => $review,
                                                'models' => 'reviews',
                                                'modelClass' => 'review',
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

                @if ($reviews->hasPages())
                    <div class="entity-pagination">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchBox');
            const statusFilter = document.getElementById('statusFilter');
            const rows = Array.from(document.querySelectorAll('tbody tr[id^="row-"]'));

            function filterReviews() {
                const searchValue = (searchBox?.value || '').toLowerCase().trim();
                const statusValue = statusFilter?.value || '';

                rows.forEach(function(row) {
                    const text = row.textContent.toLowerCase();
                    const matchesSearch = !searchValue || text.includes(searchValue);
                    const matchesStatus = !statusValue || row.dataset.status === statusValue;

                    row.style.display = matchesSearch && matchesStatus ? '' : 'none';
                });
            }

            searchBox?.addEventListener('input', filterReviews);
            statusFilter?.addEventListener('change', filterReviews);
        });
    </script>
@endpush
