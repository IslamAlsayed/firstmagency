@extends('dashboard.layout.master')

@section('title', __('main.clients'))
@section('page-title', '👥 ' . __('main.clients'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush


@section('content')
    <div class="entity-index-page" style="--page-accent: #0891b2;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-users"></i>
                        {{ __('main.clients') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.clients') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.total_clients') }}</p>

                    @if (auth()->user()->can('clients-create'))
                        <div class="entity-hero-actions">
                            <a href="{{ route('dashboard.clients.create') }}" class="entity-hero-action">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.create_client') }}
                            </a>
                        </div>
                    @endif
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-user-group',
                    'items' => [
                        ['id' => 'stat-total', 'value' => count($clients), 'label' => __('main.total_clients')],
                        ['id' => 'stat-active', 'value' => $clients->where('is_active', true)->count(), 'label' => __('main.active')],
                        ['id' => 'stat-inactive', 'value' => $clients->where('is_active', false)->count(), 'label' => __('main.inactive')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-users',
                'title' => __('main.clients'),
                'description' => __('main.search_types_placeholder', ['types' => __('main.clients')]),
            ])

            <div class="entity-toolbar">
                <div class="entity-toolbar-group">
                    <input type="text" id="searchBox" class="entity-input" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.clients')]) }}">
                </div>

                <div class="entity-toolbar-group">
                    @if (auth()->user()->can('clients-create'))
                        <a href="{{ route('dashboard.clients.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                            {{ __('main.create_client') }}
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
                            @forelse($clients as $client)
                                <tr id="row-{{ $client->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $client->is_active }}">
                                    <td title="{{ $client->alt_text ?? ($client->translations[app()->getLocale()]['name'] ?? '') }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($client->image && checkExistFile($client->image))
                                                <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->alt_text ?? ($client->translations[app()->getLocale()]['name'] ?? '') }}"
                                                    class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                            @else
                                                <i class="fas fa-users text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4" title="{{ $client->alt_text ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($client->alt_text ?? '--', 25) }}
                                        </span>
                                    </td>
                                    <td class="p-4" title="{{ $client->website ?? '--' }}">
                                        @if ($client->website)
                                            <a href="{{ $client->website }}" target="_blank"
                                                class="inline-block bg-primary/10 text-primary hover:underline text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                                                {!! limitedText($client->website ?? '--', 30) !!}
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
                                            'modelId' => $client->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $client->is_active,
                                            'modelClass' => 'client',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($client->creator)
                                            <a href="{{ route('dashboard.users.show', $client->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $client->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $client->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $client->order ?? 0 }}</td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $client,
                                            'models' => 'clients',
                                            'modelClass' => 'client',
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

                    @if ($clients->hasPages())
                        <div class="entity-pagination">
                            {{ $clients->links() }}
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
