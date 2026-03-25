@extends('dashboard.layout.master')

@section('title', __('main.platform_management'))
@section('page-title', 'í³± ' . __('main.platform_management'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush


@section('content')
    <div class="entity-index-page" style="--page-accent: #3b82f6;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-mobile-alt"></i>
                        {{ __('main.platform_management') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.platform_management') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_platform_management') }}</p>

                    <div class="entity-hero-actions">
                        <a href="{{ route('dashboard.platform-management.create') }}" class="entity-hero-action">
                            <i class="fas fa-plus-circle"></i>
                            {{ __('main.create_platform_management') }}
                        </a>
                    </div>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-pie',
                    'items' => [
                        ['id' => 'stat-total', 'value' => $platformManagements->total(), 'label' => __('main.total_platform_management')],
                        ['id' => 'stat-active', 'value' => $platformManagements->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $platformManagements->where('is_active', false)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-mobile-alt',
                'title' => __('main.platform_management'),
                'description' => __('main.search_platform_management'),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_platform_management') }}">
                </div>

                <div class="entity-toolbar-group">
                    <a href="{{ route('dashboard.platform-management.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.create_platform_management') }}
                    </a>
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.description') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($platformManagements as $item)
                                <tr id="row-{{ $item->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $item->is_active }}">
                                    <td title="{{ $item->translations[app()->getLocale()]['title'] ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($item->translations[app()->getLocale()]['title'] ?? '--', 25) }}
                                        </span>
                                    </td>
                                    <td title="{{ $item->translations[app()->getLocale()]['description'] ?? '--' }}" class="p-4">
                                        <span class="text-gray-600 text-sm">
                                            {{ limitedText($item->translations[app()->getLocale()]['description'] ?? '--', 50) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $item->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $item->is_active,
                                            'modelClass' => 'platformManagement',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $item->order ?? 0 }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.status-actions', [
                                            'record' => $item,
                                            'models' => 'platform-management',
                                            'modelClass' => 'platform-management',
                                            'availableOptions' => array_column(\App\Enum\PestDomainEnums::cases(), 'value'),
                                        ])
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if ($item->status === 'published') bg-green-100 text-green-800
                                    @elseif($item->status === 'draft') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                            {{ __('main.' . $item->status) }}
                                        </span>
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
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $item,
                                            'models' => 'platform-management',
                                            'modelClass' => 'platform-management',
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

                    @if ($platformManagements->hasPages())
                        <div class="entity-pagination">
                            {{ $platformManagements->links() }}
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
