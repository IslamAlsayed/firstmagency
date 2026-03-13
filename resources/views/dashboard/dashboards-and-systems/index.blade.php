@extends('dashboard.layout.master')

@section('title', __('main.dashboards_and_apps'))
@section('page-title', '🔧 ' . __('main.dashboards_and_apps'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800">{{ $allItems }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_types', ['types' => __('main.dashboards_and_apps')]) }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800">{{ $operatingSystemsCount }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_operating_systems') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-blue-600">{{ $dashboardsAndAppsCount }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_dashboards_and_apps') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-tools mr-2"></i> {{ __('main.dashboards_and_apps') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox"
                        class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.dashboards_and_apps')]) }}">
                    <a href="{{ route('dashboard.dashboards-and-systems.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_dashboards_and_app') }}
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
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.slug') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.type') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardsAndSystems as $app)
                                <tr id="row-{{ $app->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="p-4">
                                        <div class="relative w-fit">
                                            @if ($app->image && checkExistFile($app->image))
                                                <img src="{{ asset('storage/' . $app->image) }}" alt="{{ $app->translations[app()->getLocale()]['title'] ?? '' }}"
                                                    class="w-[90px] h-[35px] rounded-[9px] shrink-0 object-cover">
                                            @else
                                                <i class="fas fa-tools text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td title="{{ $app->translations[app()->getLocale()]['title'] ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($app->translations[app()->getLocale()]['title'] ?? '--', 30) }}
                                        </span>
                                    </td>
                                    <td title="{{ $app->slug ?? '--' }}" class="p-4 text-sm text-gray-600">
                                        {{ limitedText($app->slug ?? '--', 25) }}
                                    </td>
                                    <td class="p-4 text-sm">
                                        <span class="inline-block bg-purple-50 text-purple-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ $app->type ?? '--' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-600">{{ $app->order ?? 0 }}</td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($app->creator)
                                            <a href="{{ route('dashboard.users.show', $app->creator->id) }}" class="text-primary hover:underline">
                                                {{ $app->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-500">{{ $app->created_at?->format('d/m/Y') ?? '--' }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $app,
                                            'models' => 'dashboards-and-systems',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-4 text-center text-gray-500">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($dashboardsAndSystems->hasPages())
                    <div class="border-t border-gray-300 p-4">
                        {{ $dashboardsAndSystems->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
