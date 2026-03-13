@extends('dashboard.layout.master')

@section('title', __('main.our_programmings'))
@section('page-title', '💻 ' . __('main.our_programmings'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ count($ourProgrammings) }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_our_programmings') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-active">{{ $ourProgrammings->where('is_active', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.active') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600" id="stat-inactive">{{ $ourProgrammings->where('is_active', false)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.inactive') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-blue-600">{{ $ourProgrammings->where('is_featured', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.featured') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-code mr-2"></i> {{ __('main.our_programmings') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox"
                        class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/40"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.our_programmings')]) }}">
                    <a href="{{ route('dashboard.our-programmings.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_our_programming') }}
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
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.featured') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ourProgrammings as $ourProgramming)
                                <tr id="row-{{ $ourProgramming->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition"
                                    data-active="{{ (int) $ourProgramming->is_active }}">
                                    <td title="{{ $ourProgramming->alt_text ?? '' }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($ourProgramming->image && checkExistFile($ourProgramming->image))
                                                <img src="{{ asset('storage/' . $ourProgramming->image) }}" alt="{{ $ourProgramming->alt_text ?? '' }}"
                                                    class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                            @else
                                                <i class="fas fa-code text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td title="{{ $ourProgramming->alt_text ?? '--' }}">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            {{ limitedText($ourProgramming->alt_text ?? '--', 25) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $ourProgramming->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $ourProgramming->is_active,
                                            'modelClass' => 'our_programming',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $ourProgramming->id,
                                            'field' => 'is_featured',
                                            'value' => (bool) $ourProgramming->is_featured,
                                            'modelClass' => 'our_programming',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($ourProgramming->creator)
                                            <a href="{{ route('dashboard.users.show', $ourProgramming->creator->id) }}" class="text-primary hover:underline">
                                                {{ $ourProgramming->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        <small>{{ $ourProgramming->created_at?->format('d/m/Y H:i') ?? '--' }}</small>
                                    </td>
                                    <td class="p-4 text-sm font-semibold text-gray-800">{{ $ourProgramming->order ?? 0 }}</td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $ourProgramming,
                                            'models' => 'our-programmings',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-6 text-gray-500">
                                        <p>{{ __('messages.no_records_found') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($ourProgrammings->hasPages())
                    <div class="p-4 border-t border-gray-200">
                        {{ $ourProgrammings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
