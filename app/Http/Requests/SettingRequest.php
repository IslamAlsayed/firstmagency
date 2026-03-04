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
            'primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'success_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'danger_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'warning_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'info_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'accent_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',

            'main_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'dark_main_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'light_main_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',

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

            'home_hero_section' => 'nullable|numeric|max:255',
            'home_services_section' => 'nullable|numeric|max:255',
            'home_projects_section' => 'nullable|numeric|max:255',
            'home_reviews_section' => 'nullable|numeric|max:255',
            'home_clients_section' => 'nullable|numeric|max:255',
            'about_us_line_works_steps_section' => 'nullable|numeric|max:255',
            'about_us_partners_section' => 'nullable|numeric|max:255',
            'portfolio_section' => 'nullable|numeric|max:255',
            'blog_articles_section' => 'nullable|numeric|max:255',
            'contact_page_section' => 'nullable|numeric|max:255',
            'website_developer_section' => 'nullable|numeric|max:255',
            'website_programming_section' => 'nullable|numeric|max:255',
            'website_design_section' => 'nullable|numeric|max:255',
            'website_important_articles_section' => 'nullable|numeric|max:255',
            'faqs_section' => 'nullable|numeric|max:255',
            'app_important_articles_section' => 'nullable|numeric|max:255',
            'feature_section' => 'nullable|numeric|max:255',
            'packages_section' => 'nullable|numeric|max:255',
            'operations_systems_section' => 'nullable|numeric|max:255',
            'your_domain_section' => 'nullable|numeric|max:255',
            'pest_domains_section' => 'nullable|numeric|max:255',
            'why_us_section' => 'nullable|numeric|max:255',
            'platform_management_section' => 'nullable|numeric|max:255',
            'work_lines_section' => 'nullable|numeric|max:255',
            'our_services_marketing_section' => 'nullable|numeric|max:255',
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
