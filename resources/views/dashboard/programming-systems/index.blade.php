@extends('dashboard.layout.master')

@section('title', __('main.programming-systems'))
@section('page-title', '💻 ' . __('main.programming-systems'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ count($programmingSystems) }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_types', ['types' => __('main.programming-systems')]) }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-active">{{ $programmingSystems->where('is_active', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.active') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600" id="stat-inactive">{{ $programmingSystems->where('is_active', false)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.inactive') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-code mr-2"></i> {{ __('main.programming-systems') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.programming-systems')]) }}">
                    <a href="{{ route('dashboard.programming-systems.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_type', ['type' => __('main.programming_system')]) }}
                    </a>
                </div>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="w-full border-collapse min-w-max">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programmingSystems as $programmingSystem)
                            <tr id="row-{{ $programmingSystem->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $programmingSystem->is_active }}">
                                <td title="{{ $programmingSystem->alt_text ?? ($programmingSystem->translations[app()->getLocale()]['title'] ?? '') }}" class="p-4">
                                    <div class="relative w-fit">
                                        @if ($programmingSystem->image && checkExistFile($programmingSystem->image))
                                            <img src="{{ asset('storage/' . $programmingSystem->image) }}"
                                                alt="{{ $programmingSystem->alt_text ?? ($programmingSystem->translations[app()->getLocale()]['title'] ?? '') }}"
                                                class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                        @else
                                            <i class="fas fa-code text-2xl text-gray-400"></i>
                                        @endif
                                    </div>
                                </td>
                                <td title="{{ $programmingSystem->translations[app()->getLocale()]['title'] ?? '--' }}">
                                    <strong class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                        {{ limitedText($programmingSystem->translations[app()->getLocale()]['title'] ?? '--', 25) }}
                                    </strong>
                                </td>
                                <td class="p-4 text-sm">
                                    @include('dashboard.components.toggle-hold', [
                                        'modelId' => $programmingSystem->id,
                                        'field' => 'is_active',
                                        'value' => (bool) $programmingSystem->is_active,
                                        'modelClass' => 'programmingSystem',
                                    ])
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    @if ($programmingSystem->creator)
                                        <a href="{{ route('dashboard.users.show', $programmingSystem->creator->id) }}" class="text-blue-600 hover:underline">
                                            {{ $programmingSystem->creator->name }}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">N/A</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-600">{{ $programmingSystem->created_at?->format('d/m/Y') }}</td>
                                <td class="p-4 text-sm text-gray-600">{{ $programmingSystem->order ?? 0 }}</td>
                                <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                    @include('dashboard.components.permissions-actions', [
                                        'record' => $programmingSystem,
                                        'models' => 'programming-systems',
                                        'modelClass' => 'programming-system',
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
            </div>

            @if ($programmingSystems->hasPages())
                <div class="mt-6 border-t pt-4">
                    {{ $programmingSystems->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
