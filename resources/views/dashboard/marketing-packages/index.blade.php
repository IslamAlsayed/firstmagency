@extends('dashboard.layout.master')

@section('title', __('main.marketing_packages'))
@section('page-title', '📦 ' . __('main.marketing_packages'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #7c3aed;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-box"></i>
                        {{ __('main.marketing_packages') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.marketing_packages') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_types', ['types' => __('main.marketing_packages')]) }}</p>

                    @if (auth()->user()->can('marketing-packages-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.marketing-packages.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_type', ['type' => __('main.marketing_packages')]) }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-pie',
                    'items' => [
                        ['id' => 'stat-total', 'value' => $marketingPackages->total(), 'label' => __('main.total_types', ['types' => __('main.marketing_packages')])],
                        ['id' => 'stat-active', 'value' => $marketingPackages->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $marketingPackages->where('is_active', false)->count(), 'label' => __('main.inactive')],
                        ['id' => 'stat-popular', 'value' => $marketingPackages->where('is_popular', true)->count(), 'label' => __('main.popular')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-box',
                'title' => __('main.marketing_packages'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.marketing_packages')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.marketing_packages')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    @if (auth()->user()->can('marketing-packages-create'))
                        <a href="{{ route('dashboard.marketing-packages.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);"
                            toggle-button>
                            {{ __('main.create_type', ['type' => __('main.marketing_packages')]) }}
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
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.icon') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($marketingPackages as $item)
                                <tr id="row-{{ $item->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $item->is_active }}"
                                    data-popular="{{ (int) $item->is_popular }}">
                                    <td title="{{ $item->alt_text ?? ($item->translations[app()->getLocale()]['title'] ?? '') }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($item->image && checkExistFile($item->image))
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->alt_text ?? ($item->translations[app()->getLocale()]['title'] ?? '') }}"
                                                    class="w-[90px] h-[35px] rounded-[9px] shrink-0 object-cover">
                                            @else
                                                <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                                                    <i class="opacity-25">{{ __('main.null') }}</i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600 w-24">
                                        @if ($item->icon)
                                            {!! $item->icon ?? '--' !!}
                                        @else
                                            <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                                                <i class="opacity-25">{{ __('main.null') }}</i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4" title="{{ $item->translations[app()->getLocale()]['title'] ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($item->translations[app()->getLocale()]['title'] ?? '--', 25) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $item->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $item->is_active,
                                            'modelClass' => 'marketingPackage',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($item->creator)
                                            <a href="{{ route('dashboard.users.show', $item->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $item->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $item->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $item->order ?? 0 }}</td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $item,
                                            'models' => 'marketing-packages',
                                            'modelClass' => 'marketing-package',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-8 text-center text-gray-400">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($marketingPackages->hasPages())
                        <div class="entity-pagination">
                            {{ $marketingPackages->links() }}
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
