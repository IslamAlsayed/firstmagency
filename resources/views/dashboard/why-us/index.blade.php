@extends('dashboard.layout.master')

@section('title', __('main.why_us'))
@section('page-title', 'í¼Ÿ ' . __('main.why_us'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #f59e0b;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-star"></i>
                        {{ __('main.why_us') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.why_us') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_why_us') }}</p>

                    <div class="entity-hero-actions">
                        <a href="{{ route('dashboard.why-us.create') }}" class="entity-hero-action">
                            <i class="fas fa-plus-circle"></i>
                            {{ __('main.create_why_us') }}
                        </a>
                    </div>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-pie',
                    'items' => [
                        ['id' => 'stat-total', 'value' => $whyUs->total(), 'label' => __('main.total_why_us')],
                        ['id' => 'stat-active', 'value' => $whyUs->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $whyUs->where('is_active', false)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-star',
                'title' => __('main.why_us'),
                'description' => __('main.search_why_us'),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_why_us') }}">
                </div>

                <div class="entity-toolbar-group">
                    <a href="{{ route('dashboard.why-us.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.create_why_us') }}
                    </a>
                </div>
            </div>

            <div class="entity-content">
                <div class="entity-table-shell scroll-container">
                    <table class="entity-table w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($whyUs as $item)
                                <tr id="row-{{ $item->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $item->is_active }}">
                                    <td title="{{ $item->alt_text ?? ($item->translations[app()->getLocale()]['title'] ?? '') }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($item->image && checkExistFile($item->image))
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->alt_text ?? ($item->translations[app()->getLocale()]['title'] ?? '') }}" class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                            @else
                                                <i class="fas fa-star text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
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
                                            'modelClass' => 'whyUs',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $item->order ?? 0 }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.status-actions', [
                                            'record' => $item,
                                            'models' => 'why-us',
                                            'modelClass' => 'why-us',
                                            'availableOptions' => array_column(\App\Enum\WhyUsEnums::cases(), 'value'),
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
                                            'models' => 'why-us',
                                            'modelClass' => 'why-us',
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

                    @if ($whyUs->hasPages())
                        <div class="entity-pagination">
                            {{ $whyUs->links() }}
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
