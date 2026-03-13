@extends('dashboard.layout.master')

@section('title', __('main.features_hostings'))
@section('page-title', '🎁 ' . __('main.features_hostings'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800">{{ $allItems }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_types', ['types' => __('main.features_hostings')]) }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="text-2xl font-bold text-blue-600">{{ $allItemActive }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_active_types', ['types' => __('main.features_hostings')]) }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="text-2xl font-bold text-blue-600">{{ $allItemFeature }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_feature_types', ['types' => __('main.features_hostings')]) }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-list mr-2"></i> {{ __('main.features_hostings') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox"
                        class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/40"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.features_hostings')]) }}">
                    <a href="{{ route('dashboard.features-hosting.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_features_hosting') }}
                    </a>
                </div>
            </div>

            <div class="scroll-container">
                <div class="p-4">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.feature') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($featuresHosting as $feature)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="p-4 text-sm">
                                        @if ($feature->image)
                                            <img src="{{ asset('storage/' . $feature->image) }}" class="w-12 h-12 rounded object-cover shadow-sm">
                                        @else
                                            <span class="text-gray-400">--</span>
                                        @endif
                                    </td>
                                    <td title="{{ $feature->translations[app()->getLocale()]['title'] ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($feature->translations[app()->getLocale()]['title'] ?? '--', 30) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-600">{{ $feature->order ?? 0 }}</td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($feature->creator)
                                            <a href="{{ route('dashboard.users.show', $feature->creator->id) }}" class="text-primary hover:underline">
                                                {{ $feature->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $feature->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $feature->is_active,
                                            'modelClass' => 'featuresHosting',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $feature->id,
                                            'field' => 'is_featured',
                                            'value' => (bool) $feature->is_featured,
                                            'modelClass' => 'featuresHosting',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-500">{{ $feature->created_at?->format('d/m/Y') ?? '--' }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $feature,
                                            'models' => 'features-hosting',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($featuresHosting->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $featuresHosting->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
