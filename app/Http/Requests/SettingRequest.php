<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'font_url' => 'nullable|string|url',
            'font_name' => 'nullable|string|max:255',
            'font_size',
            'line_height',

            'site_name',
            'site_email' => 'nullable|string|email|max:255',
            'site_whatsapp' => 'nullable|string|max:255',
            'site_phone' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_description_ar' => 'nullable|string',
            'button_display_mode' => 'nullable|string',

            'about_us_title' => 'nullable|string|max:255',
            'about_us_title_ar' => 'nullable|string|max:255',
            'about_us_description' => 'nullable|string',
            'about_us_description_ar' => 'nullable|string',
            'about_us_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'about_us_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

            'website_design_title' => 'nullable|string|max:255',
            'website_design_title_ar' => 'nullable|string|max:255',
            'website_design_heading' => 'nullable|string|max:255',
            'website_design_heading_ar' => 'nullable|string|max:255',
            'website_design_description' => 'nullable|string',
            'website_design_description_ar' => 'nullable|string',
            'website_design_years_experience' => 'nullable|numeric|max:999',
            'website_design_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',

            'sections_padding' => 'nullable|array',
            'sections_padding.*' => 'nullable|numeric|min:0|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => __('validation.required', ['attribute' => __('main.name') . ' - ' . __('main.arabic')]),
            'name_en.required' => __('validation.required', ['attribute' => __('main.name') . ' - ' . __('main.english')]),
            'image.image' => __('validation.image'),
            'image.max' => __('validation.max.file'),
            'website.url' => __('validation.url'),
        ];
    }
}
