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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('website_design_title')->nullable()->after('about_us_image');
            $table->string('website_design_title_ar')->nullable()->after('website_design_title');
            $table->string('website_design_heading')->nullable()->after('website_design_title_ar');
            $table->string('website_design_heading_ar')->nullable()->after('website_design_heading');
            $table->longText('website_design_description')->nullable()->after('website_design_heading_ar');
            $table->longText('website_design_description_ar')->nullable()->after('website_design_description');
            $table->integer('website_design_years_experience')->default(8)->after('website_design_description_ar');
            $table->string('website_design_image')->nullable()->after('website_design_years_experience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'website_design_title',
                'website_design_title_ar',
                'website_design_heading',
                'website_design_heading_ar',
                'website_design_description',
                'website_design_description_ar',
                'website_design_years_experience',
                'website_design_image',
            ]);
        });
    }
};
