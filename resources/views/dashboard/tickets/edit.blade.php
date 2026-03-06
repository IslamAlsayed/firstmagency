@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.ticket')]))
@section('page-title', '✏️ ' . __('main.edit_type', ['type' => __('main.ticket')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.edit_type', ['type' => __('main.ticket')]) }}</h3>

            <a href="{{ route('dashboard.tickets.index') }}" class="kt-btn kt-btn-outline-primary">
                {{ __('main.back_to_types', ['types' => __('main.tickets')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.tickets.update', $ticket->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gap-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="name" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ __('main.contact_form_name') }}
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $ticket->name) }}"
                                class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ __('main.contact_form_email') }}
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $ticket->email) }}"
                                class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>

                        <div>
                            <label for="phone" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ __('main.contact_form_phone') }}
                            </label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $ticket->phone) }}"
                                class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ __('main.contact_form_department') }}
                            </label>
                            <select id="category" name="category"
                                class="w-full basic-single rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                                <option value="">{{ __('main.contact_form_department_choose') }}</option>
                                <option value="sales" {{ old('category', $ticket->category ?? '') === 'sales' ? 'selected' : '' }}>
                                    {{ __('main.contact_form_department_sales') }}
                                </option>
                                <option value="support" {{ old('category', $ticket->category ?? '') === 'support' ? 'selected' : '' }}>
                                    {{ __('main.contact_form_department_support') }}
                                </option>
                                <option value="general" {{ old('category', $ticket->category ?? '') === 'general' ? 'selected' : '' }}>
                                    {{ __('main.contact_form_department_general') }}
                                </option>
                            </select>
                            @error('category')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="assigned_to" class="mb-2 block text-sm font-semibold text-gray-700">{{ __('main.assigned_to') }}</label>
                            <select id="assigned_to" name="assigned_to"
                                class="w-full basic-single rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('assigned_to') border-red-500 @enderror">
                                <option value="">{{ __('main.select_user') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to', $ticket->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.contact_form_subject') }}
                        </label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject', $ticket->subject ?? '') }}"
                            placeholder="{{ __('main.contact_form_subject_placeholder') }}"
                            class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('subject') border-red-500 @enderror">
                        @error('subject')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.contact_form_message') }}
                        </label>
                        <textarea id="message" name="message" rows="5" placeholder="{{ __('main.contact_form_message_placeholder') }}"
                            class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('message') border-red-500 @enderror">{{ old('message', $ticket->message ?? '') }}</textarea>
                        @error('message')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" name="status" value="{{ old('status', $ticket->status ?? 'open') }}">
                    <input type="hidden" name="priority" value="{{ old('priority', $ticket->priority ?? 'medium') }}">

                    @include('dashboard.components.upload-file', ['column' => 'attachments', 'record' => $ticket])

                    <!-- Update Button -->
                    @include('dashboard.components.update-submit', ['models' => 'dashboard.tickets', 'model' => 'ticket'])
                </div>
            </form>
        </div>
    </div>
@endsection
