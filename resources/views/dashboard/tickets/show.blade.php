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
                    {{ $ticket->department?->name ?? '-' }} • {{ $ticket->created_at?->format('d M Y') }}
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                @can('update', $ticket)
                    <a href="{{ route('dashboard.tickets.edit', $ticket->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.tickets.support-reply', ['ticketId' => $ticket->id]) }}" class="kt-btn kt-btn-outline-primary">
                    {{ __('main.chat') }}
                </a>
                <a href="{{ route('dashboard.tickets.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tickets')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4">
            {{-- Ticket Information --}}
            <div class="kt-card ">
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
                                <a href="mailto:{{ $ticket->email }}" target="_blank" class="inline-block text-blue-600 hover:underline text-xs font-medium">
                                    {!! limitedText($ticket->email ?? '--', 30) !!}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                </a>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.phone') }}</p>
                            <p class="font-semibold text-gray-800">
                                <a href="tel:{{ $ticket->phone }}" target="_blank" class="inline-block text-blue-600 hover:underline text-xs font-medium">
                                    {!! limitedText($ticket->phone ?? '--', 30) !!}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                </a>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ __('main.status') }}
                            </p>
                            <div class="flex gap-2">
                                @include('dashboard.components.status-actions', [
                                    'record' => $ticket,
                                    'models' => 'tickets',
                                    'modelClass' => 'ticket',
                                    'availableOptions' => array_column(\App\Enum\TicketEnums::cases(), 'value'),
                                ])
                                <span class="kt-badge text-white {{ \App\Enum\TicketEnums::from($ticket->status)->badgeColor() }}">
                                    {{ __('main.' . $ticket->status) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">{{ __('main.priority') }}</p>
                            <p class="text-sm text-secondary-foreground">
                                <span
                                    class="kt-badge font-semibold
                                    @if ($ticket->priority === 'low') bg-gray-100 text-gray-800
                                    @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @elseif($ticket->priority === 'high') bg-orange-100 text-orange-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ __('main.' . $ticket->priority) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ __('main.department') }}
                            </p>
                            <div class="flex gap-2">
                                @include('dashboard.components.department-actions', [
                                    'record' => $ticket,
                                    'models' => 'tickets',
                                    'modelClass' => 'ticket',
                                    'availableOptions' => $departments->pluck('name', 'id')->toArray(),
                                ])
                                <span class="kt-badge text-white" style="background-color: {{ $ticket->department?->border_main_color ?? 'default' }};">
                                    {{ __('main.' . str_replace('-', '_', str_replace(' ', '_', $ticket->department?->name ?? 'no_department'))) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Files from Messages -->
            @if ($ticket->messages && count($ticket->messages) > 0)
                @php
                    $allAttachments = [];
                    foreach ($ticket->messages as $message) {
                        if (is_array($message->attachments) && count($message->attachments) > 0) {
                            $allAttachments = array_merge($allAttachments, $message->attachments);
                        }
                    }
                @endphp

                @if (count($allAttachments) > 0)
                    <div class="kt-card ">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">{{ __('main.attachments') }} <span class="font-semibold text-primary">({{ count($allAttachments) ?? 0 }})</span></h3>
                        </div>
                        <div class="kt-card-body p-4">
                            <div class="flex flex-col gap-6">
                                @if ($allAttachments && count($allAttachments) > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @foreach ($allAttachments as $index => $file)
                                            <div class="image-container shadow-sm">
                                                @if ($file)
                                                    <img src="{{ asset('storage/' . $file) }}" alt="{{ __('main.attachments') }} {{ $index + 1 }}" class="w-full h-32 object-cover" loading="lazy">
                                                @else
                                                    <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                                        <p class="text-xs text-secondary-foreground">{{ __('main.na') }}</p>
                                                    </div>
                                                @endif
                                                <div class="image-overlay">
                                                    <a href="{{ $file ? asset('storage/' . $file) : '#' }}" download="{{ $file }}" class="kt-btn kt-btn-sm kt-btn-primary">
                                                        <i class="fas fa-download text-sm me-1"></i>
                                                        <span>{{ __('main.download') }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $ticket])

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

{{-- @push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush --}}
