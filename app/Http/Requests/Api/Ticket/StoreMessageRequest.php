<?php

namespace App\Http\Requests\Api\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token'         => ['required', 'string'],
            'your_reply'    => ['required', 'string', 'min:5'],
            'attachments'   => ['nullable', 'array'],
            'attachments.*' => ['file', 'mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx', 'max:5120'],
        ];
    }
}
