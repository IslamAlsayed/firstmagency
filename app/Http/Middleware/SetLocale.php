<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // قائمة اللغات المدعومة
        $supportedLocales = array_keys(config('languages'));

        // تحديد ما إذا كان الطلب للداشبورد أم الموقع بناءً على الـ URL
        // الداشبورد: /dashboard/locale/{locale}
        // الموقع: /locale/{locale}
        $isDashboard = $request->segment(1) === 'dashboard' && $request->segment(2) === 'locale';
        $isWebsiteLocale = $request->segment(1) === 'locale';

        // الحصول على اللغة من المصادر المختلفة
        $locale = null;

        // 1. من URL path
        if ($isWebsiteLocale) {
            $locale = $request->segment(2);
        } elseif ($isDashboard) {
            $locale = $request->segment(3);
        }

        // 2. من session (اختر اللغة المناسبة حسب النوع)
        if (!$locale) {
            if ($isDashboard || $request->segment(1) === 'dashboard') {
                $locale = session('dashboard_locale');
            } else {
                $locale = session('website_locale');
            }
        }

        // 3. من قاعدة البيانات (للمستخدم المسجل)
        if (!$locale && Auth::check()) {
            if ($isDashboard || $request->segment(1) === 'dashboard') {
                $locale = Auth::user()?->dashboard_locale;
            } else {
                $locale = Auth::user()?->website_locale;
            }
        }

        // 4. الافتراضية
        if (!$locale) {
            $locale = config('app.locale', 'ar');
        }

        // التحقق من صحة اللغة
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale', 'ar');
        }

        // تعيين اللغة
        App::setLocale($locale);

        // حفظ في session بالمفتاح المناسب
        if ($isDashboard || $request->segment(1) === 'dashboard') {
            session(['dashboard_locale' => $locale]);
        } else {
            session(['website_locale' => $locale]);
        }

        return $next($request);
    }
}
