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
            $table->json('colors')->nullable();

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
            $table->string('about_us_image2')->nullable();

            $table->boolean('debug_mode')->default(false);
            $table->json('sections_padding')->nullable();

            $table->string('website_design_title_ar')->nullable();
            $table->string('website_design_heading')->nullable();
            $table->string('website_design_heading_ar')->nullable();
            $table->longText('website_design_description')->nullable();
            $table->longText('website_design_description_ar')->nullable();
            $table->integer('website_design_years_experience')->default(8);
            $table->string('website_design_image')->nullable();

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
