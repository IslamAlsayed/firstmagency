<?php

namespace App\Http\Requests\Review;

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
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:2',
            'rate' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'audio' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('main.name')]),
            'country.required' => __('validation.required', ['attribute' => __('main.country')]),
            'rate.required' => __('validation.required', ['attribute' => __('main.rating')]),
            'comment.required' => __('validation.required', ['attribute' => __('main.message')]),
            'photo.image' => __('validation.image', ['attribute' => __('main.photo')]),
        ];
    }
}
