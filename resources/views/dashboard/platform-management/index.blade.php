@extends('dashboard.layout.master')

@section('title', __('main.platform_management'))
@section('page-title', '📱 ' . __('main.platform_management'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ $platformManagements->total() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_platform_management') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-active">{{ $platformManagements->where('is_active', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.active') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600" id="stat-inactive">{{ $platformManagements->where('is_active', false)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.inactive') }}</small>
            </div>
        </div>

        <div class="bg-white shadow-lg radius-lg">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-mobile-alt mr-2"></i> {{ __('main.platform_management') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_platform_management') }}">
                    <a href="{{ route('dashboard.platform-management.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_platform_management') }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <table class="w-full border-collapse">
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
                    <div class="mt-6 border-t pt-4">
                        {{ $platformManagements->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
