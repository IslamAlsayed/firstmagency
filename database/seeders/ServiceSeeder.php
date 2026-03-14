<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Service::truncate();
        Schema::enableForeignKeyConstraints();

        $user = User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) return; // لا توجد مستخدمين

        $servicesData = [
            [
                'translations' => [
                    'ar' => [
                        'title' => 'تطوير المواقع',
                        'description' => 'نقدّم خدمة تصميم مواقع احترافية تجمع بين الشكل العصري والأداء السريع وتجربة المستخدم السلسة. نصمّم موقعك بهوية قوية ومتجاوب 100%',
                        'content' => 'محتوى الخدمة حول تطوير المواقع...',
                        'keywords' => 'تطوير، مواقع، ويب',
                        'meta_description' => 'خدمات تطوير المواقع الإلكترونية',
                    ],
                    'en' => [
                        'title' => 'Web Development',
                        'description' => 'We provide professional web development services that combine modern design, fast performance, and a seamless user experience. We design your website with a strong identity and 100% responsive.',
                        'content' => 'Service content about web development...',
                        'keywords' => 'web, development, sites',
                        'meta_description' => 'Professional web development services',
                    ],
                ],
                'slug' => 'web-development',
                'icon' => '1.jpg',
                'image' => 'icon-1.png',
                'order' => 1,
            ],
            [
                'translations' => [
                    'ar' => [
                        'title' => 'تطوير تطبيقات الموبايل',
                        'description' => 'نطوّر تطبيقات أندرويد وiOS بتصميم عصري وأداء سريع، مع لوحة تحكم وربط API وأمان عالي—من الفكرة حتى النشر على المتاجر.',
                        'content' => 'محتوى الخدمة حول تطبيقات الموبايل...',
                        'keywords' => 'تطبيقات، موبايل، iOS',
                        'meta_description' => 'تطوير تطبيقات الموبايل المتقدمة',
                    ],
                    'en' => [
                        'title' => 'Mobile App Development',
                        'description' => 'We develop Android and iOS applications with modern design and fast performance, including a control panel, API integration, and high security—from concept to publishing on stores.',
                        'content' => 'Service content about mobile development...',
                        'keywords' => 'mobile, app, iOS, Android',
                        'meta_description' => 'Advanced mobile app development services',
                    ],
                ],
                'slug' => 'mobile-app-development',
                'icon' => '2.jpg',
                'image' => 'icon-2.png',
                'order' => 2,
            ],
            [
                'translations' => [
                    'ar' => [
                        'title' => 'التسويق الرقمي',
                        'description' => 'نقدّم تسويقًا رقميًا ذكيًا يحوّل جمهورك إلى عملاء، عبر حملات مدروسة وصناعة محتوى احترافي وتحسين مستمر للأداء—لتحقيق نمو واضح ونتائج قابلة للقياس.',
                        'content' => 'محتوى الخدمة حول التسويق الرقمي...',
                        'keywords' => 'تسويق، رقمي، SEO',
                        'meta_description' => 'خدمات التسويق الرقمي الشاملة',
                    ],
                    'en' => [
                        'title' => 'Digital Marketing',
                        'description' => 'We provide smart digital marketing that turns your audience into customers, through well-planned campaigns, professional content creation, and continuous performance improvement—to achieve clear growth and measurable results.',
                        'content' => 'Service content about digital marketing...',
                        'keywords' => 'marketing, digital, SEO',
                        'meta_description' => 'Comprehensive digital marketing services',
                    ],
                ],
                'slug' => 'digital-marketing',
                'icon' => '3.jpg',
                'image' => 'icon-3.png',
                'order' => 3,
            ],
            [
                'translations' => [
                    'ar' => [
                        'title' => 'استضافة المواقع',
                        'description' => 'استضافة سريعة وآمنة تضمن ثبات موقعك 24/7، بأداء قوي وسيرفرات مستقرة ودعم فني جاهز—لتجربة تصفح سلسة وتحميل أسرع وتحسين نتائجك على محركات البحث.',
                        'content' => 'محتوى الخدمة حول الاستضافة...',
                        'keywords' => 'استضافة، سيرفر، ويب',
                        'meta_description' => 'خدمات استضافة المواقع الموثوقة',
                    ],
                    'en' => [
                        'title' => 'Web Hosting',
                        'description' => 'Fast and secure hosting that ensures your website is up 24/7, with strong performance, stable servers, and ready technical support—for a smooth browsing experience, faster loading, and improved search engine results.',
                        'content' => 'Service content about web hosting...',
                        'keywords' => 'hosting, server, web',
                        'meta_description' => 'Reliable web hosting services',
                    ],
                ],
                'slug' => 'web-hosting',
                'icon' => '4.jpg',
                'image' => 'icon-4.png',
                'order' => 4,
            ],
            [
                'translations' => [
                    'ar' => [
                        'title' => 'تسجيل النطاقات',
                        'description' => 'احجز دومين احترافي باسم يعبر عن نشاطك ويثبت علامتك التجارية، مع خيارات متعددة لأشهر الامتدادات وتجديد سهل ودعم كامل—لتبدأ حضورك على الإنترنت بثقة.',
                        'content' => 'محتوى الخدمة حول النطاقات...',
                        'keywords' => 'نطاق، دومين، تسجيل',
                        'meta_description' => 'خدمات تسجيل النطاقات',
                    ],
                    'en' => [
                        'title' => 'Domain Registration',
                        'description' => 'Register a professional domain name that represents your business and strengthens your brand, with multiple options for popular extensions, easy renewal, and full support—to start your online presence with confidence.',
                        'content' => 'Service content about domain registration...',
                        'keywords' => 'domain, registration, DNS',
                        'meta_description' => 'Domain registration services',
                    ],
                ],
                'slug' => 'domain-registration',
                'icon' => '5.jpg',
                'image' => 'icon-5.png',
                'order' => 5,
            ],
        ];

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/services');
        $destBasePath = storage_path('app/public/uploads/services');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        foreach ($servicesData as $i => $data) {
            $sourceImageFile = $sourcePath . '/' . $data['image'];
            $sourceIconFile = $sourcePath . '/' . $data['icon'];

            if (!File::exists($sourceImageFile) || !File::exists($sourceIconFile)) {
                echo "⚠️  Source files not found for service index " . ($i + 1) . ": $sourceImageFile or $sourceIconFile\n";
                continue;
            }

            // Create directory for this service
            $mainDir = $destBasePath . '/' . ($i + 1);
            if (!File::isDirectory($mainDir)) {
                File::makeDirectory($mainDir, 0755, true);
            }

            // Copy the main image
            $destImageFile = $mainDir . '/' . $data['image'];
            if (!File::exists($destImageFile)) {
                File::copy($sourceImageFile, $destImageFile);
            }

            // Copy the icon image
            $destIconFile = $mainDir . '/' . $data['icon'];
            if (!File::exists($destIconFile)) {
                File::copy($sourceIconFile, $destIconFile);
            }

            // Save relative paths for database storage
            $data['image'] = 'uploads/services/' . ($i + 1) . '/' . $data['image'];
            $data['icon'] = 'uploads/services/' . ($i + 1) . '/' . $data['icon'];
            Service::create([
                ...$data,
                'is_active' => true,
                'is_featured' => false,
                'created_by' => $user->id,
            ]);
        }
    }
}