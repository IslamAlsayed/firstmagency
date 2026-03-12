<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'messages' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'department' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'priority' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}
