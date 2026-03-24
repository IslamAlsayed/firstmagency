<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Traits\PhotoUploadTrait;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        $settings = Setting::first();
        return view('dashboard.settings.index', compact('settings'));
    }

    public function update(SettingRequest $request)
    {
        $settings = Setting::first();
        $settings->update($request->all());
        return redirect()->back()->withSuccess(__('messages.settings_updated') . ' ' . __('messages.settings_colors_fonts_applied'));
    }

    public function updateColorsWebsite(SettingRequest $request)
    {
        $settings = Setting::first();
        $settings->update($request->all());
        return redirect()->back()->withSuccess(__('messages.settings_updated') . ' ' . __('messages.settings_colors_applied'));
    }

    public function updateColors(SettingRequest $request)
    {
        $settings = Setting::first();
        $settings->update($request->all());
        return redirect()->back()->withSuccess(__('messages.settings_updated') . ' ' . __('messages.settings_colors_fonts_applied'));
    }

    public function updateFonts(SettingRequest $request)
    {
        $settings = Setting::first();
        $settings->update($request->all());

        return redirect()->back()->withSuccess(__('messages.settings_updated') . ' ' . __('messages.settings_fonts_applied'));
    }

    public function inlinePadding()
    {
        return view('dashboard.settings.inline-padding');
    }

    public function updateInlinePadding(SettingRequest $request)
    {
        $settings = Setting::first();
        $settings->update($request->all());
        return redirect()->back()->withSuccess(__('messages.settings_updated') . ' ' . __('messages.settings_general_applied'));
    }

    public function resetInlinePadding()
    {
        $settings = Setting::first();
        $defaultSectionsPadding = config('inline_padding.defaults', []);

        if (!is_array($defaultSectionsPadding)) {
            $defaultSectionsPadding = [];
        }

        $settings->update(['sections_padding' => $defaultSectionsPadding]);

        return redirect()->back()->withSuccess(__('messages.inline_padding_reset'));
    }

    public function websiteSettings()
    {
        return view('dashboard.settings.website');
    }

    public function backupSettings()
    {
        return view('dashboard.settings.backups');
    }

    public function updateGeneral(SettingRequest $request)
    {
        // Update user preferences if button_display_mode is sent
        if ($request->has('button_display_mode')) {
            $user = getActiveUser();
            $user->button_display_mode = $request->button_display_mode;
            $user->save();
        }

        $settings = Setting::first();
        $settings->update($request->all());
        return redirect()->back()->withSuccess(__('messages.settings_updated') . ' ' . __('messages.settings_general_applied'));
    }

    public function updateAboutUs(SettingRequest $request)
    {
        $settings = Setting::first();
        $settings->update($request->all());

        // Handle image upload
        if ($request->hasFile('about_us_image')) {
            // Delete old image if exists
            if ($settings->about_us_image) {
                @unlink(storage_path('app/public/' . $settings->about_us_image));
            }
            $this->uploadSinglePhoto($request, $settings, 'about_us_image', 'settings/about-us');
        }

        // Handle image upload
        if ($request->hasFile('about_us_image2')) {
            // Delete old image if exists
            if ($settings->about_us_image2) {
                @unlink(storage_path('app/public/' . $settings->about_us_image2));
            }
            $this->uploadSinglePhoto($request, $settings, 'about_us_image2', 'settings/about-us');
        }

        return redirect()->back()->withSuccess(__('messages.about_us_settings_updated'));
    }

    public function updateWebsiteDesign(SettingRequest $request)
    {
        $settings = Setting::first();
        $settings->update($request->all());

        // Handle image upload
        if ($request->hasFile('website_design_image')) {
            // Delete old image if exists
            if ($settings->website_design_image) {
                @unlink(storage_path('app/public/' . $settings->website_design_image));
            }
            $this->uploadSinglePhoto($request, $settings, 'website_design_image', 'settings/website-design');
        }

        return redirect()->back()->withSuccess(__('messages.about_us_settings_updated'));
    }

    /**
     * Toggle debug mode
     */
    public function toggleDebugMode()
    {
        $settings = Setting::first();
        $settings->update(['debug_mode' => !$settings->debug_mode]);
        $status = $settings->debug_mode ? 'enabled' : 'disabled';
        return redirect()->back()->withSuccess(str_replace(':status', $status, __('messages.debug_mode_toggled')));
    }

    /**
     * Update allowed IPs for debug mode
     */
    public function updateDebugIps(\Illuminate\Http\Request $request)
    {
        $settings = Setting::first();

        $ips = array_filter(array_map('trim', explode("\n", $request->input('debug_ips', ''))));

        // Validate IPs
        $validated_ips = [];
        foreach ($ips as $ip) {
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                $validated_ips[] = $ip;
            }
        }

        $settings->update(['debug_ips' => !empty($validated_ips) ? json_encode($validated_ips) : null]);

        return redirect()->back()->withSuccess(str_replace(':count', count($validated_ips), __('messages.debug_ips_saved')));
    }

    /**
     * Add current IP to debug IPs list
     */
    public function addMyIpToDebug()
    {
        try {
            $settings = Setting::first();

            if (!$settings) {
                Log::error('Settings not found');
                return redirect()->back()->withError('Settings not found!');
            }

            $currentIp = request()->ip();
            Log::info('Adding IP to debug list', ['ip' => $currentIp]);

            // Get current IPs from database
            $allowedIps = $settings->debug_ips ? json_decode($settings->debug_ips, true) : [];

            // Ensure it's an array
            if (!is_array($allowedIps)) {
                $allowedIps = [];
            }

            Log::info('Current allowed IPs', ['ips' => $allowedIps]);

            // Add current IP if not already in list
            if (!in_array($currentIp, $allowedIps)) {
                $allowedIps[] = $currentIp;
                $settings->debug_ips = json_encode($allowedIps);
                $settings->save();

                Log::info('IP added successfully', ['ip' => $currentIp, 'all_ips' => $allowedIps]);

                return redirect()->back()->withSuccess(str_replace(':ip', $currentIp, __('messages.your_ip_added')));
            }

            Log::info('IP already exists', ['ip' => $currentIp]);
            return redirect()->back()->with('info', str_replace(':ip', $currentIp, __('messages.your_ip_already_exists')));
        } catch (\Exception $e) {
            Log::error('Error adding IP', ['error' => $e->getMessage()]);
            return redirect()->back()->withError('Error adding IP: ' . $e->getMessage());
        }
    }
}
