<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // قائمة اللغات المدعومة
        $supportedLocales = array_keys(config('languages'));

        // الحصول على اللغة من المصادر المختلفة
        $locale = null;

        // 1. من URL path (/locale/en أو /ar/page)
        $urlSegment = $request->segment(1);
        if (in_array($urlSegment, $supportedLocales)) {
            $locale = $urlSegment;
        }

        // 2. من URL path (locale/{locale})
        if (!$locale && $urlSegment === 'locale') {
            $locale = $request->segment(2);
        }

        // 3. من session
        if (!$locale) {
            $locale = session('locale');
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
        session(['locale' => $locale]);

        return $next($request);
    }
}
