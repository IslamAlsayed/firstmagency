@extends('dashboard.layout.master')

@section('title', __('main.programmings'))
@section('page-title', '💻 ' . __('main.programmings'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800">{{ count($programmings) }}</div>
                <small class="text-primary font-semibold">{{ __('main.total_programmings') }}</small>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600">{{ $programmings->where('is_active', true)->count() }}</div>
                <small class="text-primary font-semibold">{{ __('main.active') }}</small>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600">{{ $programmings->where('is_active', false)->count() }}</div>
                <small class="text-primary font-semibold">{{ __('main.inactive') }}</small>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-blue-600">{{ $programmings->where('is_featured', true)->count() }}</div>
                <small class="text-primary font-semibold">{{ __('main.featured') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-b border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-code mr-2"></i> {{ __('main.programmings') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox"
                        class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.programmings')]) }}">
                    <a href="{{ route('dashboard.programmings.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_programming') }}
                    </a>
                </div>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="w-full border-collapse min-w-max">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.name') }}</th>
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
                        @forelse($programmings as $programming)
                            <tr id="row-{{ $programming->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td title="{{ $programming->alt_text ?? ($programming->translations[app()->getLocale()]['name'] ?? '') }}" class="p-4">
                                    <div class="relative w-fit">
                                        @if ($programming->image && checkExistFile($programming->image))
                                            <img src="{{ asset('storage/' . $programming->image) }}"
                                                alt="{{ $programming->alt_text ?? ($programming->translations[app()->getLocale()]['name'] ?? '') }}"
                                                class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                        @else
                                            <i class="fas fa-code text-2xl text-gray-400"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    <strong>{{ $programming->translations[app()->getLocale()]['name'] ?? '--' }}</strong>
                                </td>
                                <td title="{{ $programming->alt_text ?? '--' }}">
                                    <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                        {{ limitedText($programming->alt_text ?? '--', 25) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm">
                                    @include('dashboard.components.toggle-hold', [
                                        'modelId' => $programming->id,
                                        'field' => 'is_active',
                                        'value' => (bool) $programming->is_active,
                                        'modelClass' => 'programming',
                                    ])
                                </td>
                                <td class="p-4 text-sm">
                                    @include('dashboard.components.toggle-hold', [
                                        'modelId' => $programming->id,
                                        'field' => 'is_featured',
                                        'value' => (bool) $programming->is_featured,
                                        'modelClass' => 'programming',
                                    ])
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    @if ($programming->creator)
                                        <a href="{{ route('dashboard.users.show', $programming->creator->id) }}" class="text-primary hover:underline">
                                            {{ $programming->creator->name }}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">N/A</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-600">{{ $programming->created_at?->format('d/m/Y') }}</td>
                                <td class="p-4 text-sm text-gray-600">{{ $programming->order ?? 0 }}</td>
                                <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                    @include('dashboard.components.permissions-actions', [
                                        'record' => $programming,
                                        'models' => 'programmings',
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

            @if ($programmings->hasPages())
                <div class="mt-6 border-t pt-4">
                    {{ $programmings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
