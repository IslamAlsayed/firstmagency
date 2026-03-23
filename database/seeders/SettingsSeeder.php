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

        Setting::create(
            ['site_email' => config('app.email')],
            [
                // Colors
                // 'primary_color' => '#5A8622',
                'primary_color' => '#3c3c39',
                'secondary_color' => '#6c757d',
                'success_color' => '#198754',
                'danger_color' => '#dc3545',
                'warning_color' => '#ffc107',
                'info_color' => '#0dcaf0',
                'accent_color' => '#dc3545',
                // 'header_color' => '#5A8622',
                'header_color' => '#413e3e',
                'header_text_color' => '#f7f7f7',
                'footer_color' => '#5A8622',

                // Website colors
                'main_color' => '#d05423',
                'light_main_color' => '#F97316',
                'dark_main_color' => '#96310E',

                // Fonts
                'font_url' => 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap',
                'font_name' => 'Tajawal',
                'font_size' => 16,
                'line_height' => 1.5,

                // General Settings
                'site_name' => config('app.name'),
                'site_email' => config('app.email'),
                'site_whatsapp' => config('app.whatsapp'),
                'site_phone' => config('app.phone'),
                'site_description' => 'Welcome to First Ma\'Agency - Your trusted digital solutions partner.',
                'site_description_ar' => 'مرحبًا بكم في فرست ما\'أجنسي - شريككم الموثوق للحلول الرقمية.',

                // About Us
                'about_us_title' => 'About Us',
                'about_us_title_ar' => 'من نحن',
                'about_us_description' => 'First Marketing Integrated Web Solutions is a company specializing in marketing, website design, hosting and server services, and website and e-commerce store management. We also offer other services to suit everyone and provide a fertile environment for the growth of online ideas and projects. Today, we are proud to offer various hosting services to over a thousand websites, from small and large blogs to massive business websites. Our services embody many values ​​that generate satisfaction among our clients. Contact us now to book one of our services through our technical support team, ready to listen to and understand your request and provide you with a suitable quote.',
                'about_us_description_ar' => 'شركة فرست ماركتينج لحلول الويب المتكاملة شركة متخصصة في اعمال التسويق وتصميم المواقع الالكترونية وخدمات الاستضافه والسيرفرات وادارة مواقع الانترنت والمتاجر الالكترونية كما نوفر خدمات اخري توفر خدمات ملائمة للجميع و تمثل البيئة الخصبة لنمو الأفكار و المشاريع على الإنترنت اليوم نعتز و نفتخر بتقديم خدمات الاستضافة المختلفة لأكثر من ألف موقع ، بدءاً من المدونات الصغيرة و الكبيرة و حتى مواقع الأعمال الضخمة، خدماتنا تحمل الكثير من القيم التي تولد شعوراً بالسعادة لدى عملاؤنا . اتصل الان لحجز احد الخدمات من خلال فريق من الدعم الفني جاهز لاستماع وفهم طلبك وتحديد عرض سعر مناسب',
                'about_us_image' => 'images/website/about/main-image.png',
                'about_us_image2' => 'images/website/about/text-bg.png',

                // Inline Padding Sections
                'sections_padding' => [
                    "home_hero_section" => 200,
                    "home_services_section" => 60,
                    "home_projects_section" => 20,
                    "home_reviews_section" => 60,
                    "home_clients_section" => 120,
                    "about_us_line_works_steps_section" => 60,
                    "about_us_partners_section" => 60,
                    "portfolio_section" => 200,
                    "blog_articles_section" => 60,
                    "articles_page_section" => 200,
                    "contact_page_section" => 180,
                    "website_developer_section" => 120,
                    "website_programming_section" => 200,
                    "website_design_section" => 60,
                    "website_important_articles_section" => 60,
                    "faqs_section" => 60,
                    "app_developer_hero_section" => 240,
                    "app_important_articles_section" => 100,
                    "projects_steps_section" => 60,
                    "feature_section" => 200,
                    "packages_section" => 120,
                    "operations_systems_section" => 60,
                    "your_domain_section" => 240,
                    "pest_domains_section" => 60,
                    "why_us_section" => 120,
                    "platform_management_section" => 60,
                    "work_lines_section" => 120,
                    "packages_marketing_section" => 120,
                    "dont_worry_hosting_section" => 60,
                    "order_your_app_section" => 170,
                    "categories_programming_section" => 200
                ]
            ]
        );
    }
}
