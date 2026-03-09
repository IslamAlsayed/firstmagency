@extends('dashboard.layout.master')

@section('title', __('main.ticket_details'))
@section('page-title', '🎫 ' . limitedText($ticket->subject, 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $ticket->subject ?? __('main.ticket_details') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $ticket->user?->name ?? '-' }} • {{ $ticket->created_at?->format('d M Y') }}
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                @can('update', $ticket)
                    <a href="{{ route('dashboard.tickets.edit', $ticket->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.tickets.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tickets')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Ticket Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.ticket_information') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.name') }}</p>
                            <p class="font-semibold text-gray-800">{{ $ticket->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.email') }}</p>
                            <p class="font-semibold text-gray-800">
                                <a href="mailto:{{ $ticket->email }}" target="_blank" class="inline-block text-primary hover:underline text-xs font-medium">
                                    {!! limitedText($ticket->email ?? '--', 30) !!}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                </a>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.phone') }}</p>
                            <p class="font-semibold text-gray-800">
                                <a href="tel:{{ $ticket->phone }}" target="_blank" class="inline-block text-primary hover:underline text-xs font-medium">
                                    {!! limitedText($ticket->phone ?? '--', 30) !!}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                </a>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ __('main.status') }}
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                @if ($ticket->status === 'open') bg-green-100 text-green-800
                                @elseif($ticket->status === 'in_progress') bg-yellow-100 text-yellow-800
                                @elseif($ticket->status === 'resolved') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                    @if ($ticket->status === 'open')
                                        <i class="fas fa-clock text-yellow-500"></i> {{ __('main.open') }}
                                    @elseif ($ticket->status === 'in_progress')
                                        <i class="fas fa-spinner text-blue-600"></i> {{ __('main.in_progress') }}
                                    @elseif ($ticket->status === 'resolved')
                                        <i class="fas fa-check-circle text-green-600"></i> {{ __('main.resolved') }}
                                    @elseif ($ticket->status === 'closed')
                                        <i class="fas fa-times-circle text-red-600"></i> {{ __('main.closed') }}
                                    @endif
                                </span>
                            </p>
                            @include('dashboard.components.tickets-status-actions', [
                                'record' => $ticket,
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">{{ __('main.priority') }}</p>
                            <p class="text-sm text-secondary-foreground">
                                <span
                                    class="px-3 py-1 rounded-full font-semibold
                                    @if ($ticket->priority === 'low') bg-gray-100 text-gray-800
                                    @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @elseif($ticket->priority === 'high') bg-orange-100 text-orange-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ __('main.' . $ticket->priority) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.category') }}</p>
                            <p class="font-semibold text-gray-800">{{ $ticket->category ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.assigned_to') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($ticket->assignedTo)
                                    <a href="{{ route('dashboard.users.show', $ticket->assignedTo->id) }}" class="text-primary hover:underline">
                                        {{ $ticket->assignedTo->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($ticket->user)
                                    <a href="{{ route('dashboard.users.show', $ticket->user->id) }}" class="text-primary hover:underline">
                                        {{ $ticket->user->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="text-sm text-gray-800">{{ $ticket->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.updated_at') }}</p>
                            <p class="text-sm text-gray-800">{{ $ticket->updated_at?->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Message Content --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.message') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200 whitespace-pre-line">
                        {{ $ticket->message ?? '-' }}
                    </div>
                </div>
            </div>

            <!-- Media Files -->
            @include('dashboard.components.display-files', ['column' => 'attachments', 'record' => $ticket])

            {{-- Action Buttons --}}
            <div class="flex items-center gap-4">
                @can('update', $ticket)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.tickets',
                        'id' => $ticket->id,
                    ])
                @endcan
                @can('delete', $ticket)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.tickets',
                        'modelClass' => 'ticket',
                        'id' => $ticket->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.tickets.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tickets')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
