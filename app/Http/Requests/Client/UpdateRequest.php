<?php

namespace App\Http\Requests\Client;

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
            'name_ar' => ['nullable', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,webp', 'max:5120'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => __('validation.required', ['attribute' => __('main.name') . ' - ' . __('main.arabic')]),
            'name_en.required' => __('validation.required', ['attribute' => __('main.name') . ' - ' . __('main.english')]),
            'image.image' => __('validation.image'),
            'image.max' => __('validation.max.file'),
            'website.url' => __('validation.url'),
        ];
    }
}
