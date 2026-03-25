@extends('dashboard.layout.master')

@section('title', __('main.faqs'))
@section('page-title', '❓ ' . __('main.faqs'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush


@section('content')
    <div class="entity-index-page" style="--page-accent: #f59e0b;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-question-circle"></i>
                        {{ __('main.faqs') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.faqs') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_faqs') }}</p>

                    @if (auth()->user()->can('faqs-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.faqs.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_type', ['type' => __('main.faq')]) }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-circle-question',
                    'items' => [
                        ['id' => 'stat-total', 'value' => count($faqs), 'label' => __('main.total_faqs')],
                        ['id' => 'stat-active', 'value' => $faqs->where('is_active', 1)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-categories', 'value' => $faqs->unique('category')->count(), 'label' => __('main.categories')],
                        ['id' => 'stat-inactive', 'value' => $faqs->where('is_active', 0)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-question-circle',
                'title' => __('main.faqs'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.faqs')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.faqs')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    @if (auth()->user()->can('faqs-create'))
                        <a href="{{ route('dashboard.faqs.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                            {{ __('main.create_type', ['type' => __('main.faq')]) }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.question') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.category') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                                <tr id="row-{{ $faq->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition searchable-row"
                                    data-search="{{ strtolower($faq->question . ' ' . $faq->question_ar . ' ' . $faq->category) }}" data-active="{{ (int) $faq->is_active }}">
                                    <td class="p-4">
                                        <strong class="text-sm text-gray-800 block">
                                            {{ limitedText($faq->question, 50) }}
                                        </strong>
                                        <small class="text-gray-600">{{ limitedText($faq->question_ar, 50) }}</small>
                                    </td>
                                    <td class="p-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            {{ $faq->CATEGORIES[$faq->category] ?? $faq->category }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $faq->order ?? 0 }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $faq->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $faq->is_active,
                                            'modelClass' => 'faq',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($faq->creator)
                                            <a href="{{ route('dashboard.users.show', $faq->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $faq->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $faq->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $faq,
                                            'models' => 'faqs',
                                            'modelClass' => 'faq',
                                        ])
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

                    @if ($faqs->hasPages())
                        <div class="entity-pagination">
                            {{ $faqs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
