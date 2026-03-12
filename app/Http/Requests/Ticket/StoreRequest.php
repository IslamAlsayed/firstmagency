<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'department' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'priority' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
            'verification' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != session('ticket_verification')) {
                        $fail(__('messages.verification_incorrect'));
                    }
                }
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('messages.validation_required', ['attribute' => __('main.name')]),
            'email.required' => __('messages.validation_required', ['attribute' => __('main.email')]),
            'email.email' => __('messages.validation_email', ['attribute' => __('main.email')]),
            'subject.required' => __('messages.validation_required', ['attribute' => __('main.subject')]),
            'message.required' => __('messages.validation_required', ['attribute' => __('main.message')]),
            'attachments.array' => __('messages.validation_array', ['attribute' => __('main.attachments')]),
            'attachments.*.image' => __('messages.validation_image', ['attribute' => __('main.attachments')]),
            'attachments.*.mimes' => __('messages.validation_mimes', ['attribute' => __('main.attachments'), 'values' => 'jpeg, png, jpg, gif, webp']),
            'attachments.*.max' => __('messages.validation_max_file_size', ['attribute' => __('main.attachments'), 'max' => 2048]),
        ];
    }
}