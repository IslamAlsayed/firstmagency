<?php

namespace Database\Seeders;

use App\Models\OfficialDomain;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OfficialDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        OfficialDomain::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        // Domain type data matching the config structure
        $domainTypes = [
            [
                'slug' => 'com-eg-net-eg',
                'title' => 'COM.EG / NET.EG',
                'badge_ar' => 'قرار إنشاء للشركات الحكومية',
                'badge_en' => 'قرار إنشاء للشركات الحكومية',
                'description_ar' => 'منتجات وخدمات الشركات، مع تقديم إقرار من الشركة طالبة التسجيل على تبعية اسم الدومين المراد تسجيله لها مع تقديم ما يثبت وجود هذا المنتج أو الخدمة للشركة كتقديم مجلد دعائي أو صورة للمنتج أو للحملة الدعائية أو أي صورة مادية بأي شكل من الأشكال المستخدمة في الترويج للمنتج أو الخدمة.',
                'description_en' => 'Domains for Egyptian commercial companies and commercial services',
            ],
            // [
            //     'slug' => 'org-eg',
            //     'title' => 'ORG.EG',
            //     'name_ar' => 'ORG.EG',
            //     'name_en' => 'ORG.EG',
            //     'description_ar' => 'نطاقات للجمعيات الأهلية والمنظمات',
            //     'description_en' => 'Domains for NGOs and organizations',
            // ],
            // [
            //     'slug' => 'edu-eg',
            //     'title' => 'EDU.EG',
            //     'name_ar' => 'EDU.EG',
            //     'name_en' => 'EDU.EG',
            //     'description_ar' => 'نطاقات للمؤسسات التعليمية المصرية',
            //     'description_en' => 'Domains for Egyptian educational institutions',
            // ],
            // [
            //     'slug' => 'sci-eg',
            //     'title' => 'SCI.EG',
            //     'name_ar' => 'SCI.EG',
            //     'name_en' => 'SCI.EG',
            //     'description_ar' => 'نطاقات للمؤسسات العلمية والبحثية',
            //     'description_en' => 'Domains for scientific and research institutions',
            // ],
        ];

        // Create official domains
        foreach ($domainTypes as $index => $data) {
            // Create or update official domain record
            OfficialDomain::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'translations' => [
                        'ar' => [
                            'badge' => $data['badge_ar'],
                            'description' => $data['description_ar'],
                        ],
                        'en' => [
                            'badge' => $data['badge_en'],
                            'description' => $data['description_en'],
                        ],
                    ],
                    'title' => $data['title'],
                    'order' => $index,
                    'status' => 'published',
                    'is_active' => rand(0, 1),
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }
    }
}
