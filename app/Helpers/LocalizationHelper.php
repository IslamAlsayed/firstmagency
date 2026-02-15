<?php

if (!function_exists('trans_route')) {
    /**
     * Get translated route
     */
    function trans_route($name, $parameters = [])
    {
        return route($name, array_merge($parameters, ['lang' => app()->getLocale()]));
    }
}

if (!function_exists('is_arabic')) {
    /**
     * Check if current locale is Arabic
     */
    function is_arabic()
    {
        return app()->getLocale() === 'ar';
    }
}

if (!function_exists('is_english')) {
    /**
     * Check if current locale is English
     */
    function is_english()
    {
        return app()->getLocale() === 'en';
    }
}

if (!function_exists('get_rtl_direction')) {
    /**
     * Get RTL direction attribute
     */
    function get_rtl_direction()
    {
        return is_arabic() ? 'rtl' : 'ltr';
    }
}

if (!function_exists('get_text_align')) {
    /**
     * Get text align based on locale
     */
    function get_text_align()
    {
        return is_arabic() ? 'right' : 'left';
    }
}

if (!function_exists('locale_url')) {
    /**
     * Generate URL for language switch
     */
    function locale_url($locale)
    {
        $url = url()->current();
        return $url . '?lang=' . $locale;
    }
}
