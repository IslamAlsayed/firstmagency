@extends('dashboard.layout.master')

@section('title', __('main.marketing_packages'))
@section('page-title', '📦 ' . __('main.marketing_packages'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ $marketingPackages->total() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_types', ['types' => __('main.marketing_packages')]) }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-active">{{ $marketingPackages->where('is_active', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.active') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600" id="stat-inactive">{{ $marketingPackages->where('is_active', false)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.inactive') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-blue-600" id="stat-popular">{{ $marketingPackages->where('is_popular', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.popular') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-box mr-2"></i> {{ __('main.marketing_packages') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox"
                        class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.marketing_packages')]) }}">
                    <a href="{{ route('dashboard.marketing-packages.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_type', ['type' => __('main.marketing_packages')]) }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.icon') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($marketingPackages as $item)
                            <tr id="row-{{ $item->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition"
                                data-active="{{ (int) $item->is_active }}" data-popular="{{ (int) $item->is_popular }}">
                                <td title="{{ $item->alt_text ?? ($item->translations[app()->getLocale()]['title'] ?? '') }}" class="p-4">
                                    <div class="relative w-fit">
                                        @if ($item->image && checkExistFile($item->image))
                                            <img src="{{ asset('storage/' . $item->image) }}"
                                                alt="{{ $item->alt_text ?? ($item->translations[app()->getLocale()]['title'] ?? '') }}"
                                                class="w-[90px] h-[35px] rounded-[9px] shrink-0 object-cover">
                                        @else
                                            <div
                                                class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
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
                                <td title="{{ $item->translations[app()->getLocale()]['title'] ?? '--' }}">
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
                                        <a href="{{ route('dashboard.users.show', $item->creator->id) }}" class="text-primary hover:underline">
                                            {{ $item->creator->name }}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
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
                    <div class="mt-6 border-t pt-4">
                        {{ $marketingPackages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
