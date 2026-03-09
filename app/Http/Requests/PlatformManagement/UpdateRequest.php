<?php

namespace App\Http\Requests\PlatformManagement;

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
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title_ar.required' => __('messages.title_required'),
            'title_en.required' => __('messages.title_required'),
            'image.image' => __('messages.image_required'),
        ];
    }
}
