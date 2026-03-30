@extends('layouts.master')

@section('content')
    <section class="contact-sections tickets-section" style="background-image: url('{{ \App\Helpers\CrossDeviceHelper::getSupportImage('logo') }}');">
        <div class="text">
            <div class="title font-semibold mb-4">{{ __('main.tickets_header') }}</div>
        </div>

        <div class="tickets-form">
            {{-- Ticket Inquiry --}}
            <h2>{{ __('main.tickets_title') }}</h2>

            <form action="{{ route('tickets.inquiry') }}" method="GET" class="group-tickets">
                @csrf
                <input type="hidden" name="t" value="{{ Str::random(240) }}">
                <div>
                    <label for="email" class="font-semibold">
                        {{ __('main.tickets_email') }}
                        <span class="text-red-600">*</span>
                    </label>

                    <div class="input flex">
                        <input type="text" name="email" id="email" placeholder="{{ __('main.inquiry_placeholder') }}" value="{{ old('email', request()->input('email')) }}">
                    </div>
                </div>

                <button class="btn-link light-main-color font-semibold mb-8">
                    {{ __('main.tickets_show') }}
                </button>
            </form>

            @if (request()->has('email'))
                <div class="scroll-container text-start">
                    <div class="p-4">
                        <p>{{ __('main.types_count', ['types' => __('main.tickets')]) }}: <span class="font-semibold">{{ $tickets->count() }}</span></p>
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="">
                                    <th class="text-start px-6 py-3 text-sm font-semibold text-gray-700">{{ __('main.number') }}</th>
                                    <th class="text-start px-6 py-3 text-sm font-semibold text-gray-700">{{ __('main.department') }}</th>
                                    <th class="text-start px-6 py-3 text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                                    <th class="text-start px-6 py-3 text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                    <th class="text-start px-6 py-3 text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets as $ticket)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td class="text-start p-4 text-sm text-gray-600">{{ $ticket->uuid }}</td>
                                        <td class="text-start p-4 text-sm text-gray-600">
                                            <span class="kt-badge text-white rounded-full" style="background-color: {{ $ticket->department['border_main_color'] ?? 'var(--main-color)' }};">
                                                {{ app()->getLocale() == 'ar' ? $ticket->department?->name_ar : $ticket->department?->name ?? 'no_department' }}
                                            </span>
                                        </td>
                                        <td class="text-start p-4 text-sm">
                                            <span class="kt-badge text-white {{ \App\Enum\TicketEnums::from($ticket->status)->badgeColor() }} rounded-full">
                                                {{ __('main.' . $ticket->status) }}
                                            </span>
                                        </td>
                                        <td class="text-start p-4 text-sm text-gray-600">{{ $ticket->created_at?->format('d/m/Y') }}</td>
                                        <td class="text-start p-4 text-sm space-x-2 flex items-center gap-2">
                                            <a href="{{ route('tickets.show', $ticket->uuid) }}" class="kt-btn kt-btn-sm kt-btn-outline m-0 bg-orange-500 text-white font-semibold">
                                                {{ __('main.open_') }}
                                            </a>
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
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
