<?php

namespace App\Http\Requests\Department;

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
            'name_ar' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'bg_color' => 'nullable|string|max:7',
            'border_color' => 'nullable|string|max:7',
            'border_main_color' => 'nullable|string|max:7',
            'badge_color' => 'nullable|string|max:7',
            'user_id' => 'nullable|integer|exists:users,id',
        ];
    }
}
