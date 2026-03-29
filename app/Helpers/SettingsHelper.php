<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    /**
     * Get site settings from database
     */
    public static function get($key = null, $default = null)
    {
        try {
            static $settings = null;

            if ($settings === null) {
                $settings = Cache::remember('app_settings.first', config('app.cache_time'), function () {
                    return Setting::query()->first() ?? Setting::query()->create();
                });
            }

            if ($key) {
                return $settings->$key ?? $default;
            }

            return $settings;
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Get CSS variables for colors and fonts
     */
    public static function getCssVariables()
    {
        $settings = self::get();

        // Default colors if settings not found
        $defaults = [
            'dash_primary_color' => '#F54900',
            'text_color' => '#ffffff',
            'icon_color' => '#4a5565',
            'button_color' => '#0074F7',
            'width_logo_sidebar' => '70',
            'font_size' => 16,
            'line_height' => 1.5,
        ];

        if (!$settings) {
            $dash_primary_color = $defaults['dash_primary_color'];
            $text_color = $defaults['text_color'];
            $icon_color = $defaults['icon_color'];
            $button_color = $defaults['button_color'];
            $width_logo_sidebar = $defaults['width_logo_sidebar'];
        } else {
            $dash_primary_color = $settings->dash_primary_color ?? $defaults['dash_primary_color'];
            $text_color = $settings->text_color ?? $defaults['text_color'];
            $icon_color = $settings->icon_color ?? $defaults['icon_color'];
            $button_color = $settings->button_color ?? $defaults['button_color'];
            $width_logo_sidebar = $settings->width_logo_sidebar ?? $defaults['width_logo_sidebar'];
            $fontSize = $defaults['font_size'];
            $lineHeight = $defaults['line_height'];
        }

        return ":root {
            --dash_primary_color: {$dash_primary_color};
            --text_color: {$text_color};
            --icon_color: {$icon_color};
            --button_color: {$button_color};
            --width_logo_sidebar: {$width_logo_sidebar}px;
            --font-size-base: {$fontSize}px;
            --line-height-base: {$lineHeight};
        }";
    }

    /**
     * Get font URL
     */
    public static function getFontUrl()
    {
        return self::get('font_url', 'https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700');
    }

    /**
     * Get font name
     */
    public static function getFontName()
    {
        return self::get('font_name', 'Tajawal');
    }
}
