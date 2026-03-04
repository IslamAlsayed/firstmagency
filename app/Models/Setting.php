<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Setting extends Model
{
    use HasFactory, HasRichText;
    protected $richTextAttributes = [
        'site_description',
        'site_description_ar',
        'about_us_description',
        'about_us_description_ar',
    ];

    protected $fillable = [
        // Dashboard Colors
        'primary_color',
        'secondary_color',
        'success_color',
        'danger_color',
        'warning_color',
        'info_color',
        'accent_color',

        // Website Colors
        'main_color',
        'dark_main_color',
        'light_main_color',

        'font_url',
        'font_name',
        'font_size',
        'line_height',

        'site_name',
        'site_email',
        'site_whatsapp',
        'site_phone',
        'site_description',
        'site_description_ar',
        'app_display_menu_labels',
        'debug_mode',
        'debug_ips',

        // About Us
        'about_us_title',
        'about_us_title_ar',
        'about_us_description',
        'about_us_description_ar',
        'about_us_image',

        // Inline Padding
        'home_hero_section',
        'home_services_section',
        'home_projects_section',
        'home_reviews_section',
        'home_clients_section',
        'about_us_partners_section',
        'portfolio_section',
        'blog_articles_section',
        'contact_page_section',
        'website_programming_section',
        'website_important_articles_section',
        'faqs_section',
        'app_important_articles_section',
        'feature_section',
        'packages_section',
        'operations_systems_section',
        'your_domain_section',
        'pest_domains_section',
        'why_us_section',
        'platform_management_section',
        'work_lines_section',
        'our_services_marketing_section',
        'about_us_section',
        'marketing_hero_section',
        'order_app_section',
        'hosting_hero_section',
        'hosting_features_section',
        'categories_programming_section',
        'dont_worry_hosting_section',
        'easy_management_section',
        'important_articles_marketing_section',
        'project_steps_section',
        'ready_hosting_section',
        'support_hosting_section',
        'work_line_section',
        'clients_2_section',
        'step_work2_section',
        'website_developer_section',
        'packages_hosting_section',
        'pest_domains_official_section',
    ];

    protected $casts = [
        'font_size' => 'integer',
        'line_height' => 'float',
        'debug_mode' => 'boolean',
    ];

    /**
     * Get the first (or create) settings record
     */
    public static function first()
    {
        return static::query()->first() ?? static::create();
    }
}
