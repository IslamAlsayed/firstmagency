<?php

namespace App\Http\Requests\ProgrammingSystem;

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
     */
    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'content_en' => 'nullable|string',
            'content_ar' => 'nullable|string',
            'keywords' => 'nullable|array',
            'keywords.*.en' => 'required_with:keywords|string',
            'keywords.*.ar' => 'required_with:keywords|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'status' => 'nullable|string|in:draft,published',
            'is_active' => 'nullable|boolean',
        ];
    }
}
