<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('settings')) {
            return;
        }
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Color Settings
            $table->string('primary_color')->default('#6f42c1');
            $table->string('secondary_color')->default('#6c757d');
            $table->string('success_color')->default('#198754');
            $table->string('danger_color')->default('#dc3545');
            $table->string('warning_color')->default('#ffc107');
            $table->string('info_color')->default('#0dcaf0');
            $table->string('accent_color')->default('#dc3545');
            $table->string('header_color')->default('#6f42c1');
            $table->string('header_text_color')->default('#f7f7f7');
            $table->string('footer_color')->default('#6f42c1');

            // Website colors
            // $table->string('main_color')->default('#d05423');
            // $table->string('dark_main_color')->default('#96310E');
            // $table->string('light_main_color')->default('#F97316');

            // Font Settings
            $table->string('font_url')->default('https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800&family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap');
            $table->string('font_name')->default('Tajawal');
            $table->integer('font_size')->default(16);
            $table->float('line_height')->default(1.5);

            // General Settings
            $table->string('site_name')->default('First Ma\'Agency');
            $table->string('site_email')->default('info@firstmagency.com');
            $table->string('site_whatsapp')->default('201212601601');
            $table->string('site_phone')->default('201212602602');
            $table->longText('site_description')->nullable();
            $table->longText('site_description_ar')->nullable();

            $table->string('about_us_title')->nullable();
            $table->string('about_us_title_ar')->nullable();
            $table->longText('about_us_description')->nullable();
            $table->longText('about_us_description_ar')->nullable();
            $table->string('about_us_image')->nullable();

            $table->string('main_color')->default('#d05423');
            $table->string('light_main_color')->default('#F97316');
            $table->string('dark_main_color')->default('#96310E');

            $table->boolean('debug_mode')->default(false);

            $table->string('home_hero_section')->default(120);
            $table->string('home_services_section')->default(60);
            $table->string('home_projects_section')->default(20);
            $table->string('home_reviews_section')->default(120);
            $table->string('home_clients_section')->default(60);
            $table->string('about_us_line_works_steps_section')->default(20);
            $table->string('about_us_partners_section')->default(60);
            $table->string('portfolio_section')->default(120);
            $table->string('blog_articles_section')->default(60);
            $table->string('contact_page_section')->default(60);
            $table->string('website_developer_section')->default(60);
            $table->string('website_programming_section')->default(180);
            $table->string('website_design_section')->default(60);
            $table->string('website_important_articles_section')->default(60);
            $table->string('faqs_section')->default(60);
            $table->string('app_important_articles_section')->default(120);
            $table->string('feature_section')->default(60);
            $table->string('packages_section')->default(120);
            $table->string('operations_systems_section')->default(60);
            $table->string('your_domain_section')->default(240);
            $table->string('pest_domains_section')->default(60);
            $table->string('why_us_section')->default(120);
            $table->string('platform_management_section')->default(60);
            $table->string('work_lines_section')->default(120);
            $table->string('our_services_marketing_section')->default(120);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
