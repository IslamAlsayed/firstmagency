<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    /**
     * Get site settings from database
     */
    public static function get($key = null, $default = null)
    {
        try {
            $settings = Setting::first();

            if (!$settings) {
                $settings = Setting::create();
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
            'dash_primary_color' => '#fff',
            'secondary_color' => '#6c757d',
            'success_color' => '#198754',
            'danger_color' => '#dc3545',
            'warning_color' => '#ffc107',
            'info_color' => '#0dcaf0',
            'accent_color' => '#dc3545',
            'font_size' => 16,
            'line_height' => 1.5,
        ];

        if (!$settings) {
            $primary = $defaults['primary_color'];
            $secondary = $defaults['secondary_color'];
            $success = $defaults['success_color'];
            $danger = $defaults['danger_color'];
            $warning = $defaults['warning_color'];
            $info = $defaults['info_color'];
            $accent = $defaults['accent_color'];
            $fontSize = $defaults['font_size'];
            $lineHeight = $defaults['line_height'];
        } else {
            $dash_primary_color = $settings->dash_primary_color ?? $defaults['dash_primary_color'];
            $secondary = $settings->secondary_color ?? $defaults['secondary_color'];
            $success = $settings->success_color ?? $defaults['success_color'];
            $danger = $settings->danger_color ?? $defaults['danger_color'];
            $warning = $settings->warning_color ?? $defaults['warning_color'];
            $info = $settings->info_color ?? $defaults['info_color'];
            $accent = $settings->accent_color ?? $defaults['accent_color'];
            $fontSize = $settings->font_size ?? $defaults['font_size'];
            $lineHeight = $settings->line_height ?? $defaults['line_height'];
        }

        return ":root {
            --dash_primary_color: {$dash_primary_color};
            --secondary: {$secondary};
            --success: {$success};
            --danger: {$danger};
            --warning: {$warning};
            --info: {$info};
            --accent-color: {$accent};
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
