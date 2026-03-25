@extends('dashboard.layout.master')

@section('title', __('main.line_works'))
@section('page-title', '⚙️ ' . __('main.line_works'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #6366f1;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-cogs"></i>
                        {{ __('main.line_works') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.line_works') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_line_works') }}</p>

                    <div class="entity-hero-actions">
                        <a href="{{ route('dashboard.line-works.create') }}" class="entity-hero-action">
                            <i class="fas fa-plus-circle"></i>
                            {{ __('main.create_line_work') }}
                        </a>
                    </div>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-pie',
                    'items' => [
                        ['id' => 'stat-total', 'value' => count($lineWorks), 'label' => __('main.total_line_works')],
                        ['id' => 'stat-active', 'value' => $lineWorks->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $lineWorks->where('is_active', false)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-cogs',
                'title' => __('main.line_works'),
                'description' => __('main.search_line_works_placeholder'),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_line_works_placeholder') }}">
                </div>

                <div class="entity-toolbar-group">
                    <a href="{{ route('dashboard.line-works.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.create_line_work') }}
                    </a>
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.alt_text') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lineWorks as $lineWork)
                                <tr id="row-{{ $lineWork->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $lineWork->is_active }}">
                                    <td title="{{ $lineWork->alt_text ?? ($lineWork->translations[app()->getLocale()]['title'] ?? '') }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($lineWork->image && checkExistFile($lineWork->image))
                                                <img src="{{ asset('storage/' . $lineWork->image) }}" alt="{{ $lineWork->alt_text ?? ($lineWork->translations[app()->getLocale()]['title'] ?? '') }}" class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                            @else
                                                <i class="fas fa-image text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4" title="{{ $lineWork->alt_text ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($lineWork->alt_text ?? '--', 25) }}
                                        </span>
                                    </td>
                                    <td class="p-4" title="{{ $lineWork->translations[app()->getLocale()]['title'] ?? '--' }}">
                                        <span class="text-gray-600">
                                            {{ limitedText($lineWork->translations[app()->getLocale()]['title'] ?? '--', 35) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $lineWork->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $lineWork->is_active,
                                            'modelClass' => 'line-work',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($lineWork->creator)
                                            <a href="{{ route('dashboard.users.show', $lineWork->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $lineWork->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $lineWork->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $lineWork->order ?? 0 }}</td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $lineWork,
                                            'models' => 'line-works',
                                            'modelClass' => 'line-work',
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

                    @if ($lineWorks->hasPages())
                        <div class="entity-pagination">
                            {{ $lineWorks->links() }}
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
