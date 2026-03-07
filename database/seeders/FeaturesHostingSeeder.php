<?php

namespace Database\Seeders;

use App\Models\FeaturesHosting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class FeaturesHostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        FeaturesHosting::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        $featuresHostings = [
            [
                'translations_ar' => [
                    'title' => 'السرعة الفائقة',
                    'description' => 'خوادمنا توفر سرعة تحميل فائقة مع أوقات استجابة سريعة جداً لضمان أفضل أداء لموقعك.',
                ],
                'translations_en' => [
                    'title' => 'Lightning Speed',
                    'description' => 'Our servers deliver blazing-fast loading speeds with ultra-low response times for optimal website performance.',
                ],
                'image' => 'features-hostings/1.gif',
                'order' => 1,
            ],
            [
                'translations_ar' => [
                    'title' => 'الأمان المتقدم',
                    'description' => 'حماية شاملة ضد الهجمات السيبرانية مع جدران حماية قوية وشهادات SSL معتمدة.',
                ],
                'translations_en' => [
                    'title' => 'Advanced Security',
                    'description' => 'Comprehensive protection against cyber attacks with powerful firewalls and certified SSL certificates.',
                ],
                'image' => 'features-hostings/2.gif',
                'order' => 2,
            ],
            [
                'translations_ar' => [
                    'title' => 'النسخ الاحتياطي اليومي',
                    'description' => 'نسخ احتياطية تلقائية يومية لجميع بيانات موقعك لضمان عدم فقدان أي معلومات مهمة.',
                ],
                'translations_en' => [
                    'title' => 'Daily Backups',
                    'description' => 'Automatic daily backups of all your website data to ensure no important information is lost.',
                ],
                'image' => 'features-hostings/3.gif',
                'order' => 3,
            ],
            [
                'translations_ar' => [
                    'title' => 'الدعم على مدار الساعة',
                    'description' => 'فريق دعم عملاء متخصص متاح 24/7 للإجابة على جميع أسئلتك والمساعدة في أي مشاكل.',
                ],
                'translations_en' => [
                    'title' => '24/7 Support',
                    'description' => 'Specialized customer support team available 24/7 to answer your questions and help with any issues.',
                ],
                'image' => 'features-hostings/4.gif',
                'order' => 4,
            ],
            [
                'translations_ar' => [
                    'title' => 'لوحة تحكم cPanel',
                    'description' => 'لوحة تحكم سهلة الاستخدام توفر إدارة كاملة لموقعك والبريد الإلكتروني والقواعد البيانات.',
                ],
                'translations_en' => [
                    'title' => 'cPanel Control Panel',
                    'description' => 'Easy-to-use control panel providing complete management of your website, email, and databases.',
                ],
                'image' => 'features-hostings/5.gif',
                'order' => 5,
            ],
            [
                'translations_ar' => [
                    'title' => 'شهادات SSL مجانية',
                    'description' => 'شهادات SSL مجانية لتشفير الاتصالات وحماية بيانات زوار موقعك بأمان تام.',
                ],
                'translations_en' => [
                    'title' => 'Free SSL Certificates',
                    'description' => 'Free SSL certificates to encrypt communications and protect your visitors\' data with complete security.',
                ],
                'image' => 'features-hostings/6.gif',
                'order' => 6,
            ],
            [
                'translations_ar' => [
                    'title' => 'الأداء العالي',
                    'description' => 'استخدام أحدث تقنيات الخادم والمعالجات لضمان أداء عالي جداً وثبات دائم.',
                ],
                'translations_en' => [
                    'title' => 'High Performance',
                    'description' => 'Using the latest server technology and processors to ensure extremely high performance and constant stability.',
                ],
                'image' => 'features-hostings/7.gif',
                'order' => 7,
            ],
            [
                'translations_ar' => [
                    'title' => 'تثبيت WordPress سهل',
                    'description' => 'تثبيت WordPress بنقرة واحدة مع جميع الإضافات الأساسية والمكونات اللازمة.',
                ],
                'translations_en' => [
                    'title' => 'Easy WordPress Installation',
                    'description' => 'One-click WordPress installation with all essential plugins and required components.',
                ],
                'image' => 'features-hostings/8.gif',
                'order' => 8,
            ],
        ];

        foreach ($featuresHostings as $feature) {
            FeaturesHosting::create([
                'translations' => [
                    'ar' => $feature['translations_ar'],
                    'en' => $feature['translations_en'],
                ],
                'image' => $feature['image'],
                'order' => $feature['order'],
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            echo "✓ FeaturesHosting '{$feature['translations_en']['title']}' created successfully\n";
        }

        echo "\n✅ 8 FeaturesHostings seeded successfully!\n";
    }
}
