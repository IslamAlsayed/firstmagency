<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = Setting::first();
        return view('dashboard.settings', compact('settings'));
    }

    /**
     * Update the settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'font_url' => 'nullable|string|url',
            'font_name' => 'nullable|string|max:255',
            'font_size' => 'nullable|integer|between:10,24',
            'line_height' => 'nullable|numeric|between:1,3',
            'site_name' => 'nullable|string|max:255',
            'site_email' => 'nullable|email|max:255',
            'site_whatsapp' => 'nullable|string|max:255',
            'site_phone' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_description_ar' => 'nullable|string',
        ]);

        $settings = Setting::first();
        $settings->update($validated);

        return redirect()->back()->withSuccess('Settings updated successfully! Colors and fonts have been applied to the site.');
    }

    /**
     * Update only colors for the website
     */
    public function updateColorsWebsite(Request $request)
    {
        $validated = $request->validate([
            'main_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'dark_main_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'light_main_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $settings = Setting::first();
        $settings->update($validated);

        return redirect()->back()->withSuccess('Settings updated successfully! Website colors have been applied to the site.');
    }

    /**
     * Update only colors
     */
    public function updateColors(Request $request)
    {
        $validated = $request->validate([
            'primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'success_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'danger_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'warning_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'info_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'accent_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $settings = Setting::first();
        $settings->update($validated);

        return redirect()->back()->withSuccess('Settings updated successfully! Colors and fonts have been applied to the site.');
    }

    /**
     * Update only fonts
     */
    public function updateFonts(Request $request)
    {
        $validated = $request->validate([
            'font_url' => 'nullable|string|url',
            'font_name' => 'nullable|string|max:255',
        ]);

        $settings = Setting::first();
        $settings->update($validated);

        return redirect()->back()->withSuccess('Settings updated successfully! Fonts have been applied to the site.');
    }

    /**
     * Update only inline padding settings
     */
    public function updateInlinePadding(Request $request)
    {
        $validated = $request->validate([
            'home_hero_section' => 'nullable|numeric|max:255',
            'home_services_section' => 'nullable|numeric|max:255',
            'home_projects_section' => 'nullable|numeric|max:255',
            'home_reviews_section' => 'nullable|numeric|max:255',
            'home_clients_section' => 'nullable|numeric|max:255',
            'about_us_line_works_steps_section' => 'nullable|numeric|max:255',
            'about_us_partners_section' => 'nullable|numeric|max:255',
            'portfolio_section' => 'nullable|numeric|max:255',
            'blog_articles_section' => 'nullable|numeric|max:255',
            'contact_page_section' => 'nullable|numeric|max:255',
            'website_developer_section' => 'nullable|numeric|max:255',
            'website_programming_section' => 'nullable|numeric|max:255',
            'website_design_section' => 'nullable|numeric|max:255',
            'website_important_articles_section' => 'nullable|numeric|max:255',
            'faqs_section' => 'nullable|numeric|max:255',
            'app_important_articles_section' => 'nullable|numeric|max:255',
            'feature_section' => 'nullable|numeric|max:255',
            'packages_section' => 'nullable|numeric|max:255',
            'operations_systems_section' => 'nullable|numeric|max:255',
            'your_domain_section' => 'nullable|numeric|max:255',
            'pest_domains_section' => 'nullable|numeric|max:255',
            'why_us_section' => 'nullable|numeric|max:255',
            'platform_management_section' => 'nullable|numeric|max:255',
            'work_lines_section' => 'nullable|numeric|max:255',
            'our_services_marketing_section' => 'nullable|numeric|max:255',
        ]);

        $settings = Setting::first();
        $settings->update($validated);

        return redirect()->back()->withSuccess('Settings updated successfully! General settings have been applied to the site.');
    }

    /**
     * Update only general settings (site name, email, phone, etc.)
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'site_email' => 'nullable|string|email|max:255',
            'site_whatsapp' => 'nullable|string|max:255',
            'site_phone' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_description_ar' => 'nullable|string',
            'button_display_mode' => 'nullable|string',
        ]);

        // Update user preferences if button_display_mode is sent
        if ($request->has('button_display_mode')) {
            $user = getActiveUser();
            $user->button_display_mode = $request->button_display_mode;
            $user->save();
        }

        $settings = Setting::first();
        $settings->update($validated);

        return redirect()->back()->withSuccess('Settings updated successfully! General settings have been applied to the site.');
    }
}
