<?php

namespace Database\Seeders;

use App\Models\HostingFeature;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class HostingFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        HostingFeature::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        $hostingFeatures = [
            [
                'slug' => 'lightning-speed',
                'translations' => [
                    'ar' => [
                        'title' => 'السرعة الفائقة',
                        'description' => 'خوادمنا توفر سرعة تحميل فائقة مع أوقات استجابة سريعة جداً لضمان أفضل أداء لموقعك.',
                    ],
                    'en' => [
                        'title' => 'Lightning Speed',
                        'description' => 'Our servers deliver blazing-fast loading speeds with ultra-low response times for optimal website performance.',
                    ],
                ],
                'image' => '1.gif',
                'order' => 1,
            ],
            [
                'slug' => '',
                'translations' => [
                    'ar' => [
                        'title' => 'الأمان المتقدم',
                        'description' => 'حماية شاملة ضد الهجمات السيبرانية مع جدران حماية قوية وشهادات SSL معتمدة.',
                    ],
                    'en' => [
                        'title' => 'Advanced Security',
                        'description' => 'Comprehensive protection against cyber attacks with powerful firewalls and certified SSL certificates.',
                    ],
                ],
                'image' => '2.gif',
                'order' => 2,
            ],
            [
                'slug' => 'daily-backups',
                'translations' => [
                    'ar' => [
                        'title' => 'النسخ الاحتياطي اليومي',
                        'description' => 'نسخ احتياطية تلقائية يومية لجميع بيانات موقعك لضمان عدم فقدان أي معلومات مهمة.',
                    ],
                    'en' => [
                        'title' => 'Daily Backups',
                        'description' => 'Automatic daily backups of all your website data to ensure no important information is lost.',
                    ],
                ],
                'image' => '3.gif',
                'order' => 3,
            ],
            [
                'slug' => '24-7-support',
                'translations' => [
                    'ar' => [
                        'title' => 'الدعم على مدار الساعة',
                        'description' => 'فريق دعم عملاء متخصص متاح 24/7 للإجابة على جميع أسئلتك والمساعدة في أي مشاكل.',
                    ],
                    'en' => [
                        'title' => '24/7 Support',
                        'description' => 'Specialized customer support team available 24/7 to answer your questions and help with any issues.',
                    ],
                ],
                'image' => '4.gif',
                'order' => 4,
            ],
            [
                'slug' => 'cpanel-control-panel',
                'translations' => [
                    'ar' => [
                        'title' => 'لوحة تحكم cPanel',
                        'description' => 'لوحة تحكم سهلة الاستخدام توفر إدارة كاملة لموقعك والبريد الإلكتروني والقواعد البيانات.',
                    ],
                    'en' => [
                        'title' => 'cPanel Control Panel',
                        'description' => 'Easy-to-use control panel providing complete management of your website, email, and databases.',
                    ],
                ],
                'image' => '5.gif',
                'order' => 5,
            ],
            [
                'slug' => 'free-ssl-certificates',
                'translations' => [
                    'ar' => [
                        'title' => 'شهادات SSL مجانية',
                        'description' => 'شهادات SSL مجانية لتشفير الاتصالات وحماية بيانات زوار موقعك بأمان تام.',
                    ],
                    'en' => [
                        'title' => 'Free SSL Certificates',
                        'description' => 'Free SSL certificates to encrypt communications and protect your visitors\' data with complete security.',
                    ],
                ],
                'image' => '6.gif',
                'order' => 6,
            ],
            [
                'slug' => 'high-performance',
                'translations' => [
                    'ar' => [
                        'title' => 'الأداء العالي',
                        'description' => 'استخدام أحدث تقنيات الخادم والمعالجات لضمان أداء عالي جداً وثبات دائم.',
                    ],
                    'en' => [
                        'title' => 'High Performance',
                        'description' => 'Using the latest server technology and processors to ensure extremely high performance and constant stability.',
                    ],
                ],
                'image' => '7.gif',
                'order' => 7,
            ],
            [
                'slug' => 'easy-wordpress-installation',
                'translations' => [
                    'ar' => [
                        'title' => 'تثبيت WordPress سهل',
                        'description' => 'تثبيت WordPress بنقرة واحدة مع جميع الإضافات الأساسية والمكونات اللازمة.',
                    ],
                    'en' => [
                        'title' => 'Easy WordPress Installation',
                        'description' => 'One-click WordPress installation with all essential plugins and required components.',
                    ],
                ],
                'image' => '8.gif',
                'order' => 8,
            ],
        ];

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/hosting/gifs');
        $destBasePath = storage_path('app/public/uploads/hosting-features');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        foreach ($hostingFeatures as $i => $data) {
            $sourceImageFile = $sourcePath . '/' . $data['image'];

            if (!File::exists($sourceImageFile)) {
                echo "⚠️  Source file not found for portfolio index " . ($i + 1) . ": $sourceImageFile\n";
                continue;
            }

            // Create directory for this portfolio item
            $mainDir = $destBasePath . '/' . ($i + 1);
            if (!File::isDirectory($mainDir)) {
                File::makeDirectory($mainDir, 0755, true);
            }

            // Copy the main image
            $destImageFile = $mainDir . '/' . $data['image'];
            if (!File::exists($destImageFile)) {
                File::copy($sourceImageFile, $destImageFile);
            }

            // Save relative paths for database storage
            $data['slug'] = strtolower(str_replace(' ', '-', $data['slug'] ?? $data['translations']['en']['title'] ?? 'feature-' . ($i + 1)));
            $data['image'] = 'uploads/hosting-features/' . ($i + 1) . '/' . $data['image'];

            HostingFeature::create([
                ...$data,
                'is_active' => true,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}