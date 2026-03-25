@extends('dashboard.layout.master')

@section('title', __('main.project_steps'))
@section('page-title', 'í³‹ ' . __('main.project_steps'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #8b5cf6;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-list"></i>
                        {{ __('main.project_steps') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.project_steps') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_project_steps') }}</p>

                    <div class="entity-hero-actions">
                        <a href="{{ route('dashboard.project-steps.create') }}" class="entity-hero-action">
                            <i class="fas fa-plus-circle"></i>
                            {{ __('main.create_project_step') }}
                        </a>
                    </div>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-line',
                    'items' => [
                        ['id' => 'stat-total', 'value' => $projectSteps->total(), 'label' => __('main.total_project_steps')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-list',
                'title' => __('main.project_steps'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.project_steps')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.project_steps')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    <a href="{{ route('dashboard.project-steps.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.create_project_step') }}
                    </a>
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.icon') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projectSteps as $projectStep)
                                <tr id="row-{{ $projectStep->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td title="{{ $projectStep->translations[app()->getLocale()]['title'] ?? '--' }}" class="p-4">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($projectStep->translations[app()->getLocale()]['title'] ?? '--', 30) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm">
                                        @if ($projectStep->icon ?? null)
                                            <i class="{{ $projectStep->icon }} me-2"></i>
                                            {{ $projectStep->icon }}
                                        @else
                                            <span class="text-gray-400">--</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-600">{{ $projectStep->order ?? 0 }}</td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($projectStep->creator)
                                            <a href="{{ route('dashboard.users.show', $projectStep->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $projectStep->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-500">{{ $projectStep->created_at?->format('d/m/Y') ?? '--' }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $projectStep,
                                            'models' => 'project-steps',
                                            'modelClass' => 'project-step',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($projectSteps->hasPages())
                        <div class="entity-pagination">
                            {{ $projectSteps->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
