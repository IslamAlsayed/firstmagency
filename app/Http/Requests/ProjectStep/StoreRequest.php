<?php

namespace App\Http\Requests\ProjectStep;

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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // Arabic Translations (Primary Language)
            'title_ar' => 'required|string|max:255',
            'content_ar' => 'nullable|string',

            // English Translations
            'title_en' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',

            'icon' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
        ];
    }
}
