@extends('dashboard.layout.master')

@section('title', __('main.reviews'))
@section('page-title', '⭐ ' . __('main.reviews'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ $reviews->total() }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.reviews') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-yellow-200">
                <div class="text-2xl font-bold text-yellow-600" id="stat-pending"> <i class="fas fa-clock text-yellow-500"></i> {{ $pendingCount }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.pending') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-green-200">
                <div class="text-2xl font-bold text-green-600" id="stat-approved"> <i class="fas fa-check-circle text-green-600"></i> {{ $approvedCount }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.approved') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-red-200">
                <div class="text-2xl font-bold text-red-600" id="stat-rejected"> <i class="fas fa-times-circle text-red-600"></i> {{ $rejectedCount }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.rejected') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800">⭐ {{ __('main.reviews') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.reviews')]) }}">
                    <a href="{{ route('dashboard.reviews.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_type', ['type' => __('main.review')]) }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <div class="p-4">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.name') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.country') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.rating') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.message') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr id="row-{{ $review->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-status="{{ $review->status }}">
                                    <td class="px-6 py-4 text-gray-800 font-medium">
                                        {{ limitedText($review->name, 25) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                            🌍 {{ $review->country }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $stars = '';
                                            for ($i = 0; $i < $review->rate; $i++) {
                                                $stars .= '⭐ ';
                                            }
                                        @endphp
                                        {!! $stars !!}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-sm" title="{{ $review->comment }}">
                                        {{ limitedText($review->comment, 40) }}
                                    </td>
                                    <td class="p-4 text-sm">
                                        @include('dashboard.components.status-actions', [
                                            'record' => $review,
                                            'models' => 'reviews',
                                            'modelClass' => 'review',
                                            'availableOptions' => array_column(\App\Enum\ReviewEnums::cases(), 'value'),
                                        ])
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if ($review->status === 'pending') bg-blue-100 text-blue-800
                                        @elseif($review->status === 'approved') bg-green-100 text-green-800
                                                @elseif($review->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                            {{ __('main.' . $review->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $review->created_at?->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-gray-600 text-sm">
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $review,
                                            'models' => 'reviews',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        <p>{{ __('messages.no_records_found') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($reviews->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
