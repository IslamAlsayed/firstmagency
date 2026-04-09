<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageRequest extends FormRequest
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
            'message' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'message.required' => __('messages.validation_required', ['attribute' => __('main.message')]),
            'message.min' => __('messages.validation_min', ['attribute' => __('main.message'), 'min' => 5]),
        ];
    }
}
