<?php

namespace Database\Seeders;

use App\Models\FeaturesHosting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
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

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/hosting/gifs');
        $destBasePath = storage_path('app/public/uploads/features-hosting');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        $featuresHosting = [
            [
                'translations_ar' => [
                    'title' => 'السرعة الفائقة',
                    'description' => 'خوادمنا توفر سرعة تحميل فائقة مع أوقات استجابة سريعة جداً لضمان أفضل أداء لموقعك.',
                ],
                'translations_en' => [
                    'title' => 'Lightning Speed',
                    'description' => 'Our servers deliver blazing-fast loading speeds with ultra-low response times for optimal website performance.',
                ],
                'file_index' => 1,
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
                'file_index' => 2,
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
                'file_index' => 3,
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
                'file_index' => 4,
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
                'file_index' => 5,
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
                'file_index' => 6,
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
                'file_index' => 7,
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
                'file_index' => 8,
                'order' => 8,
            ],
        ];

        foreach ($featuresHosting as $feature) {
            $sourceFile = $sourcePath . '/' . $feature['file_index'] . '.gif';

            if (!File::exists($sourceFile)) {
                echo "⚠️  Source file not found: $sourceFile\n";
                continue;
            }

            // Create directory for this feature
            $featureDir = $destBasePath . '/' . $feature['file_index'];
            if (!File::isDirectory($featureDir)) {
                File::makeDirectory($featureDir, 0755, true);
            }

            // Copy the image with a new name
            $destFileName = 'feature_' . $feature['file_index'] . '.gif';
            $destFile = $featureDir . '/' . $destFileName;

            // Only copy if destination doesn't exist
            if (!File::exists($destFile)) {
                File::copy($sourceFile, $destFile);
            }

            // Save relative path for database storage (like: uploads/features-hosting/1/feature_1.gif)
            $imagePath = 'uploads/features-hosting/' . $feature['file_index'] . '/' . $destFileName;

            FeaturesHosting::create([
                'translations' => [
                    'ar' => $feature['translations_ar'],
                    'en' => $feature['translations_en'],
                ],
                'image' => $imagePath,
                'order' => $feature['order'],
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            echo "✓ FeaturesHosting '{$feature['translations_en']['title']}' created with image: $imagePath\n";
        }

        echo "\n✅ 8 FeaturesHosting seeded successfully!\n";
        echo "📁 Images stored in: $destBasePath\n";
    }
}
