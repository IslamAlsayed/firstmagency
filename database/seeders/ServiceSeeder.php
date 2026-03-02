<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) return; // لا توجد مستخدمين

        $servicesData = [
            [
                'ar' => [
                    'title' => 'تطوير المواقع',
                    'description' => 'نقدم خدمات احترافية في تطوير المواقع الإلكترونية المتكاملة…',
                    'content' => 'محتوى الخدمة حول تطوير المواقع...',
                    'keywords' => 'تطوير، مواقع، ويب',
                    'meta_description' => 'خدمات تطوير المواقع الإلكترونية',
                ],
                'en' => [
                    'title' => 'Web Development',
                    'description' => 'We provide professional web development services...',
                    'content' => 'Service content about web development...',
                    'keywords' => 'web, development, sites',
                    'meta_description' => 'Professional web development services',
                ],
                'icon' => 'website.png',
                'image' => 'website.png',
                'order' => 1,
            ],
            [
                'ar' => [
                    'title' => 'تطوير تطبيقات الموبايل',
                    'description' => 'تطوير تطبيقات موبايل احترافية لجميع الأنظمة…',
                    'content' => 'محتوى الخدمة حول تطبيقات الموبايل...',
                    'keywords' => 'تطبيقات، موبايل، iOS',
                    'meta_description' => 'تطوير تطبيقات الموبايل المتقدمة',
                ],
                'en' => [
                    'title' => 'Mobile App Development',
                    'description' => 'Professional mobile application development...',
                    'content' => 'Service content about mobile development...',
                    'keywords' => 'mobile, app, iOS, Android',
                    'meta_description' => 'Advanced mobile app development services',
                ],
                'icon' => 'mobile.png',
                'image' => 'mobile.png',
                'order' => 2,
            ],
            [
                'ar' => [
                    'title' => 'التسويق الرقمي',
                    'description' => 'استراتيجيات تسويق رقمي فعالة لنمو عملك…',
                    'content' => 'محتوى الخدمة حول التسويق الرقمي...',
                    'keywords' => 'تسويق، رقمي، SEO',
                    'meta_description' => 'خدمات التسويق الرقمي الشاملة',
                ],
                'en' => [
                    'title' => 'Digital Marketing',
                    'description' => 'Effective digital marketing strategies for growth...',
                    'content' => 'Service content about digital marketing...',
                    'keywords' => 'marketing, digital, SEO',
                    'meta_description' => 'Comprehensive digital marketing services',
                ],
                'icon' => 'marketing.png',
                'image' => 'marketing.png',
                'order' => 3,
            ],
            [
                'ar' => [
                    'title' => 'استضافة المواقع',
                    'description' => 'استضافة موثوقة وآمنة لمواقعك…',
                    'content' => 'محتوى الخدمة حول الاستضافة...',
                    'keywords' => 'استضافة، سيرفر، ويب',
                    'meta_description' => 'خدمات استضافة المواقع الموثوقة',
                ],
                'en' => [
                    'title' => 'Web Hosting',
                    'description' => 'Reliable and secure web hosting services...',
                    'content' => 'Service content about web hosting...',
                    'keywords' => 'hosting, server, web',
                    'meta_description' => 'Reliable web hosting services',
                ],
                'icon' => 'hosting.png',
                'image' => 'hosting.png',
                'order' => 4,
            ],
            [
                'ar' => [
                    'title' => 'تسجيل النطاقات',
                    'description' => 'تسجيل وإدارة نطاقات احترافية…',
                    'content' => 'محتوى الخدمة حول النطاقات...',
                    'keywords' => 'نطاق، دومين، تسجيل',
                    'meta_description' => 'خدمات تسجيل النطاقات',
                ],
                'en' => [
                    'title' => 'Domain Registration',
                    'description' => 'Professional domain registration and management...',
                    'content' => 'Service content about domain registration...',
                    'keywords' => 'domain, registration, DNS',
                    'meta_description' => 'Domain registration services',
                ],
                'icon' => 'domains.png',
                'image' => 'domains.png',
                'order' => 5,
            ],
        ];

        foreach ($servicesData as $data) {
            $translations = [
                'ar' => $data['ar'],
                'en' => $data['en'],
            ];
            unset($data['ar'], $data['en']);

            Service::create([
                ...$data,
                'translations' => $translations,
                'status' => 'active',
                'is_active' => true,
                'featured' => false,
                'created_by' => $user->id,
            ]);
        }
    }
}
