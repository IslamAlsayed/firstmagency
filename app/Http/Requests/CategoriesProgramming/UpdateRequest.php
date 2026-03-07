<?php

namespace App\Http\Requests\CategoriesProgramming;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'alt_text' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => __('main.image') . ' ' . __('main.must_be_image'),
            'image.mimes' => __('main.image') . ' ' . __('main.allowed_formats'),
            'image.max' => __('main.image') . ' ' . __('main.max_size_5mb'),
            'alt_text.max' => __('main.alt_text') . ' ' . __('main.max_255_characters'),
            'order.integer' => __('main.order') . ' ' . __('main.must_be_number'),
        ];
    }
}
