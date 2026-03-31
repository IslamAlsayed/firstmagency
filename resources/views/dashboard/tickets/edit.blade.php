@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.ticket')]))
@section('page-title', '💼 ' . __('main.create_type', ['type' => __('main.ticket')]))

@push('styles')
    <link href="{{ asset('assets/dashboard/css/users.css') }}" rel="stylesheet" />
    <style>
        .shadow-lg.radius-lg,
        .shadow-lg.radius-lg form,
        .shadow-lg.radius-lg .grid,
        .shadow-lg.radius-lg .ff-group {
            overflow: visible !important;
        }

        .custom-dept-select {
            position: relative;
            width: 100%;
            flex: 1;
            min-width: 0;
        }

        .dept-select-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            cursor: pointer;
            width: 100%;
            min-height: 35px;
            user-select: none;
            border-radius: 8px;
            border: 1px solid transparent;
            background: color-mix(in srgb, var(--light-color, #fff) 96%, #000 4%);
            transition: background 0.15s, border-color 0.2s;
            flex-direction: row-reverse;
            text-align: right;
        }

        .dept-select-trigger:hover {
            background: color-mix(in srgb, var(--light-color, #fff) 92%, #000 8%);
        }

        .dept-trigger-icon {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
            background: color-mix(in srgb, var(--dark-color, #111) 8%, transparent);
            color: var(--button_color, #0074F7);
            transition: background 0.2s, color 0.2s;
        }

        .dept-trigger-label {
            flex: 1;
            font-size: 13px;
            color: color-mix(in srgb, var(--dark-color, #111) 45%, transparent);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: color 0.15s;
        }

        .dept-trigger-label.has-value {
            color: var(--dark-color, #111);
            font-weight: 500;
        }

        .dept-trigger-arrow {
            font-size: 10px;
            color: color-mix(in srgb, var(--dark-color, #111) 45%, transparent);
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }

        .custom-dept-select.open .dept-trigger-arrow {
            transform: rotate(180deg);
        }

        .dept-select-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: -5px;
            right: -5px;
            background-color: var(--light-color, #fff);
            border: 1px solid color-mix(in srgb, var(--dark-color, #111) 18%, transparent);
            border-radius: 12px;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.12);
            z-index: 9999;
            overflow: hidden;
            display: none;
            padding: 4px;
            max-height: 260px;
            overflow-y: auto;
            animation: deptDropIn 0.18s ease;
        }

        .custom-dept-select.open .dept-select-dropdown {
            display: block;
        }

        .dept-select-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            cursor: pointer;
            border-radius: 8px;
            transition: background 0.15s;
            font-size: 13px;
            justify-content: end;
            flex-direction: row-reverse;
        }

        .dept-select-option:hover {
            background-color: color-mix(in srgb, var(--button_color, #0074F7) 8%, transparent);
        }

        .dept-select-option.selected {
            font-weight: 600;
            background-color: color-mix(in srgb, var(--button_color, #0074F7) 12%, transparent);
        }

        .dept-opt-icon {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: color-mix(in srgb, var(--dark-color, #111) 8%, transparent);
            color: var(--button_color, #0074F7);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
            transition: background 0.2s;
        }

        .dept-hidden-select {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            pointer-events: none;
        }

        @keyframes deptDropIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.tickets.update', $ticket->id) ?? '#' }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:gap-8">
                <div class="ff-section ff-anim">
                    <div class="ff-s-icon"><i class="fas fa-ticket"></i></div>
                    <div class="ff-s-title">{{ __('main.basic_information') }}</div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 ff-grid">
                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="text" class="ff-input" id="name" name="name" placeholder=" " value="{{ old('name', $ticket->name) }}">
                            <label class="ff-label" for="name">{{ __('main.contact_form_name') }}</label>
                            <i class="fas fa-user ff-icon"></i>
                        </div>
                        @error('name')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="email" class="ff-input" id="email" name="email" placeholder=" " value="{{ old('email', $ticket->email) }}">
                            <label class="ff-label" for="email">{{ __('main.contact_form_email') }}</label>
                            <i class="fas fa-envelope ff-icon"></i>
                        </div>
                        @error('email')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="text" class="ff-input" id="phone" name="phone" placeholder=" " value="{{ old('phone', $ticket->phone) }}">
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
                    {{-- <div class="ff-anim">
                        <label for="department_id" class="mb-2 block text-sm font-semibold text-gray-500">{{ __('main.department') }}</label>
                        <div class="ff-group" style="overflow: visible;">
                            <div class="custom-dept-select" id="custom-dept-select-dashboard">
                                <div class="dept-select-trigger" tabindex="0" role="combobox" aria-haspopup="listbox" aria-expanded="false" aria-label="{{ __('main.department') }}">
                                    <span class="dept-trigger-icon"><i class="fas fa-building"></i></span>
                                    <span class="dept-trigger-label">{{ __('main.select') . ' ' . __('main.department') }}</span>
                                    <span class="dept-trigger-arrow"><i class="fas fa-chevron-down"></i></span>
                                </div>

                                <div class="dept-select-dropdown" role="listbox">
                                    <div class="dept-select-option" data-value="" data-icon="fas fa-building" data-color="" role="option">
                                        <span class="dept-opt-icon"><i class="fas fa-building"></i></span>
                                        <span>{{ __('main.select') . ' ' . __('main.department') }}</span>
                                    </div>

                                    @foreach ($departments as $dept)
                                        @php
                                            $translationKey = 'main.' . str_replace('-', '_', $dept->name);
                                            $translatedName = __($translationKey);
                                            $fallbackEnName = $translatedName !== $translationKey ? $translatedName : ucwords(str_replace(['-', '_'], ' ', $dept->name));
                                            $deptLabel = app()->getLocale() === 'ar' ? (data_get($dept, 'name_ar') ?: $fallbackEnName) : $fallbackEnName;
                                            $deptIcon = data_get($dept, 'icon', 'fas fa-building');
                                            $deptColor = data_get($dept, 'badge_color', '');
                                        @endphp
                                        <div class="dept-select-option {{ old('department_id') == $dept->id ? 'selected' : '' }}" data-value="{{ $dept->id }}" data-icon="{{ $deptIcon }}"
                                            data-color="{{ $deptColor }}" role="option" {{ old('department_id') == $dept->id ? 'aria-selected=true' : '' }}>
                                            <span class="dept-opt-icon" style="{{ $deptColor ? 'color:' . $deptColor . ';background:' . $deptColor . '1a' : '' }}">
                                                <i class="{{ $deptIcon }}"></i>
                                            </span>
                                            <span>{{ $deptLabel }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <select id="department_id" name="department_id" class="dept-hidden-select" aria-hidden="true" tabindex="-1">
                                    <option value=""></option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('department_id')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div>
                        <label for="department_id" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.department') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="department_id" name="department_id" class="w-full basic-single rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                            <option value="" selected disabled>--</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', $ticket->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
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
                            {{-- <i class="fas fa-user-check ff-icon"></i> --}}
                        </div>
                        @error('assigned_to')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="ff-anim">
                    <div class="ff-group">
                        <input type="text" id="subject" name="subject" class="ff-input" placeholder=" " value="{{ old('subject', $ticket->subject ?? '') }}">
                        <label class="ff-label" for="subject">{{ __('main.contact_form_subject') }}</label>
                        <i class="fas fa-heading ff-icon"></i>
                    </div>
                    @error('subject')
                        <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="ff-anim">
                    <label for="message" class="mb-2 block text-sm font-semibold text-gray-500">{{ __('main.contact_form_message') }}</label>
                    <textarea id="message" name="message" rows="5" placeholder="{{ __('main.contact_form_message_placeholder') }}" class="ff-input" style="padding: 12px 16px;">{{ old('message', $ticket->message ?? '') }}</textarea>
                    @error('message')
                        <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" name="status" value="{{ old('status', $ticket->status ?? 'open') }}">
                <input type="hidden" name="priority" value="{{ old('priority', $ticket->priority ?? 'medium') }}">

                {{-- Update Submit --}}
                @include('dashboard.components.update-submit', ['models' => 'dashboard.tickets', 'model' => 'ticket'])
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
