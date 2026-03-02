<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class LocaleController extends Controller
{
    public function change($locale)
    {
        $supportedLocales = array_keys(config('languages'));

        // التحقق من أن اللغة مدعومة
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale', 'ar');
        }

        // حفظ اللغة في الـ session
        session(['locale' => $locale]);

        // تعيين اللغة الحالية للـ app
        app()->setLocale($locale);

        // حفظ اللغة في قاعدة البيانات للمستخدم المسجل
        if (Auth::check()) {
            Setting::query()->update(['site_locale' => $locale]);
            showToastSuccessMessage('Locale updated successfully.');
        }

        return redirect()->back();
    }
}
