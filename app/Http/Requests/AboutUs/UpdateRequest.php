<?php

namespace App\Http\Requests\AboutUs;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $aboutUsId = $this->route('about_us');
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'alt_text' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __('validation.required_field'),
            'description.required' => __('validation.required_field'),
        ];
    }
}
