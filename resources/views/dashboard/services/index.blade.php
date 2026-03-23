@extends('dashboard.layout.master')

@section('title', __('main.services'))
@section('page-title', '💼 ' . __('main.services'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ count($services) }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_services') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-active">{{ $services->where('is_active', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.active') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600" id="stat-inactive">{{ $services->where('is_active', false)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.inactive') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-building mr-2"></i> {{ __('main.services') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.services')]) }}">
                    <a href="{{ route('dashboard.services.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_service') }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <div class="p-4">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
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
                            @forelse($services as $service)
                                <tr id="row-{{ $service->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $service->is_active }}">
                                    <td title="{{ $service->translations[app()->getLocale()]['title'] ?? '' }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($service->icon && checkExistFile($service->icon))
                                                <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->translations[app()->getLocale()]['title'] ?? '' }}"
                                                    class="rounded-full size-9 shrink-0">
                                            @else
                                                <i class="fas fa-briefcase text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <strong class="text-sm text-gray-800 block">
                                            {{ limitedText($service->translations[app()->getLocale()]['title'] ?? '', 50) }}
                                        </strong>
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $service->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $service->is_active,
                                            'modelClass' => 'service',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($service->creator)
                                            <a href="{{ route('dashboard.users.show', $service->creator->id) }}" class="text-blue-600 hover:underline">
                                                {{ $service->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $service->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $service->order ?? 0 }}</td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $service,
                                            'models' => 'services',
                                            'modelClass' => 'service',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($services->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
