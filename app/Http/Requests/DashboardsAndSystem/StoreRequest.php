<?php

namespace App\Http\Requests\DashboardsAndSystem;

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
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'title_ar.required' => __('validation.required', ['attribute' => __('main.ar_title')]),
            'title_en.required' => __('validation.required', ['attribute' => __('main.en_title')]),
            'image.image' => __('validation.image', ['attribute' => __('main.image')]),
            'image.mimes' => __('validation.mimes', ['attribute' => __('main.image')]),
            'image.max' => __('validation.max.file', ['attribute' => __('main.image'), 'max' => '5MB']),
        ];
    }
}
