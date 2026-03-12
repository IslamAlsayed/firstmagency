@extends('layouts.master')

@section('content')
    <section class="contact-sections relative">
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
                            <input type="text" id="name" name="name" required placeholder="{{ __('main.contact_form_name') }}"
                                value="{{ old('name') }}">
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/user.svg') }}" alt="{{ __('main.contact_form_name') }}">
                            </div>
                        </div>
                    </div>
                    {{-- email --}}
                    <div>
                        <label for="email" class="font-semibold">
                            {{ __('main.contact_form_email') }}
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex" style="@error('email') border: 1px solid red @enderror">
                            <input type="email" id="email" name="email" required placeholder="{{ __('main.contact_form_email') }}"
                                value="{{ old('email') }}">
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/email.svg') }}" alt="{{ __('main.contact_form_email') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group flex items-center">
                    {{-- phone --}}
                    <div>
                        <label for="phone" class="font-semibold">{{ __('main.contact_form_phone') }}</label>
                        <div class="input flex" style="@error('phone') border: 1px solid red @enderror">
                            <input type="text" id="phone" name="phone" placeholder="{{ __('main.contact_form_phone') }}" value="{{ old('phone') }}">
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/phone.svg') }}" alt="{{ __('main.contact_form_phone') }}">
                            </div>
                        </div>
                    </div>
                    {{-- Select Department --}}
                    <div>
                        <label for="department" class="font-semibold">
                            {{ __('main.contact_form_department') }}
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex" style="@error('department') border: 1px solid red @enderror">
                            <select id="department" name="department">
                                <option value="" {{ old('department') == '' ? 'selected' : '' }}>{{ __('main.contact_form_department_choose') }}</option>
                                <option value="sales" {{ old('department') == 'sales' ? 'selected' : '' }}>{{ __('main.contact_form_department_sales') }}
                                </option>
                                <option value="support" {{ old('department') == 'support' ? 'selected' : '' }}>{{ __('main.contact_form_department_support') }}
                                </option>
                                <option value="general" {{ old('department') == 'general' ? 'selected' : '' }}>{{ __('main.contact_form_department_general') }}
                                </option>
                            </select>
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/pin.svg') }}" alt="{{ __('main.contact_form_department') }}">
                            </div>
                        </div>
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
                            <input type="text" id="subject" name="subject" required placeholder="{{ __('main.contact_form_subject_placeholder') }}"
                                value="{{ old('subject') }}">
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/sheet.svg') }}" alt="{{ __('main.contact_form_subject') }}">
                            </div>
                        </div>
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
                            <textarea id="message" name="message" rows="5" required placeholder="{{ __('main.contact_form_message_placeholder') }}">{{ old('message') }}</textarea>
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/message.svg') }}" alt="{{ __('main.contact_form_message') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group">
                    {{-- Optional Attachment --}}
                    <label for="attachments" class="font-semibold mb-2 block">{{ __('main.contact_form_attachment') }}</label>
                    <div class="attachments flex flex-col gap-4" id="attachments-container">
                        <div class="input flex" style="@error('attachments') border: 1px solid red @enderror">
                            <input type="file" id="attachments" name="attachments[]">
                        </div>
                    </div>

                    <div class="add-attachment-input" id="add-attachment-btn" style="cursor: pointer;">
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
                                <div class="input flex items-center" style="@error('verification') border: 1px solid red @enderror"
                                    data-message="{{ __('messages.no_file_chosen') }}">
                                    <input type="number" id="verification" name="verification" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
                                        style="text-align: {{ app()->getLocale() == 'ar' ? 'end' : 'start' }} !important"
                                        placeholder="{{ __('main.contact_form_answer') }}" value="{{ old('verification') }}">
                                </div>
                            </div>
                            <div class="question font-semibold">
                                {{ __('main.contact_form_verification_text') }} ? = {{ isset($a) && $a ? $a : '' }} + {{ isset($b) && $b ? $b : '' }}
                            </div>
                        </div>
                    </div>
                </div>

                <button class="ticket-submit btn-link light-main-color font-semibold">
                    {{ __('main.submit') }}
                </button>
            </div>
        </form>

        @if (isDebugModeEnabled())
            <div class="debug-flag-badge">🚩 flag-contact</div>
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
    </script>
@endpush
