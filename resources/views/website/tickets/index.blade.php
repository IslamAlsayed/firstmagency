@extends('layouts.master')

@section('title', __('main.tickets'))
@section('meta_title', __('main.tickets') . ' | ' . __('main.brand_name'))
@section('meta_description', __('main.contact_enter_data'))

@section('content')
    <section class="contact-sections relative" style="background-image: url('{{ \App\Helpers\CrossDeviceHelper::getSupportImage('logo') }}');">
        <div class="text">
            <div class="title font-semibold mb-4">{{ __('main.contact_form_header') }}</div>
            <button class="btn-link light-main-color dark-hover font-semibold mb-8">
                <a href="{{ route('tickets.inquiry') }}">{{ __('main.contact_ticket_inquiry') }}</a>
            </button>
        </div>

        <form action="{{ route('tickets.store') }}" method="POST" class="contact-form" enctype="multipart/form-data">
            @csrf
            <div class="text">
                <h2>{{ __('main.contact_register_ticket') }}</h2>
                <p>{{ __('main.contact_enter_data') }}</p>
            </div>

            <div class="groups">
                <div class="group flex items-center">
                    {{-- name --}}
                    <div>
                        <label for="name" class="font-semibold">
                            {{ __('main.contact_form_name') }}
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex" style="@error('name') border: 1px solid red @enderror">
                            <input type="text" id="name" name="name" required placeholder="{{ __('main.contact_form_name') }}" value="{{ old('name') }}"
                                aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/user.svg') }}" alt="{{ __('main.contact_form_name') }}">
                            </div>
                        </div>
                        @error('name')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- email --}}
                    <div>
                        <label for="email" class="font-semibold">
                            {{ __('main.contact_form_email') }}
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex" style="@error('email') border: 1px solid red @enderror">
                            <input type="email" id="email" name="email" required placeholder="{{ __('main.contact_form_email') }}" value="{{ old('email') }}"
                                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/email.svg') }}" alt="{{ __('main.contact_form_email') }}">
                            </div>
                        </div>
                        @error('email')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="group flex items-center">
                    {{-- phone --}}
                    <div>
                        <label for="phone" class="font-semibold">{{ __('main.contact_form_phone') }}</label>
                        <div class="input flex" style="@error('phone') border: 1px solid red @enderror">
                            <input type="text" id="phone" name="phone" placeholder="{{ __('main.contact_form_phone') }}" value="{{ old('phone') }}"
                                aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}">
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/phone.svg') }}" alt="{{ __('main.contact_form_phone') }}">
                            </div>
                        </div>
                        @error('phone')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Select Department --}}
                    <div>
                        <label for="department_id" class="font-semibold">
                            {{ __('main.contact_form_department') }}
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex" style="@error('department_id') border: 1px solid red @enderror; overflow: visible; position: relative;">
                            <div class="custom-dept-select" id="custom-dept-select" data-old="{{ old('department_id') }}">
                                {{-- Trigger button --}}
                                <div class="dept-select-trigger" tabindex="0" role="combobox" aria-haspopup="listbox" aria-expanded="false" aria-label="{{ __('main.contact_form_department') }}">
                                    <span class="dept-trigger-icon">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    <span class="dept-trigger-label">{{ __('main.department') }}</span>
                                    <span class="dept-trigger-arrow"><i class="fas fa-chevron-down"></i></span>
                                </div>

                                {{-- Options dropdown --}}
                                <div class="dept-select-dropdown" role="listbox">
                                    {{-- <div class="dept-select-option" data-value="" data-icon="fas fa-building" data-color="" role="option">
                                        <span class="dept-opt-icon"><i class="fas fa-building"></i></span>
                                        <span>{{ __('main.department') }}</span>
                                    </div> --}}

                                    @foreach ($departments as $dept)
                                        @php
                                            $translationKey = 'main.' . str_replace('-', '_', $dept->name);
                                            $translatedName = __($translationKey);
                                            $fallbackEnName = $translatedName !== $translationKey ? $translatedName : ucwords(str_replace(['-', '_'], ' ', $dept->name));

                                            $deptLabel = app()->getLocale() === 'ar' ? ($dept->name_ar ?: $fallbackEnName) : $fallbackEnName;

                                            $deptIcon = $dept->icon ?: 'fas fa-building';
                                            $deptColor = $dept->badge_color ?? '';
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

                                {{-- Hidden native select for form submission & server-side validation --}}
                                <select id="department_id" name="department_id" class="dept-hidden-select" aria-hidden="true" tabindex="-1">
                                    <option value=""></option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}></option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/pin.svg') }}" alt="{{ __('main.contact_form_department') }}">
                            </div>
                        </div>
                        @error('department_id')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="group flex items-center">
                    {{-- Message Subject --}}
                    <div>
                        <label for="subject" class="font-semibold">
                            {{ __('main.contact_form_subject') }}
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex" style="@error('subject') border: 1px solid red @enderror">
                            <input type="text" id="subject" name="subject" required placeholder="{{ __('main.contact_form_subject_placeholder') }}" value="{{ old('subject') }}"
                                aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}">
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/sheet.svg') }}" alt="{{ __('main.contact_form_subject') }}">
                            </div>
                        </div>
                        @error('subject')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="group flex items-center">
                    {{-- Message Content --}}
                    <div>
                        <label for="message" class="font-semibold">
                            {{ __('main.contact_form_message') }}
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex" style="@error('message') border: 1px solid red @enderror">
                            <textarea id="message" name="message" rows="5" required placeholder="{{ __('main.contact_form_message_placeholder') }}" aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}">{{ old('message') }}</textarea>
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/message.svg') }}" alt="{{ __('main.contact_form_message') }}">
                            </div>
                        </div>
                        @error('message')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="group">
                    {{-- Optional Attachment --}}
                    <label for="attachments" class="font-semibold mb-2 block">{{ __('main.contact_form_attachment') }}</label>
                    <div class="attachments flex flex-col gap-4" id="attachments-container">
                        <div class="input flex" style="@error('attachments') border: 1px solid red @enderror" data-message="{{ __('messages.no_file_chosen') }}">
                            <input type="file" id="attachments" name="attachments[]">
                        </div>
                        @error('attachments')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="add-attachment-input" id="add-attachment-btn" style="cursor: pointer;" toggle-button>
                        {{ __('main.contact_form_add_attachment') }}
                    </div>
                </div>

                <div class="group">
                    {{-- Verification --}}
                    <label for="verification" class="font-semibold block mb-2">{{ __('main.contact_form_verification') }}</label>
                    <div class="verification">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex inter gap-4">
                                <div class="rotate cursor-pointer regenerateVerify"><i class="fas fa-arrow-rotate-right"></i></div>
                                <div class="input flex items-center" style="@error('verification') border: 1px solid red @enderror" data-message="{{ __('messages.no_file_chosen') }}">
                                    <input type="number" id="verification" name="verification" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
                                        style="text-align: {{ app()->getLocale() == 'ar' ? 'end' : 'start' }} !important" placeholder="{{ __('main.contact_form_answer') }}"
                                        value="{{ old('verification') }}" aria-invalid="{{ $errors->has('verification') ? 'true' : 'false' }}">
                                </div>
                            </div>
                            <div class="question font-semibold">
                                {{ __('main.contact_form_verification_text') }} ? = {{ isset($a) && $a ? $a : '' }} + {{ isset($b) && $b ? $b : '' }}
                            </div>
                        </div>
                    </div>
                    @error('verification')
                        <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="ticket-submit btn-link light-main-color font-semibold" data-default-text="{{ __('main.submit') }}" data-loading-text="{{ __('main.contact_sending') }}">
                    <span class="ticket-submit-text">{{ __('main.submit') }}</span>
                </button>
            </div>
        </form>

        @if (isDebugModeEnabled())
            <div class="debug-flag-badge">🚩 flag-tickets</div>
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            header.setAttribute('data-force-scrolled', 'true');
            header.classList.add('scrolled');
        });
    </script>

    <script>
        document.getElementById('add-attachment-btn')?.addEventListener('click', function() {
            const container = document.getElementById('attachments-container');

            for (let i = 0; i < 2; i++) {
                const div = document.createElement('div');
                div.className = 'input flex';
                div.innerHTML = '<input type="file" name="attachments[]">';
                container.appendChild(div);
            }
        });

        // Handle verification rotation
        document.querySelector('.regenerateVerify')?.addEventListener('click', function(e) {
            e.preventDefault();
            const rotateBtn = this.querySelector('.fa-arrow-rotate-right');

            // Add rotation animation
            rotateBtn.style.transform = 'rotate(1turn)';
            rotateBtn.style.transition = 'transform 0.5s ease-in-out';

            fetch('{{ route('tickets.generate-verification') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the question text
                        const questionDiv = document.querySelector('.question');
                        questionDiv.textContent = `{{ __('main.contact_form_verification_text') }} ? = ${data.a} + ${data.b}`;

                        // Reset rotation for next click
                        setTimeout(() => rotateBtn.style.transform = 'rotate(0deg)', 100);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    rotateBtn.style.transform = 'rotate(0deg)';
                });
        });

        // Submit loading state for better UX
        const ticketForm = document.querySelector('.contact-form');
        ticketForm?.addEventListener('submit', function() {
            const submitBtn = ticketForm.querySelector('.ticket-submit');
            const textNode = ticketForm.querySelector('.ticket-submit-text');

            if (!submitBtn || !textNode) return;

            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'not-allowed';
            textNode.textContent = submitBtn.dataset.loadingText || textNode.textContent;
        });

        // ── Custom Department Select ──────────────────────────────
        (function() {
            const wrapper = document.getElementById('custom-dept-select');
            if (!wrapper) return;

            const trigger = wrapper.querySelector('.dept-select-trigger');
            const dropdown = wrapper.querySelector('.dept-select-dropdown');
            const hiddenSel = wrapper.querySelector('.dept-hidden-select');
            const trigIcon = wrapper.querySelector('.dept-trigger-icon');
            const trigLabel = wrapper.querySelector('.dept-trigger-label');
            const options = wrapper.querySelectorAll('.dept-select-option');

            // Restore a previously-selected option (after a validation failure)
            const preSelected = wrapper.querySelector('.dept-select-option.selected');
            if (preSelected && preSelected.dataset.value) {
                applySelection(preSelected, false);
            }

            // Toggle open/close on trigger click
            trigger.addEventListener('click', toggleDropdown);
            trigger.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleDropdown();
                }
                if (e.key === 'Escape') closeDropdown();
            });

            // Select an option
            options.forEach(function(opt) {
                opt.addEventListener('click', function() {
                    options.forEach(o => {
                        o.classList.remove('selected');
                        o.removeAttribute('aria-selected');
                    });
                    opt.classList.add('selected');
                    opt.setAttribute('aria-selected', 'true');
                    hiddenSel.value = opt.dataset.value;
                    applySelection(opt, true);
                    closeDropdown();
                });
            });

            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target)) closeDropdown();
            });

            function toggleDropdown() {
                wrapper.classList.toggle('open');
                trigger.setAttribute('aria-expanded', wrapper.classList.contains('open'));
            }

            function closeDropdown() {
                wrapper.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }

            function applySelection(opt, animate) {
                const icon = opt.dataset.icon || 'fas fa-building';
                const color = opt.dataset.color || '';
                const label = opt.querySelector('span:last-child')?.textContent.trim() ?? '';
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
