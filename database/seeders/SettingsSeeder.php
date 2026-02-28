<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Setting::truncate();
        Schema::enableForeignKeyConstraints();

        Setting::firstOrCreate(
            ['id' => 1],
            [
                'primary_color' => '#6f42c1',
                'secondary_color' => '#6c757d',
                'danger_color' => '#dc3545',
                'warning_color' => '#ffc107',
                'info_color' => '#0dcaf0',
                'accent_color' => '#dc3545',
                'font_url' => 'https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700',
                'font_name' => 'Tajawal',
                'font_size' => 16,
                'line_height' => 1.5,
                'site_name' => 'First Ma\'Agency',
                'site_email' => 'info@firstmagency.com',
                'site_whatsapp' => '201212601601',
                'site_phone' => '201212602602',
                'site_description' => 'Welcome to First Ma\'Agency - Your trusted digital solutions partner.',

                'home_hero_section' => 120,
                'home_services_section' => 60,
                'home_projects_section' => 20,
                'home_reviews_section' => 60,
                'home_clients_section' => 120,
                'about_us_partners_section' => 60,
                'portfolio_section' => 60,
                'blog_articles_section' => 60,
                'contact_page_section' => 180,
                'website_programming_section' => 60,
                'website_important_articles_section' => 60,
                'faqs_section' => 60,
                'app_important_articles_section' => 120,
                'feature_section' => 60,
                'packages_section' => 120,
                'operations_systems_section' => 60,
                'your_domain_section' => 240,
                'pest_domains_section' => 60,
                'why_us_section' => 120,
                'platform_management_section' => 60,
                'work_lines_section' => 120,
                'our_services_marketing_section' => 120,
            ]
        );
    }
}
