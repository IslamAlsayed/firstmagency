@extends('dashboard.layout.master')

@section('title', __('main.partners'))
@section('page-title', '🤝 ' . __('main.partners'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ count($partners) }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_partners') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-active">{{ $partners->where('is_active', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.active') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600" id="stat-inactive">{{ $partners->where('is_active', false)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.inactive') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-blue-600" id="stat-featured">{{ $partners->where('is_featured', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.featured') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-handshake mr-2"></i> {{ __('main.partners') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox"
                        class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.partners')]) }}">
                    <a href="{{ route('dashboard.partners.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_partner') }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <div class="p-4">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.alt_text') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.website') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.featured') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($partners as $partner)
                                <tr id="row-{{ $partner->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition"
                                    data-active="{{ (int) $partner->is_active }}" data-featured="{{ (int) $partner->is_featured }}">
                                    <td title="{{ $partner->alt_text ?? ($partner->translations[app()->getLocale()]['name'] ?? '') }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($partner->image && checkExistFile($partner->image))
                                                <img src="{{ asset('storage/' . $partner->image) }}"
                                                    alt="{{ $partner->alt_text ?? ($partner->translations[app()->getLocale()]['name'] ?? '') }}"
                                                    class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                            @else
                                                <i class="fas fa-handshake text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td title="{{ $partner->alt_text ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($partner->alt_text ?? '--', 25) }}
                                        </span>
                                    </td>
                                    <td title="{{ $partner->website ?? '--' }}">
                                        @if ($partner->website)
                                            <a href="{{ $partner->website }}" target="_blank"
                                                class="inline-block bg-primary/10 text-primary hover:underline text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                                                {!! limitedText($partner->website ?? '--', 30) !!}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                            </a>
                                        @else
                                            <div
                                                class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
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
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $partner->id,
                                            'field' => 'is_featured',
                                            'value' => (bool) $partner->is_featured,
                                            'modelClass' => 'partner',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($partner->creator)
                                            <a href="{{ route('dashboard.users.show', $partner->creator->id) }}" class="text-primary hover:underline">
                                                {{ $partner->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
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
                </div>

                @if ($partners->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $partners->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
