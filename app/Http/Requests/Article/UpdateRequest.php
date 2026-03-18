<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $articleId = $this->route('article')?->id ?? null;

        return [
            // Arabic Translations (Primary Language)
            'title_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'content_ar' => 'nullable|string',
            'keywords_ar' => 'nullable|string|max:500',
            'meta_description_ar' => 'nullable|string|max:300',

            // English Translations
            'title_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'content_en' => 'nullable|string',
            'keywords_en' => 'nullable|string|max:500',
            'meta_description_en' => 'nullable|string|max:300',

            // Media & Common Fields
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'nullable|integer|exists:categories,id',
            'status' => 'required|string|in:draft,published,archived',
            'is_active' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title_ar.required' => __('validation.required', ['attribute' => __('main.title_ar')]),
            'description_ar.required' => __('validation.required', ['attribute' => __('main.description_ar')]),
            'status.required' => __('validation.required', ['attribute' => __('main.status')]),
        ];
    }
}
