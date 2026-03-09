<?php

namespace Database\Seeders;

use App\Models\PlatformManagement;
use Illuminate\Database\Seeder;

class PlatformManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'translations' => [
                    'en' => [
                        'title' => 'Facebook',
                        'description' => 'Reach millions of users on the world\'s largest social network and grow your business presence.',
                    ],
                    'ar' => [
                        'title' => 'فيسبوك',
                        'description' => 'تواصل مع ملايين المستخدمين على أكبر شبكة اجتماعية في العالم وطور حضورك التجاري.',
                    ],
                ],
                'order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'translations' => [
                    'en' => [
                        'title' => 'Instagram',
                        'description' => 'Showcase your brand with visually stunning content and connect with your audience on Instagram.',
                    ],
                    'ar' => [
                        'title' => 'إنستجرام',
                        'description' => 'اعرض علامتك التجارية من خلال محتوى بصري مذهل وتواصل مع جمهورك على إنستجرام.',
                    ],
                ],
                'order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'translations' => [
                    'en' => [
                        'title' => 'Google Ads',
                        'description' => 'Maximize your online visibility and drive targeted traffic with powerful Google advertising solutions.',
                    ],
                    'ar' => [
                        'title' => 'إعلانات جوجل',
                        'description' => 'زد ظهورك على الإنترنت واجذب حركة مرور مستهدفة باستخدام حلول الإعلان القوية من جوجل.',
                    ],
                ],
                'order' => 3,
                'is_active' => true,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'translations' => [
                    'en' => [
                        'title' => 'Snapchat Ads',
                        'description' => 'Connect with younger audiences through engaging Snapchat advertising campaigns and creative content.',
                    ],
                    'ar' => [
                        'title' => 'إعلانات سناب شات',
                        'description' => 'تواصل مع الجماهير الأصغر سناً من خلال حملات إعلانية جذابة على سناب شات ومحتوى إبداعي.',
                    ],
                ],
                'order' => 4,
                'is_active' => true,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'translations' => [
                    'en' => [
                        'title' => 'TikTok',
                        'description' => 'Tap into viral marketing potential and reach Gen Z audiences with trending TikTok content strategies.',
                    ],
                    'ar' => [
                        'title' => 'تيك توك',
                        'description' => 'استفد من إمكانيات التسويق الفيروسي والوصول إلى جماهير جيل الألفية من خلال استراتيجيات محتوى تيك توك.',
                    ],
                ],
                'order' => 5,
                'is_active' => true,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'translations' => [
                    'en' => [
                        'title' => 'SEO Services',
                        'description' => 'Improve your search engine rankings and organic visibility with our comprehensive SEO optimization services.',
                    ],
                    'ar' => [
                        'title' => 'خدمات تحسين محركات البحث',
                        'description' => 'حسّن ترتيبك في محركات البحث والظهور العضوي من خلال خدمات تحسين محركات البحث الشاملة.',
                    ],
                ],
                'order' => 6,
                'is_active' => true,
                'is_featured' => false,
                'status' => 'published',
            ],
        ];

        foreach ($items as $item) {
            $item['created_by'] = 1;
            PlatformManagement::create($item);
        }
    }
}
