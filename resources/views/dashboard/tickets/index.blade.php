@extends('dashboard.layout.master')

@section('title', __('main.tickets'))
@section('page-title', '🎫 ' . __('main.tickets'))

@section('content')
    <div class="w-full">
        <!-- Statistics -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800">{{ count($tickets) }}</div>
                <small class="text-primary font-semibold">{{ __('main.total_types', ['types' => __('main.tickets')]) }}</small>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-blue-600">{{ $tickets->where('status', 'open')->count() }}</div>
                <small class="text-primary font-semibold">{{ __('main.open') }}</small>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-yellow-600">{{ $tickets->where('status', 'in_progress')->count() }}</div>
                <small class="text-primary font-semibold">{{ __('main.in_progress') }}</small>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600">{{ $tickets->where('priority', 'urgent')->count() }}</div>
                <small class="text-primary font-semibold">{{ __('main.urgent') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-b border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-ticket-alt mr-2"></i> {{ __('main.tickets') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox"
                        class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.tickets')]) }}">
                    <a href="{{ route('dashboard.tickets.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_type', ['type' => __('main.ticket')]) }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <div class="p-4">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.attachments') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.name') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.phone') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.subject') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.priority') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.category') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.assigned_to') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td
                                        title="{{ __('main.attachments') }} - {{ __('main.total_images') }}: {{ $ticket->attachments ? count($ticket->attachments) : 0 }}">
                                        <div class="relative w-fit">
                                            <div class="flex items-center -space-x-2">
                                                @if ($ticket->attachments && count($ticket->attachments) > 0)
                                                    @foreach ($ticket->attachments as $key => $image)
                                                        @if ($key >= 5)
                                                            @break
                                                        @endif
                                                        <img src="{{ $image && checkExistFile($image) ? asset('storage/' . $image) : asset('metronic/media/avatars/blank.png') }}"
                                                            alt="{{ $image }}"
                                                            class="hover:z-5 relative shrink-0 rounded-full ring-1 ring-background size-10">
                                                    @endforeach
                                                    @if (count($ticket->attachments) > 5)
                                                        <div
                                                            class="h-fit inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                                                            +{{ count($ticket->attachments) - 5 }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <div
                                                        class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                                                        <i class="opacity-25">{{ __('main.null') }}</i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        <p>{{ $ticket->name }}</p>
                                        <a href="mailto:{{ $ticket->email }}" target="_blank"
                                            class="inline-block text-primary hover:underline text-xs font-medium">
                                            {!! limitedText($ticket->email ?? '--', 30) !!}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                        </a>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        <a href="tel:{{ $ticket->phone }}" target="_blank" class="inline-block text-primary hover:underline text-xs font-medium">
                                            {!! limitedText($ticket->phone ?? '--', 30) !!}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                        </a>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ limitedText($ticket->subject ?? '', 30) }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $ticket->priority ?? '-' }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $ticket->category ?? '-' }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $ticket->assignedTo->name ?? '-' }}</td>
                                    <td class="p-4 text-sm text-gray-600">{{ $ticket->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.tickets-status-actions', [
                                            'record' => $ticket,
                                        ])
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $ticket,
                                            'models' => 'tickets',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                        {{ __('main.no_tickets_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($tickets->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
