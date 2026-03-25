@extends('dashboard.layout.master')

@section('title', __('main.programming-systems'))
@section('page-title', '💻 ' . __('main.programming-systems'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush


@section('content')
    <div class="entity-index-page" style="--page-accent: #2563eb;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-code"></i>
                        {{ __('main.programming-systems') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.programming-systems') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_types', ['types' => __('main.programming-systems')]) }}</p>

                    @if (auth()->user()->can('programming-systems-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.programming-systems.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_type', ['type' => __('main.programming_system')]) }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-laptop-code',
                    'items' => [
                        ['id' => 'stat-total', 'value' => count($programmingSystems), 'label' => __('main.total_types', ['types' => __('main.programming-systems')])],
                        ['id' => 'stat-active', 'value' => $programmingSystems->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $programmingSystems->where('is_active', false)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-code',
                'title' => __('main.programming-systems'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.programming-systems')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.programming-systems')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    @if (auth()->user()->can('programming-systems-create'))
                        <a href="{{ route('dashboard.programming-systems.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);"
                            toggle-button>
                            {{ __('main.create_type', ['type' => __('main.programming_system')]) }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell overflow-x-auto">
                    <table class="entity-table w-full border-collapse min-w-max">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programmingSystems as $programmingSystem)
                                <tr id="row-{{ $programmingSystem->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $programmingSystem->is_active }}">
                                    <td title="{{ $programmingSystem->alt_text ?? ($programmingSystem->translations[app()->getLocale()]['title'] ?? '') }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($programmingSystem->image && checkExistFile($programmingSystem->image))
                                                <img src="{{ asset('storage/' . $programmingSystem->image) }}"
                                                    alt="{{ $programmingSystem->alt_text ?? ($programmingSystem->translations[app()->getLocale()]['title'] ?? '') }}"
                                                    class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                            @else
                                                <i class="fas fa-code text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4" title="{{ $programmingSystem->translations[app()->getLocale()]['title'] ?? '--' }}">
                                        <strong class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($programmingSystem->translations[app()->getLocale()]['title'] ?? '--', 25) }}
                                        </strong>
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $programmingSystem->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $programmingSystem->is_active,
                                            'modelClass' => 'programmingSystem',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($programmingSystem->creator)
                                            <a href="{{ route('dashboard.users.show', $programmingSystem->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $programmingSystem->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $programmingSystem->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $programmingSystem->order ?? 0 }}</td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $programmingSystem,
                                            'models' => 'programming-systems',
                                            'modelClass' => 'programming-system',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($programmingSystems->hasPages())
                    <div class="entity-pagination">
                        {{ $programmingSystems->links() }}
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
