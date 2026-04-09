@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.ticket')]))
@section('page-title', '💼 ' . __('main.create_type', ['type' => __('main.ticket')]))

@push('styles')
    <link href="{{ asset('assets/dashboard/css/users.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dashboard/css/tickets.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dashboard/css/custom-select.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="shadow-lg radius-lg p-6">
        <form method="POST" action="{{ route('dashboard.tickets.store') ?? '#' }}" enctype="multipart/form-data">
            @csrf

            <div class="grid gap-6 lg:gap-8">
                <div class="ff-section ff-anim">
                    <div class="ff-s-icon"><i class="fas fa-ticket"></i></div>
                    <div class="ff-s-title">{{ __('main.basic_information') }}</div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 ff-grid">
                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="text" class="ff-input" id="name" name="name" placeholder=" " value="{{ old('name') }}" required>
                            <label class="ff-label" for="name">{{ __('main.contact_form_name') }} <span class="text-red-400">*</span></label>
                            <i class="fas fa-user ff-icon"></i>
                        </div>
                        @error('name')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="email" class="ff-input" id="email" name="email" placeholder=" " value="{{ old('email') }}" required>
                            <label class="ff-label" for="email">{{ __('main.contact_form_email') }} <span class="text-red-400">*</span></label>
                            <i class="fas fa-envelope ff-icon"></i>
                        </div>
                        @error('email')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="text" class="ff-input" id="phone" name="phone" placeholder=" " value="{{ old('phone') }}">
                            <label class="ff-label" for="phone">{{ __('main.contact_form_phone') }}</label>
                            <i class="fas fa-phone ff-icon"></i>
                        </div>
                        @error('phone')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="ff-section ff-anim">
                    <div class="ff-s-icon"><i class="fas fa-layer-group"></i></div>
                    <div class="ff-s-title">{{ __('main.ticket_details') }}</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="department_id" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.department') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="department_id" name="department_id" class="w-full basic-single rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                            <option value="" selected disabled>--</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ app()->getLocale() === 'ar' ? $dept->name_ar ?? $dept->name : $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ff-anim">
                        <label for="assigned_to" class="mb-2 block text-sm font-semibold text-gray-500">{{ __('main.assigned_to') }}</label>
                        <div class="ff-group">
                            <select id="assigned_to" name="assigned_to" class="ff-input basic-single" style="padding-block: 10px;">
                                <option value="" selected disabled>--</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to', $ticket->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('assigned_to')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="ff-anim">
                    <div class="ff-group">
                        <input type="text" id="subject" name="subject" class="ff-input" placeholder=" " value="{{ old('subject', $ticket->subject ?? '') }}" required>
                        <label class="ff-label" for="subject">{{ __('main.contact_form_subject') }} <span class="text-red-400">*</span></label>
                        <i class="fas fa-heading ff-icon"></i>
                    </div>
                    @error('subject')
                        <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="ff-anim">
                    <label for="message" class="mb-2 block text-sm font-semibold text-gray-500">{{ __('main.contact_form_message') }} <span class="text-red-400">*</span></label>
                    <textarea id="message" name="message" rows="5" required placeholder="{{ __('main.contact_form_message_placeholder') }}" class="ff-input" style="padding: 12px 16px;">{{ old('message', $ticket->message ?? '') }}</textarea>
                    @error('message')
                        <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" name="status" value="{{ old('status', 'open') }}">
                <input type="hidden" name="priority" value="{{ old('priority', 'medium') }}">

                <div class="ff-section ff-anim">
                    <div class="ff-s-icon"><i class="fas fa-shield-halved"></i></div>
                    <div class="ff-s-title">{{ __('main.verification') }}</div>
                </div>

                <div class="ff-anim">
                    <div class="question font-semibold mb-2">
                        {{ isset($a) && $a ? $a : '' }} + {{ isset($b) && $b ? $b : '' }} = ?
                    </div>
                    <div class="ff-group" style="max-width: 300px">
                        <input type="number" id="verification" name="verification" minlength="1" maxlength="9" value="{{ old('verification') }}" class="ff-input" placeholder=" ">
                        <label class="ff-label" for="verification">{{ __('main.contact_form_verification') }}</label>
                        <i class="fas fa-check-double ff-icon"></i>
                    </div>
                    @error('verification')
                        <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Save Submit --}}
                @include('dashboard.components.save-submit', ['models' => 'dashboard.tickets', 'model' => 'ticket'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const wrapper = document.getElementById('custom-dept-select-dashboard');
            if (!wrapper) return;

            const trigger = wrapper.querySelector('.dept-select-trigger');
            const dropdown = wrapper.querySelector('.dept-select-dropdown');
            const hiddenSel = wrapper.querySelector('.dept-hidden-select');
            const trigIcon = wrapper.querySelector('.dept-trigger-icon');
            const trigLabel = wrapper.querySelector('.dept-trigger-label');
            const options = wrapper.querySelectorAll('.dept-select-option');

            const preSelected = wrapper.querySelector('.dept-select-option.selected');
            if (preSelected && preSelected.dataset.value) {
                applySelection(preSelected);
            }

            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleDropdown();
            });
            trigger.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleDropdown();
                }
                if (e.key === 'Escape') closeDropdown();
            });

            options.forEach(function(opt) {
                opt.addEventListener('click', function(e) {
                    e.stopPropagation();
                    options.forEach(function(o) {
                        o.classList.remove('selected');
                        o.removeAttribute('aria-selected');
                    });

                    opt.classList.add('selected');
                    opt.setAttribute('aria-selected', 'true');
                    hiddenSel.value = opt.dataset.value;
                    applySelection(opt);
                    closeDropdown();
                });
            });

            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target)) closeDropdown();
            });

            function toggleDropdown() {
                wrapper.classList.toggle('open');
                trigger.setAttribute('aria-expanded', wrapper.classList.contains('open') ? 'true' : 'false');
            }

            function closeDropdown() {
                wrapper.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }

            function applySelection(opt) {
                const icon = opt.dataset.icon || 'fas fa-building';
                const color = opt.dataset.color || '';
                const label = opt.querySelector('span:last-child')?.textContent.trim() || '{{ __('main.select') . ' ' . __('main.department') }}';
                const isEmpty = !opt.dataset.value;

                trigIcon.innerHTML = `<i class="${icon}"></i>`;
                trigIcon.style.color = color || '';
                trigIcon.style.background = color ? color + '1a' : '';
                trigLabel.textContent = label;
                trigLabel.classList.toggle('has-value', !isEmpty);
            }
        })();
    </script>
@endpush
