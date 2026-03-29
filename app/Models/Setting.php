<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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
        'about_us_image2',

        'website_design_title',
        'website_design_title_ar',
        'website_design_heading',
        'website_design_heading_ar',
        'website_design_description',
        'website_design_description_ar',
        'website_design_years_experience',
        'website_design_image',
        'width_logo_sidebar',
        'ably_key',
        'cache_time',

        // columns (JSON)
        'colors',
        'sections_padding',
    ];

    protected $casts = [
        'font_size' => 'integer',
        'line_height' => 'float',
        'debug_mode' => 'boolean',
        'colors' => 'array',
        'sections_padding' => 'array',
    ];

    /**
     * Get the first (or create) settings record
     */
    public static function first()
    {
        return static::query()->first() ?? static::create();
    }
}
