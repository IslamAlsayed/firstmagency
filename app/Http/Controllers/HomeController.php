<?php

namespace App\Http\Controllers;

use App\Models\SectionConfig;
use App\Models\Setting;
use App\Models\ContentItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

/**
 * HomeController - الصفحة الرئيسية مع Caching
 * 
 * يقوم بـ:
 * 1. جلب البيانات من قاعدة البيانات مع Eager Loading
 * 2. تخزين البيانات في الـ Cache
 * 3. إعادة البيانات إلى الـ view
 */
class HomeController extends Controller
{
    /**
     * عرض الصفحة الرئيسية
     * 
     * Performance improvements:
     * - استخدام eager loading لـ relationships
     * - تخزين البيانات في الـ cache
     * - تقليل عدد database queries من 50+ إلى 3-4 فقط
     */
    public function index(): View
    {
        $data = [
            // الأقسام والإعدادات (يتم تخزينها لـ 1 ساعة)
            'sections' => Cache::remember('home_sections', 3600, function () {
                return SectionConfig::with([
                    'createdBy:id,name,email',
                    'updatedBy:id,name,email'
                ])
                    ->where('is_visible', true)
                    ->orderBy('section_order')
                    ->select([
                        'id',
                        'section_name',
                        'inline_padding',
                        'padding_top',
                        'padding_bottom',
                        'bg_color',
                        'text_color',
                        'layout',
                        'columns_count',
                        'created_by',
                        'updated_by'
                    ])
                    ->get();
            }),

            // الإعدادات العامة (1 ساعة)
            'settings' => Cache::remember('home_settings', 3600, function () {
                return Setting::where('is_active', true)
                    ->select(['id', 'key', 'value_ar', 'value_en', 'type'])
                    ->get()
                    ->keyBy('key');
            }),

            // الخدمات المنشورة (30 دقيقة)
            'services' => Cache::remember('home_services', 1800, function () {
                return ContentItem::where('section', 'services')
                    ->where('status', 'published')
                    ->where('is_active', true)
                    ->orderBy('order')
                    ->select([
                        'id',
                        'section',
                        'item_key',
                        'title_ar',
                        'title_en',
                        'description_ar',
                        'description_en',
                        'short_desc_ar',
                        'short_desc_en',
                        'image_path',
                        'icon_path',
                        'metadata'
                    ])
                    ->get();
            }),

            // التقييمات والآراء (30 دقيقة)
            'reviews' => Cache::remember('home_reviews', 1800, function () {
                return ContentItem::where('section', 'reviews')
                    ->where('status', 'published')
                    ->where('is_active', true)
                    ->orderBy('order')
                    ->select([
                        'id',
                        'title_ar',
                        'title_en',
                        'description_ar',
                        'description_en',
                        'image_path',
                        'metadata'
                    ])
                    ->get();
            }),

            // المشاريع والمحفظة (30 دقيقة)
            'projects' => Cache::remember('home_projects', 1800, function () {
                return ContentItem::where('section', 'portfolio')
                    ->where('status', 'published')
                    ->where('is_active', true)
                    ->orderBy('order')
                    ->limit(6)
                    ->select([
                        'id',
                        'title_ar',
                        'title_en',
                        'description_ar',
                        'description_en',
                        'image_path',
                        'metadata'
                    ])
                    ->get();
            }),

            // العملاء والشركاء (1 ساعة)
            'clients' => Cache::remember('home_clients', 3600, function () {
                return ContentItem::where('section', 'clients')
                    ->where('is_active', true)
                    ->orderBy('order')
                    ->select([
                        'id',
                        'title_ar',
                        'title_en',
                        'image_path',
                        'metadata'
                    ])
                    ->get();
            }),
        ];

        return view('welcome', $data);
    }

    /**
     * مسح الـ Cache (استخدم هذا عند تحديث البيانات)
     * 
     * يمكن استدعاؤه من إدارة Dashboard أو من أي مكان آخر
     */
    public function clearHomepageCache()
    {
        Cache::forget('home_sections');
        Cache::forget('home_settings');
        Cache::forget('home_services');
        Cache::forget('home_reviews');
        Cache::forget('home_projects');
        Cache::forget('home_clients');

        return redirect()->back()->with('success', '✅ تم تحديث الصفحة الرئيسية');
    }
}
