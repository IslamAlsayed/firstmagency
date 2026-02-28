<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class LocaleController extends Controller
{
    public function change($locale)
    {
        if (!in_array($locale, ['en', 'ar'])) {
            $locale = 'ar';
        }
        session(['locale' => $locale]);
        app()->setLocale($locale);
        if (Setting::query()->update(['site_locale' => $locale])) {
            if (Auth::check()) {
                return redirect()->back()->withSuccess('Locale updated successfully.');
            }
            // Locale updated successfully
        }
        return redirect()->back();
    }
}
