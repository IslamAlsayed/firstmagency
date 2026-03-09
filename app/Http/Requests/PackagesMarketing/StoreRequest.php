<?php

namespace App\Http\Requests\MarketingPackage;

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
            'feature_title_en' => 'nullable|array',
            'feature_title_en.*' => 'nullable|string|max:255',
            'feature_title_ar' => 'nullable|array',
            'feature_title_ar.*' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'alt_text' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }
}
