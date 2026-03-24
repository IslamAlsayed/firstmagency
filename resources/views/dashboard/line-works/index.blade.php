@extends('dashboard.layout.master')

@section('title', __('main.line_works'))
@section('page-title', '⚙️ ' . __('main.line_works'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ count($lineWorks) }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_line_works') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-active">{{ $lineWorks->where('is_active', true)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.active') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 shadow-lg radius-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600" id="stat-inactive">{{ $lineWorks->where('is_active', false)->count() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.inactive') }}</small>
            </div>
        </div>

        <div class="bg-white shadow-lg radius-lg">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-cogs mr-2"></i> {{ __('main.line_works') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_line_works_placeholder') }}">
                    <a href="{{ route('dashboard.line-works.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_line_work') }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.alt_text') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lineWorks as $lineWork)
                            <tr id="row-{{ $lineWork->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-active="{{ (int) $lineWork->is_active }}">
                                <td title="{{ $lineWork->alt_text ?? ($lineWork->translations[app()->getLocale()]['title'] ?? '') }}" class="p-4">
                                    <div class="relative w-fit">
                                        @if ($lineWork->image && checkExistFile($lineWork->image))
                                            <img src="{{ asset('storage/' . $lineWork->image) }}" alt="{{ $lineWork->alt_text ?? ($lineWork->translations[app()->getLocale()]['title'] ?? '') }}"
                                                class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                        @else
                                            <i class="fas fa-image text-2xl text-gray-400"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4" title="{{ $lineWork->alt_text ?? '--' }}">
                                    <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                        {{ limitedText($lineWork->alt_text ?? '--', 25) }}
                                    </span>
                                </td>
                                <td class="p-4" title="{{ $lineWork->translations[app()->getLocale()]['title'] ?? '--' }}">
                                    <span class="text-gray-600">
                                        {{ limitedText($lineWork->translations[app()->getLocale()]['title'] ?? '--', 35) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm">
                                    @include('dashboard.components.toggle-hold', [
                                        'modelId' => $lineWork->id,
                                        'field' => 'is_active',
                                        'value' => (bool) $lineWork->is_active,
                                        'modelClass' => 'line-work',
                                    ])
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    @if ($lineWork->creator)
                                        <a href="{{ route('dashboard.users.show', $lineWork->creator->id) }}" class="text-blue-600 hover:underline">
                                            {{ $lineWork->creator->name }}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">N/A</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-600">{{ $lineWork->created_at?->format('d/m/Y') }}</td>
                                <td class="p-4 text-sm text-gray-600">{{ $lineWork->order ?? 0 }}</td>
                                <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                    @include('dashboard.components.permissions-actions', [
                                        'record' => $lineWork,
                                        'models' => 'line-works',
                                        'modelClass' => 'line-work',
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

                @if ($lineWorks->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $lineWorks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
