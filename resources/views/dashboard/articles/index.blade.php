@extends('dashboard.layout.master')

@section('title', __('main.articles'))
@section('page-title', '📝 ' . __('main.articles'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #0f766e;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-newspaper"></i>
                        {{ __('main.articles') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.articles') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_types', ['types' => __('main.articles')]) }}</p>

                    @if (auth()->user()->can('articles-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.articles.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_article') }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-pen-nib',
                    'items' => array_values(
                        array_filter([
                            ['id' => 'stat-total', 'value' => $allItems, 'label' => __('main.total_types', ['types' => __('main.articles')])],
                            ['id' => 'stat-published', 'value' => $published, 'label' => __('main.published')],
                            in_array(getActiveUser()->role, ['admin', 'superadmin']) ? ['id' => 'stat-draft', 'value' => $draft, 'label' => __('main.draft')] : null,
                            in_array(getActiveUser()->role, ['admin', 'superadmin']) ? ['id' => 'stat-archived', 'value' => $archived, 'label' => __('main.archived')] : null,
                        ])),
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-newspaper',
                'title' => __('main.articles'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.articles')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.articles')]) }}">

                    <select id="statusFilter" class="entity-select">
                        <option value="">{{ __('main.all') }} - {{ __('main.status') }}</option>
                        <option value="published">{{ __('main.published') }}</option>
                        @if (in_array(getActiveUser()->role, ['admin', 'superadmin']))
                            <option value="draft">{{ __('main.draft') }}</option>
                            <option value="archived">{{ __('main.archived') }}</option>
                        @endif
                    </select>

                    <select id="activeFilter" class="entity-select">
                        <option value="">{{ __('main.all') }} - {{ __('main.active') }}</option>
                        <option value="1">{{ __('main.active') }}</option>
                        <option value="0">{{ __('main.inactive') }}</option>
                    </select>
                </div>

                @if (auth()->user()->can('articles-create'))
                    <div class="entity-toolbar-group">
                        <a href="{{ route('dashboard.articles.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                            {{ __('main.create_article') }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table">
                        <thead>
                            <tr>
                                <th>{{ __('main.image') }}</th>
                                <th>{{ __('main.title') }}</th>
                                <th>{{ __('main.active') }}</th>
                                <th>{{ __('main.status') }}</th>
                                <th>{{ __('main.views') }}</th>
                                <th>{{ __('main.created_by') }}</th>
                                <th>{{ __('main.created_at') }}</th>
                                <th>{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                                <tr id="row-{{ $article->id }}" data-status="{{ $article->status }}" data-active="{{ (int) $article->is_active }}">
                                    <td title="{{ $article->translations[app()->getLocale()]['title'] ?? '' }}">
                                        <div class="relative w-fit">
                                            @if ($article->image && checkExistFile($article->image))
                                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->translations[app()->getLocale()]['title'] ?? '' }}"
                                                    class="rounded-full size-10 shrink-0 object-cover">
                                            @else
                                                <span class="entity-panel-title-icon"><i class="fas fa-pencil"></i></span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="entity-primary-text block">
                                            {{ limitedText($article->translations[app()->getLocale()]['title'] ?? '', 50) }}
                                        </strong>
                                        <span class="entity-secondary-text">{{ __('main.article') }} #{{ $article->id }}</span>
                                    </td>
                                    <td>
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $article->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $article->is_active,
                                            'modelClass' => 'article',
                                        ])
                                    </td>
                                    <td>
                                        @include('dashboard.components.status-actions', [
                                            'record' => $article,
                                            'models' => 'articles',
                                            'modelClass' => 'article',
                                            'availableOptions' => array_column(\App\Enum\ArticleEnums::cases(), 'value'),
                                        ])
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if ($article->status === 'published') bg-green-100 text-green-800
                                            @elseif($article->status === 'draft') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ __('main.' . $article->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="entity-primary-text"><i class="fas fa-eye text-sky-500"></i> {{ $article->view_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        @if ($article->creator)
                                            <a href="{{ route('dashboard.users.show', $article->creator->id) }}" class="entity-contact-link">
                                                {{ $article->creator->name }}
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </a>
                                        @else
                                            <span class="entity-secondary-text">N/A</span>
                                        @endif
                                    </td>
                                    <td><span class="entity-secondary-text">{{ $article->created_at?->format('d/m/Y') }}</span></td>
                                    <td>
                                        <div class="entity-actions">
                                            @include('dashboard.components.permissions-actions', [
                                                'record' => $article,
                                                'models' => 'articles',
                                                'modelClass' => 'article',
                                            ])
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="entity-empty">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($articles->hasPages())
                    <div class="entity-pagination">
                        {{ $articles->links() }}
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
            const activeFilter = document.getElementById('activeFilter');
            const rows = Array.from(document.querySelectorAll('tbody tr[id^="row-"]'));

            function filterArticles() {
                const searchValue = (searchBox?.value || '').toLowerCase().trim();
                const statusValue = statusFilter?.value || '';
                const activeValue = activeFilter?.value || '';

                rows.forEach(function(row) {
                    const text = row.textContent.toLowerCase();
                    const matchesSearch = !searchValue || text.includes(searchValue);
                    const matchesStatus = !statusValue || row.dataset.status === statusValue;
                    const matchesActive = !activeValue || row.dataset.active === activeValue;

                    row.style.display = matchesSearch && matchesStatus && matchesActive ? '' : 'none';
                });
            }

            searchBox?.addEventListener('input', filterArticles);
            statusFilter?.addEventListener('change', filterArticles);
            activeFilter?.addEventListener('change', filterArticles);
        });
    </script>
@endpush
