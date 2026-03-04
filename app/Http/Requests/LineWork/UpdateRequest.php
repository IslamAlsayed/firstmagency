<?php

namespace App\Http\Requests\LineWork;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'title_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'alt_text' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title_en.required' => __('validation.required', ['attribute' => __('main.title') . ' (' . __('main.english') . ')']),
            'title_ar.required' => __('validation.required', ['attribute' => __('main.title') . ' (' . __('main.arabic') . ')']),
            'description_en.required' => __('validation.required', ['attribute' => __('main.description') . ' (' . __('main.english') . ')']),
            'description_ar.required' => __('validation.required', ['attribute' => __('main.description') . ' (' . __('main.arabic') . ')']),
        ];
    }
}
