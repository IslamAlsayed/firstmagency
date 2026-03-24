@extends('dashboard.layout.master')

@section('title', __('main.hosting_packages'))
@section('page-title', '📦 ' . __('main.hosting_packages'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800">{{ $allItems }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_types', ['types' => __('main.hosting_packages')]) }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-blue-600">{{ $hostingCount }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.shared') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600">{{ $resellerCount }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.reseller') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-purple-600">{{ $vpsCount }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.vps') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-orange-600">{{ $serversCount }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.dedicated') }}</small>
            </div>
        </div>

        <div class="bg-white shadow-lg radius-lg">
            <div class="border-b border-gray-200">
                <div class="flex justify-between items-center p-4 border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-cube mr-2"></i> {{ __('main.hosting_packages') }}</h5>

                    <div class="flex justify-between items-center gap-4">
                        <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.hosting_packages')]) }}">
                        <a href="{{ route('dashboard.hosting-packages.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);"
                            toggle-button>
                            {{ __('main.create_type', ['type' => __('main.hosting_package')]) }}
                        </a>
                    </div>
                </div>

                <div class="flex justify-start gap-2 pt-4 flex-wrap px-4">
                    <button type="button" class="filter-btn cursor-pointer px-4 py-2 rounded-lg border-2 border-primary text-primary font-medium active" data-filter="all">
                        {{ __('main.all') }} ({{ $allItems }})
                    </button>
                    <button type="button" data-filter="hosting"
                        class="filter-btn cursor-pointer px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-600 font-medium hover:border-primary hover:text-primary">
                        {{ __('main.shared') }} ({{ $hostingCount }})
                    </button>
                    <button type="button" data-filter="reseller"
                        class="filter-btn cursor-pointer px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-600 font-medium hover:border-primary hover:text-primary">
                        {{ __('main.reseller') }} ({{ $resellerCount }})
                    </button>
                    <button type="button" data-filter="vps"
                        class="filter-btn cursor-pointer px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-600 font-medium hover:border-primary hover:text-primary">
                        {{ __('main.vps') }} ({{ $vpsCount }})
                    </button>
                    <button type="button" data-filter="servers"
                        class="filter-btn cursor-pointer px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-600 font-medium hover:border-primary hover:text-primary">
                        {{ __('main.dedicated') }} ({{ $serversCount }})
                    </button>
                </div>
            </div>

            <div class="scroll-container">
                <div class="p-4">
                    <table class="w-full border-collapse" id="packagesTable">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.category') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.monthly_label') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.yearly_label') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.popular') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hostingPackages as $package)
                                <tr id="row-{{ $package->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition package-row" data-category="{{ $package->category }}">
                                    <td class="p-4">
                                        @if ($package->image && checkExistFile($package->image))
                                            <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->translations[app()->getLocale()]['title'] ?? '' }}"
                                                class="rounded-lg size-10 shrink-0 object-cover">
                                        @else
                                            <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ $package->translations[app()->getLocale()]['title'] ?? '' }}" class="rounded-lg size-10 shrink-0">
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <strong class="text-sm text-gray-800 block">
                                            {{ limitedText($package->translations[app()->getLocale()]['title'] ?? '', 40) }}
                                        </strong>
                                    </td>
                                    <td class="p-4 text-sm">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if ($package->category === 'hosting') bg-blue-100 text-blue-800
                                            @elseif($package->category === 'reseller') bg-green-100 text-green-800
                                            @elseif($package->category === 'vps') bg-pink-100 text-pink-800
                                            @else bg-orange-100 text-orange-800 @endif">
                                            {{ __('main.' . str_replace('-', '_', $package->category)) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-600">${{ number_format($package->monthly_price, 2) }}</td>
                                    <td class="p-4 text-sm font-semibold text-gray-600">${{ number_format($package->yearly_price, 2) }}</td>
                                    <td class="p-4">
                                        @if ($package->is_popular)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-star mr-1"></i>{{ __('main.popular') }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $package->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $package->is_active,
                                            'modelClass' => 'hostingPackage',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $package->order }}</td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($package->creator)
                                            <a href="{{ route('dashboard.users.show', $package->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $package->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $package,
                                            'models' => 'hosting-packages',
                                            'modelClass' => 'hosting-package',
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

                @if ($hostingPackages->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $hostingPackages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const packageRows = document.querySelectorAll('.package-row');
            let currentFilter = 'all';

            // Filter button click handler
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    currentFilter = this.dataset.filter;

                    filterButtons.forEach(btn => btn.classList.remove('border-primary', 'text-primary', 'active'));
                    filterButtons.forEach(btn => btn.classList.add('border-gray-300', 'text-gray-600'));
                    this.classList.add('border-primary', 'text-primary', 'active');
                    this.classList.remove('border-gray-300', 'text-gray-600');

                    applyFilters();
                });
            });

            // Apply filters function
            function applyFilters() {
                packageRows.forEach(row => {
                    const category = row.dataset.category;
                    const categoryMatch = currentFilter === 'all' || category === currentFilter;
                    row.style.display = categoryMatch ? '' : 'none';
                });
            }
        });
    </script>
@endpush
