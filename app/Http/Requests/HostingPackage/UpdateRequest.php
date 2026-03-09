<?php

namespace App\Http\Requests\HostingPackage;

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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category' => 'required|string|in:hosting,reseller,vps,servers',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'feature_title_en.*' => 'nullable|string|max:255',
            'feature_label_en.*' => 'nullable|string',
            'feature_title_ar.*' => 'nullable|string|max:255',
            'feature_label_ar.*' => 'nullable|string',
        ];
    }
}
