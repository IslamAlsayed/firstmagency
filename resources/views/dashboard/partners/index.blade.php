@extends('dashboard.layout.master')

@section('title', __('main.partners'))
@section('page-title', '🤝 ' . __('main.partners'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush


@section('content')
    <div class="entity-index-page" style="--page-accent: #0f766e;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-handshake"></i>
                        {{ __('main.partners') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.partners') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_partners') }}</p>

                    @if (auth()->user()->can('partners-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.partners.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_partner') }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-handshake-angle',
                    'items' => [
                        ['id' => 'stat-total', 'value' => count($partners), 'label' => __('main.total_partners')],
                        ['id' => 'stat-active', 'value' => $partners->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $partners->where('is_active', false)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-handshake',
                'title' => __('main.partners'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.partners')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.partners')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    @if (auth()->user()->can('partners-create'))
                        <a href="{{ route('dashboard.partners.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                            {{ __('main.create_partner') }}
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
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.website') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($partners as $partner)
                                <tr id="row-{{ $partner->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $partner->is_active }}">
                                    <td title="{{ $partner->alt_text ?? ($partner->translations[app()->getLocale()]['name'] ?? '') }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($partner->image && checkExistFile($partner->image))
                                                <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->alt_text ?? ($partner->translations[app()->getLocale()]['name'] ?? '') }}"
                                                    class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                            @else
                                                <i class="fas fa-handshake text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4" title="{{ $partner->alt_text ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($partner->alt_text ?? '--', 25) }}
                                        </span>
                                    </td>
                                    <td class="p-4" title="{{ $partner->website ?? '--' }}">
                                        @if ($partner->website)
                                            <a href="{{ $partner->website }}" target="_blank"
                                                class="inline-block bg-primary/10 text-primary hover:underline text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                                                {!! limitedText($partner->website ?? '--', 30) !!}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                                                <i class="opacity-25">{{ __('main.null') }}</i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $partner->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $partner->is_active,
                                            'modelClass' => 'partner',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($partner->creator)
                                            <a href="{{ route('dashboard.users.show', $partner->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $partner->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $partner->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $partner->order ?? 0 }}</td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $partner,
                                            'models' => 'partners',
                                            'modelClass' => 'partner',
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

                    @if ($partners->hasPages())
                        <div class="entity-pagination">
                            {{ $partners->links() }}
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
