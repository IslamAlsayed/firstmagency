@extends('dashboard.layout.master')

@section('title', __('main.pest_domains'))
@section('page-title', '🌐 ' . __('main.pest_domains'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ count($pestDomains) }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_pest_domains') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-active">{{ $pestDomains->where('is_active', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.active') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600" id="stat-inactive">{{ $pestDomains->where('is_active', false)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.inactive') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-globe mr-2"></i> {{ __('main.pest_domains') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.pest_domains')]) }}">
                    <a href="{{ route('dashboard.pest-domains.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_pest_domain') }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.alt_text') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pestDomains as $pestDomain)
                            <tr id="row-{{ $pestDomain->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $pestDomain->is_active }}">
                                <td title="{{ $pestDomain->alt_text ?? '' }}" class="p-4">
                                    <div class="relative w-fit">
                                        @if ($pestDomain->image && checkExistFile($pestDomain->image))
                                            <img src="{{ asset('storage/' . $pestDomain->image) }}" alt="{{ $pestDomain->alt_text ?? '' }}" class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                        @else
                                            <i class="fas fa-globe text-2xl text-gray-400"></i>
                                        @endif
                                    </div>
                                </td>
                                <td title="{{ $pestDomain->alt_text ?? '--' }}">
                                    <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                        {{ limitedText($pestDomain->alt_text ?? '--', 25) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm">
                                    @include('dashboard.components.toggle-hold', [
                                        'modelId' => $pestDomain->id,
                                        'field' => 'is_active',
                                        'value' => (bool) $pestDomain->is_active,
                                        'modelClass' => 'pestDomain',
                                    ])
                                </td>
                                <td class="p-4 text-sm text-gray-600">{{ $pestDomain->order ?? 0 }}</td>
                                <td class="p-4 text-sm">
                                    @include('dashboard.components.status-actions', [
                                        'record' => $pestDomain,
                                        'models' => 'pest-domains',
                                        'modelClass' => 'pestDomain',
                                        'availableOptions' => array_column(\App\Enum\PestDomainEnums::cases(), 'value'),
                                    ])
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if ($pestDomain->status === 'published') bg-green-100 text-green-800
                                    @elseif($pestDomain->status === 'draft') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                        {{ __('main.' . $pestDomain->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    @if ($pestDomain->creator)
                                        <a href="{{ route('dashboard.users.show', $pestDomain->creator->id) }}" class="text-primary hover:underline">
                                            {{ $pestDomain->creator->name }}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">N/A</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-600">{{ $pestDomain->created_at?->format('d/m/Y') }}</td>
                                <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                    @include('dashboard.components.permissions-actions', [
                                        'record' => $pestDomain,
                                        'models' => 'pest-domains',
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

                @if ($pestDomains->hasPages())
                    <div class="mt-6 border-t pt-4 px-2">
                        {{ $pestDomains->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
