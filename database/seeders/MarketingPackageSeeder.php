<?php

namespace Database\Seeders;

use App\Models\MarketingPackage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MarketingPackageSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        MarketingPackage::truncate();
        Schema::enableForeignKeyConstraints();

        $packages = [
            [
                'title_en' => 'Social Media Services',
                'title_ar' => 'خدمات وسائل التواصل',
                'description_en' => 'Professional social media management and content creation',
                'description_ar' => 'إدارة احترافية لوسائل التواصل وإنشاء محتوى',
                'features' => [
                    ['title_en' => 'Content Planning', 'label_en' => 'Content planning and scheduling', 'title_ar' => 'تخطيط المحتوى', 'label_ar' => 'تخطيط ونشر المحتوى'],
                    ['title_en' => 'Engagement', 'label_en' => 'Daily engagement management', 'title_ar' => 'التفاعل', 'label_ar' => 'إدارة التفاعل اليومية'],
                    ['title_en' => 'Community Growth', 'label_en' => 'Community growth strategy', 'title_ar' => 'نمو المجتمع', 'label_ar' => 'استراتيجية نمو المجتمع'],
                    ['title_en' => 'Analytics', 'label_en' => 'Performance analytics', 'title_ar' => 'التحليلات', 'label_ar' => 'تحليلات الأداء'],
                ],
                'image' => 'uploads/marketing-packages/1/planning.png',
                'icon' => '',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title_en' => 'SEO Services',
                'title_ar' => 'خدمات تحسين محركات البحث',
                'description_en' => 'Comprehensive SEO optimization for better search rankings',
                'description_ar' => 'تحسين شامل لمحركات البحث للحصول على تصنيفات أفضل',
                'features' => [
                    ['title_en' => 'Keyword Research', 'label_en' => 'Keyword research and analysis', 'title_ar' => 'بحث الكلمات', 'label_ar' => 'بحث وتحليل الكلمات الرئيسية'],
                    ['title_en' => 'On-page SEO', 'label_en' => 'On-page SEO optimization', 'title_ar' => 'تحسين الصفحة', 'label_ar' => 'تحسين تحسين محرك البحث على الصفحة'],
                    ['title_en' => 'Link Building', 'label_en' => 'Link building campaigns', 'title_ar' => 'بناء الروابط', 'label_ar' => 'حملات بناء الروابط'],
                    ['title_en' => 'Reports', 'label_en' => 'Monthly SEO reports', 'title_ar' => 'التقارير', 'label_ar' => 'تقارير تحسين محركات البحث الشهرية'],
                ],
                'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"> <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 14.93V19h-2v-2.07A8 8 0 0 1 4.07 13H7v-2H4.07A8 8 0 0 1 11 7.07V5h2v2.07A8 8 0 0 1 19.93 11H17v2h2.93A8 8 0 0 1 13 16.93Z"> </path> </svg>',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title_en' => 'Content Marketing',
                'title_ar' => 'تسويق المحتوى',
                'description_en' => 'Strategic content creation and distribution',
                'description_ar' => 'إنشاء وتوزيع المحتوى الاستراتيجي',
                'features' => [
                    ['title_en' => 'Blog Writing', 'label_en' => 'Blog post writing', 'title_ar' => 'كتابة المدونة', 'label_ar' => 'كتابة مشاركات المدونة'],
                    ['title_en' => 'Video Content', 'label_en' => 'Video content creation', 'title_ar' => 'محتوى الفيديو', 'label_ar' => 'إنشاء محتوى الفيديو'],
                    ['title_en' => 'Infographics', 'label_en' => 'Infographic design', 'title_ar' => 'الرسوم البيانية', 'label_ar' => 'تصميم الرسوم البيانية'],
                    ['title_en' => 'Calendar Management', 'label_en' => 'Content calendar management', 'title_ar' => 'إدارة التقويم', 'label_ar' => 'إدارة تقويم المحتوى'],
                ],
                'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"> <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 14.93V19h-2v-2.07A8 8 0 0 1 4.07 13H7v-2H4.07A8 8 0 0 1 11 7.07V5h2v2.07A8 8 0 0 1 19.93 11H17v2h2.93A8 8 0 0 1 13 16.93Z"> </path> </svg>',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title_en' => 'Email Marketing',
                'title_ar' => 'تسويق البريد الإلكتروني',
                'description_en' => 'Email campaigns and automation',
                'description_ar' => 'حملات البريد الإلكتروني والأتمتة',
                'features' => [
                    ['title_en' => 'Campaign Design', 'label_en' => 'Email campaign design', 'title_ar' => 'تصميم الحملات', 'label_ar' => 'تصميم حملات البريد الإلكتروني'],
                    ['title_en' => 'List Management', 'label_en' => 'List management', 'title_ar' => 'إدارة القائمة', 'label_ar' => 'إدارة القائمة'],
                    ['title_en' => 'Automation', 'label_en' => 'Automation workflows', 'title_ar' => 'الأتمتة', 'label_ar' => 'سير العمل الآلي'],
                    ['title_en' => 'Tracking', 'label_en' => 'Performance tracking', 'title_ar' => 'التتبع', 'label_ar' => 'تتبع الأداء'],
                ],
                'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"> <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 14.93V19h-2v-2.07A8 8 0 0 1 4.07 13H7v-2H4.07A8 8 0 0 1 11 7.07V5h2v2.07A8 8 0 0 1 19.93 11H17v2h2.93A8 8 0 0 1 13 16.93Z"> </path> </svg>',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            $translations = [
                'en' => [
                    'title' => $package['title_en'],
                    'description' => $package['description_en'],
                ],
                'ar' => [
                    'title' => $package['title_ar'],
                    'description' => $package['description_ar'],
                ],
            ];

            MarketingPackage::create([
                'slug' => Str::slug($package['title_en']),
                'translations' => $translations,
                'features' => $package['features'],
                'image' => $package['image'] ?? '',
                'icon' => $package['icon'] ?? '',
                'order' => $package['order'],
                'is_active' => $package['is_active'],
                'created_by' => 1,
            ]);
        }
    }
}