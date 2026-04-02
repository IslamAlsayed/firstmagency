<?php

namespace App\Http\Requests\Api\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'subject'       => ['required', 'string', 'max:255'],
            'message'       => ['required', 'string'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'priority'      => ['nullable', 'string', 'max:50'],
            'attachments'   => ['nullable', 'array'],
            'attachments.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            // NOTE: NO "verification" rule — that's session-based CAPTCHA (web only)
        ];
    }
}
