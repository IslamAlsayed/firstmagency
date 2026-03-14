<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Section::truncate();
        Schema::enableForeignKeyConstraints();

        $sections = [
            [
                'name' => 'Home Hero Section',
                'flag' => 'flag-hero',
                'padding_setting_key' => 'home_hero_section',
                'view_file' => 'hero',
            ],
            [
                'name' => 'Services Section',
                'flag' => 'flag-services',
                'padding_setting_key' => 'home_services_section',
                'view_file' => 'services',
            ],
            [
                'name' => 'Projects Section',
                'flag' => 'flag-projects',
                'padding_setting_key' => 'home_projects_section',
                'view_file' => 'projects',
            ],
            [
                'name' => 'Reviews Section',
                'flag' => 'flag-reviews',
                'padding_setting_key' => 'home_reviews_section',
                'view_file' => 'reviews',
            ],
            [
                'name' => 'Clients Section',
                'flag' => 'flag-clients',
                'padding_setting_key' => 'home_clients_section',
                'view_file' => 'clients',
            ],
            [
                'name' => 'About Us Section',
                'flag' => 'flag-about-us',
                'padding_setting_key' => 'about_us_section',
                'view_file' => 'about-us',
            ],
            [
                'name' => 'Partners Section',
                'flag' => 'flag-partners',
                'padding_setting_key' => 'about_us_partners_section',
                'view_file' => 'partners',
            ],
            [
                'name' => 'Line Works Section',
                'flag' => 'flag-line-works',
                'padding_setting_key' => 'work_lines_section',
                'view_file' => 'line-works',
            ],
            [
                'name' => 'Articles Section',
                'flag' => 'flag-articles',
                'padding_setting_key' => 'blog_articles_section',
                'view_file' => 'articles',
            ],
            [
                'name' => 'Contact Section',
                'flag' => 'flag-contact',
                'padding_setting_key' => 'contact_page_section',
                'view_file' => 'contact',
            ],
            [
                'name' => 'Website Designer Section',
                'flag' => 'flag-website-designer',
                'padding_setting_key' => 'website_developer_section',
                'view_file' => 'website-design',
            ],
            [
                'name' => 'Programming Section',
                'flag' => 'flag-programming',
                'padding_setting_key' => 'website_programming_section',
                'view_file' => 'programming',
            ],
            [
                'name' => 'Why Us Section',
                'flag' => 'flag-why-us',
                'padding_setting_key' => 'why_us_section',
                'view_file' => 'why-us',
            ],
            [
                'name' => 'Platform Management Section',
                'flag' => 'flag-platform-management',
                'padding_setting_key' => 'platform_management_section',
                'view_file' => 'platform-management',
            ],
            [
                'name' => 'Operating Systems Section',
                'flag' => 'flag-operating-systems',
                'padding_setting_key' => 'operations_systems_section',
                'view_file' => 'operating-systems',
            ],
            [
                'name' => 'Your Domain Section',
                'flag' => 'flag-your-domain',
                'padding_setting_key' => 'your_domain_section',
                'view_file' => 'your-domain',
            ],
            [
                'name' => 'Official Domains Section',
                'flag' => 'flag-official-domains',
                'padding_setting_key' => 'pest_domains_section',
                'view_file' => 'official-domains',
            ],
            [
                'name' => 'Pest Domains Section',
                'flag' => 'flag-pest-domains',
                'padding_setting_key' => 'pest_domains_section',
                'view_file' => 'pest-domains',
            ],
            [
                'name' => 'Frequently Asked Questions Section',
                'flag' => 'flag-faq',
                'padding_setting_key' => 'faqs_section',
                'view_file' => 'frequently-asked-questions',
            ],
            [
                'name' => 'Important Articles Section',
                'flag' => 'flag-important-articles',
                'padding_setting_key' => 'app_important_articles_section',
                'view_file' => 'important-articles',
            ],
            [
                'name' => 'App Developer Section',
                'flag' => 'flag-app-developer',
                'padding_setting_key' => 'feature_section',
                'view_file' => 'app-developer',
            ],
            [
                'name' => 'Portfolio Section',
                'flag' => 'flag-portfolio',
                'padding_setting_key' => 'portfolio_section',
                'view_file' => 'projects',
            ],
            [
                'name' => 'Marketing Hero Section',
                'flag' => 'flag-marketing-hero',
                'padding_setting_key' => 'home_hero_section',
                'view_file' => 'marketing-hero',
            ],
            [
                'name' => 'Order Your App Section',
                'flag' => 'flag-order-app',
                'padding_setting_key' => 'feature_section',
                'view_file' => 'order-your-app',
            ],
            [
                'name' => 'Our Services Marketing Section',
                'flag' => 'flag-packages-marketing',
                'padding_setting_key' => 'packages_marketing_section',
                'view_file' => 'packages-marketing',
            ],
            [
                'name' => 'Hosting Features Section',
                'flag' => 'flag-hosting-features',
                'padding_setting_key' => 'hosting_features_section',
                'view_file' => 'features-hosting',
            ],
            [
                'name' => 'Hosting Packages Section',
                'flag' => 'flag-packages',
                'padding_setting_key' => 'packages_hosting_section',
                'view_file' => 'packages-hosting',
            ],
            [
                'name' => 'Categories Programming Section',
                'flag' => 'flag-categories-programming',
                'padding_setting_key' => 'categories_programming_section',
                'view_file' => 'categories-programming',
            ],
            [
                'name' => 'Website Developer Section',
                'flag' => 'flag-website-developer',
                'padding_setting_key' => 'website_developer_section',
                'view_file' => 'developer',
            ],
            [
                'name' => 'Dont Worry Hosting Section',
                'flag' => 'flag-dont-worry-hosting',
                'padding_setting_key' => 'dont_worry_hosting_section',
                'view_file' => 'dont-worry-hosting',
            ],
            [
                'name' => 'Easy Management Section',
                'flag' => 'flag-easy-management',
                'padding_setting_key' => 'easy_management_section',
                'view_file' => 'easy-management',
            ],
            [
                'name' => 'Hosting Hero Section',
                'flag' => 'flag-hosting-hero',
                'padding_setting_key' => 'hosting_hero_section',
                'view_file' => 'hero-hosting',
            ],
            [
                'name' => 'Important Articles Marketing Section',
                'flag' => 'flag-important-articles-marketing',
                'padding_setting_key' => 'important_articles_marketing_section',
                'view_file' => 'important-articles-marketing',
            ],
            [
                'name' => 'Project Steps Section',
                'flag' => 'flag-project-steps',
                'padding_setting_key' => 'project_steps_section',
                'view_file' => 'project-steps',
            ],
            [
                'name' => 'Ready Hosting Section',
                'flag' => 'flag-ready-hosting',
                'padding_setting_key' => 'ready_hosting_section',
                'view_file' => 'ready-hosting',
            ],
            [
                'name' => 'Support Hosting Section',
                'flag' => 'flag-support-hosting',
                'padding_setting_key' => 'support_hosting_section',
                'view_file' => 'support-hosting',
            ],
            [
                'name' => 'Work Line Section',
                'flag' => 'flag-work-line',
                'padding_setting_key' => 'work_line_section',
                'view_file' => 'work-line',
            ],
            [
                'name' => 'Clients 2 Section',
                'flag' => 'flag-clients2',
                'padding_setting_key' => 'clients_2_section',
                'view_file' => 'clients2',
            ],
            [
                'name' => 'Step Work 2 Section',
                'flag' => 'flag-step-work2',
                'padding_setting_key' => 'step_work2_section',
                'view_file' => 'step-work2',
            ],
        ];

        foreach ($sections as $section) {
            Section::updateOrCreate(
                ['flag' => $section['flag']],
                $section
            );
        }
    }
}