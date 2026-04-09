<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'your_reply' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'your_reply.required' => __('messages.validation_required', ['attribute' => __('main.message')]),
            'your_reply.min' => __('messages.validation_min', ['attribute' => __('main.message'), 'min' => 5]),
            'attachments.array' => __('messages.validation_array', ['attribute' => __('main.attachments')]),
            'attachments.*.file' => __('messages.validation_file', ['attribute' => __('main.attachments')]),
            'attachments.*.mimes' => __('messages.validation_mimes', ['attribute' => __('main.attachments'), 'values' => 'jpeg, png, jpg, gif, webp, pdf, doc, docx']),
            'attachments.*.max' => __('messages.validation_max_file_size', ['attribute' => __('main.attachments'), 'max' => 5120]),
        ];
    }
}
