<?php

namespace App\Http\Requests\FAQ;

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
            'question' => 'required|string|max:255',
            'question_ar' => 'required|string|max:255',
            'answer' => 'required|string',
            'answer_ar' => 'required|string',
            'category' => 'required|in:websites,apps,domains,hosting,services-marketing',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'question' => __('main.question') . ' (EN)',
            'question_ar' => __('main.question') . ' (AR)',
            'answer' => __('main.answer') . ' (EN)',
            'answer_ar' => __('main.answer') . ' (AR)',
            'category' => __('main.category'),
            'order' => __('main.order'),
            'is_active' => __('main.active'),
        ];
    }
}
