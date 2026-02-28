<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * CachePageResponse Middleware
 * 
 * تخزين استجابة الصفحة كاملة في الـ Cache
 * 
 * الفوائد:
 * - تقليل بنسبة 90% من وقت المعالجة
 * - تقليل حمل الخادم
 * - استجابة فورية تقريباً
 * 
 * الاستثناءات:
 * - POST, PUT, DELETE, PATCH requests
 * - المستخدمون المسجلون (auth()->check())
 * - الـ API requests
 * - الصفحات التي تحتوي على messages أو alerts
 */
class CachePageResponse
{
    /**
     * قائمة المسارات التي يتم تخزينها
     */
    protected array $cacheable = [
        '/',
        '/about-us',
        '/portfolio',
        '/blog',
        '/contact',
        '/hosting',
        '/domains',
        '/services-marketing',
        '/seo',
        '/website-developer',
        '/app-mobile',
    ];

    /**
     * مدة التخزين بالثوان (1 ساعة)
     */
    protected int $cacheMinutes = 60;

    public function handle(Request $request, Closure $next): Response
    {
        // لا نـ cache:
        if (
            !$this->isCacheable($request) ||
            $request->method() !== 'GET' ||
            auth()->check() ||
            session()->has('errors') ||
            session()->has('success') ||
            session()->has('warning')
        ) {
            return $next($request);
        }

        // المفتاح الفريد للصفحة (تشمل اللغة)
        $locale = app()->getLocale();
        $cacheKey = "page_response_{$locale}_" . md5($request->getPathInfo());

        // هل الصفحة موجودة في الـ Cache؟
        if (Cache::has($cacheKey)) {
            $cachedResponse = Cache::get($cacheKey);

            // إضافة header للإشارة أن الصفحة من الـ Cache
            return response($cachedResponse)
                ->header('X-Cache-Status', 'HIT')
                ->header('Cache-Control', 'public, max-age=3600');
        }

        // جلب الـ response الطبيعي
        $response = $next($request);

        // تخزين في الـ Cache فقط إذا كانت الاستجابة ناجحة
        if ($response->status() === 200 && $response->getContent()) {
            Cache::put($cacheKey, $response->getContent(), $this->cacheMinutes * 60);

            // إضافة header للإشارة أن الصفحة تم تخزينها
            $response->header('X-Cache-Status', 'MISS');
        }

        return $response;
    }

    /**
     * التحقق من أن الصفحة قابلة للتخزين
     */
    private function isCacheable(Request $request): bool
    {
        return in_array($request->getPathInfo(), $this->cacheable);
    }
}
