@extends('dashboard.layout.master')

@section('title', __('main.official_domains'))
@section('page-title', '🌐 ' . __('main.official_domains'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ count($officialDomains) }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_official_domains') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-active">{{ $officialDomains->where('is_active', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.active') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600" id="stat-inactive">{{ $officialDomains->where('is_active', false)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.inactive') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-globe mr-2"></i> {{ __('main.official_domains') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.official_domains')]) }}">
                    <a href="{{ route('dashboard.official-domains.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_official_domain') }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.badge') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($officialDomains as $officialDomain)
                            <tr id="row-{{ $officialDomain->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $officialDomain->is_active }}">
                                <td class="p-4 text-sm text-gray-600">{{ $officialDomain->title ?? '' }}</td>
                                <td class="p-4 text-sm text-gray-600">{{ $officialDomain->translations[app()->getLocale()]['badge'] ?? '' }}</td>
                                <td class="p-4 text-sm">
                                    @include('dashboard.components.toggle-hold', [
                                        'modelId' => $officialDomain->id,
                                        'field' => 'is_active',
                                        'value' => (bool) $officialDomain->is_active,
                                        'modelClass' => 'officialDomain',
                                    ])
                                </td>
                                <td class="p-4 text-sm text-gray-600">{{ $officialDomain->order ?? 0 }}</td>
                                <td class="p-4 text-sm">
                                    @include('dashboard.components.status-actions', [
                                        'record' => $officialDomain,
                                        'models' => 'official-domains',
                                        'modelClass' => 'officialDomain',
                                        'availableOptions' => array_column(\App\Enum\PestDomainEnums::cases(), 'value'),
                                    ])
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if ($officialDomain->status === 'published') bg-green-100 text-green-800
                                        @elseif($officialDomain->status === 'draft') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ __('main.' . $officialDomain->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    @if ($officialDomain->creator)
                                        <a href="{{ route('dashboard.users.show', $officialDomain->creator->id) }}" class="text-blue-600 hover:underline">
                                            {{ $officialDomain->creator->name }}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">N/A</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-600">{{ $officialDomain->created_at?->format('d/m/Y') }}</td>
                                <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                    @include('dashboard.components.permissions-actions', [
                                        'record' => $officialDomain,
                                        'models' => 'official-domains',
                                        'modelClass' => 'official-domain',
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

                @if ($officialDomains->hasPages())
                    <div class="mt-6 border-t pt-4 px-2">
                        {{ $officialDomains->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
