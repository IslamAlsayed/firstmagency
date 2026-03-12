<?php

namespace App\Http\Requests\PestDomain;

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
            'alt_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ];
    }
}
