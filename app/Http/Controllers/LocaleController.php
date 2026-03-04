<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function change($locale, Request $request)
    {
        $supportedLocales = array_keys(config('languages'));

        // التحقق من أن اللغة مدعومة
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale', 'ar');
        }

        // تحديد ما إذا كان الطلب للداشبورد أم الموقع
        $isDashboard = $request->segment(1) === 'dashboard';

        // حفظ اللغة في قاعدة البيانات والـ session بناءً على النوع
        if (Auth::check()) {
            $user = Auth::user();
            if ($isDashboard) {
                // تحديث لغة الداشبورد فقط
                $user->dashboard_locale = $locale;
            } else {
                // تحديث لغة الموقع فقط
                $user->website_locale = $locale;
            }
            /** @var \App\Models\User $user */
            $user->save();
        }

        // حفظ في session
        if ($isDashboard) {
            session(['dashboard_locale' => $locale]);
        } else {
            session(['website_locale' => $locale]);
        }

        showToastSuccessMessage('Locale updated successfully.');

        return redirect()->back();
    }
}
