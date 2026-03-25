@extends('dashboard.layout.master')

@section('title', __('main.programming_categories'))
@section('page-title', '💻 ' . __('main.programming_categories'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush


@section('content')
    <div class="entity-index-page" style="--page-accent: #0f766e;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-code-branch"></i>
                        {{ __('main.programming_categories') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.programming_categories') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_types', ['types' => __('main.programming_categories')]) }}</p>

                    @if (auth()->user()->can('programming-categories-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.programming-categories.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_type', ['type' => __('main.programming_category')]) }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-sitemap',
                    'items' => [
                        ['id' => 'stat-total', 'value' => count($programmingCategories), 'label' => __('main.total_types', ['types' => __('main.programming_categories')])],
                        ['id' => 'stat-active', 'value' => $programmingCategories->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $programmingCategories->where('is_active', false)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-code-branch',
                'title' => __('main.programming_categories'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.programming_categories')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.programming_categories')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    @if (auth()->user()->can('programming-categories-create'))
                        <a href="{{ route('dashboard.programming-categories.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);"
                            toggle-button>
                            {{ __('main.create_type', ['type' => __('main.programming_category')]) }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.alt_text') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programmingCategories as $programmingCategory)
                                <tr id="row-{{ $programmingCategory->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $programmingCategory->is_active }}">
                                    <td title="{{ $programmingCategory->alt_text ?? '' }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($programmingCategory->image && checkExistFile($programmingCategory->image))
                                                <img src="{{ asset('storage/' . $programmingCategory->image) }}" alt="{{ $programmingCategory->alt_text ?? '' }}"
                                                    class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                            @else
                                                <i class="fas fa-code text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4" title="{{ $programmingCategory->alt_text ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($programmingCategory->alt_text ?? '--', 25) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $programmingCategory->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $programmingCategory->is_active,
                                            'modelClass' => 'programmingCategory',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($programmingCategory->creator)
                                            <a href="{{ route('dashboard.users.show', $programmingCategory->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $programmingCategory->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        <small>{{ $programmingCategory->created_at?->format('d/m/Y H:i') ?? '--' }}</small>
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-800">{{ $programmingCategory->order ?? 0 }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $programmingCategory,
                                            'models' => 'programming-categories',
                                            'modelClass' => 'programming-category',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-gray-500">
                                        <p>{{ __('messages.no_records_found') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($programmingCategories->hasPages())
                        <div class="entity-pagination">
                            {{ $programmingCategories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
