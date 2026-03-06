@extends('layouts.master')

@section('content')
    <section class="contact-sections relative">
        <div class="text">
            <div class="title font-semibold mb-4">{{ __('main.contact_form_header') }}</div>
            <button class="btn-link light-main-color dark-hover font-semibold mb-8">
                <a href="{{ route('tickets') }}">{{ __('main.contact_ticket_inquiry') }}</a>
            </button>
        </div>

        <div class="contact-form">
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
                        <div class="input flex">
                            <input type="text" id="name" placeholder="{{ __('main.contact_form_name') }}">
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
                        <div class="input flex">
                            <input type="email" id="email" placeholder="{{ __('main.contact_form_email') }}">
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
                        <div class="input flex">
                            <input type="text" id="phone" placeholder="{{ __('main.contact_form_phone') }}">
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
                        <div class="input flex">
                            <select id="department">
                                <option value="">{{ __('main.contact_form_department_choose') }}</option>
                                <option value="sales">{{ __('main.contact_form_department_sales') }}</option>
                                <option value="support">{{ __('main.contact_form_department_support') }}</option>
                                <option value="general">{{ __('main.contact_form_department_general') }}</option>
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
                        <div class="input flex">
                            <input type="text" id="subject" placeholder="{{ __('main.contact_form_subject_placeholder') }}">
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
                        <div class="input flex">
                            <textarea id="message" rows="5" placeholder="{{ __('main.contact_form_message_placeholder') }}"></textarea>
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/icons/message.svg') }}" alt="{{ __('main.contact_form_message') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group">
                    {{-- Optional Attachment --}}
                    <label for="attachment" class="font-semibold mb-2 block">{{ __('main.contact_form_attachment') }}</label>
                    <div class="attachments flex flex-col gap-4" id="attachments-container">
                        <div class="input flex">
                            <input type="file" id="attachment">
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
                                <button class="rotate"><i class="fas fa-arrow-rotate-right"></i></button>
                                <div class="input flex items-center">
                                    <input type="text" id="verification" placeholder="{{ __('main.contact_form_answer') }}">
                                </div>
                            </div>
                            <div class="question font-semibold">
                                {{ __('main.contact_form_verification_text') }}{{ rand(1, 9) }} + {{ rand(1, 9) }} = ?
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
        document.getElementById('add-attachment-btn').addEventListener('click', function() {
            const container = document.getElementById('attachments-container');

            for (let i = 0; i < 2; i++) {
                const div = document.createElement('div');
                div.className = 'input flex';
                div.innerHTML = '<input type="file">';
                container.appendChild(div);
            }
        });
    </script>
@endpush
