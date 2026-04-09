<form action="{{ route('tickets.message', $ticketData['uuid']) }}" method="POST" enctype="multipart/form-data" class="tickets-message-form">
    @csrf
    @include('dashboard.components.input-text-editor', [
        'name' => 'your_reply',
        'value' => old('your_reply'),
        'height' => '150px',
    ])

    <div class="group mt-4">
        {{-- Optional Attachment --}}
        <label for="attachments" class="font-semibold mb-2 block">{{ __('main.contact_form_attachment') }}</label>
        <div class="attachments flex flex-col gap-4" id="attachments-container">
            <div class="input flex p-2 rounded-[9px]" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" data-message="{{ __('messages.no_file_chosen') }}"
                style="text-align: {{ app()->getLocale() == 'ar' ? 'end' : 'start' }} !important; border: 1px solid var(--dark-muted-color); @error('attachments') border: 1px solid red !important @enderror">
                <input type="file" id="attachments" name="attachments[]">
            </div>
        </div>

        <div class="add-attachment-input mt-2" id="add-attachment-btn" style="cursor: pointer;" toggle-button>
            {{ __('main.contact_form_add_attachment') }}
        </div>
    </div>

    <button class="submit btn-link light-main-color font-semibold" toggle-button>
        {{ __('main.send_reply') }}
    </button>
</form>
