<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        $companies = [
            [
                'translations' => [
                    'ar' => [
                        'name' => 'شركة تقنية رائدة',
                        'description' => 'متخصصة في تطوير الحلول الرقمية والبرمجيات',
                    ],
                    'en' => [
                        'name' => 'Leading Tech Company',
                        'description' => 'Specialized in developing digital solutions and software',
                    ],
                ],
                'website' => 'https://techcompany.com',
                'order' => 1,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'translations' => [
                    'ar' => [
                        'name' => 'شركة استشارات عالمية',
                        'description' => 'تقدم خدمات الاستشارة لأكبر الشركات',
                    ],
                    'en' => [
                        'name' => 'Global Consulting Firm',
                        'description' => 'Provides consulting services to major companies',
                    ],
                ],
                'website' => 'https://consulting.com',
                'order' => 2,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'translations' => [
                    'ar' => [
                        'name' => 'شركة البناء والتشييد',
                        'description' => 'متخصصة في المشاريع السكنية والتجارية',
                    ],
                    'en' => [
                        'name' => 'Construction Company',
                        'description' => 'Specialized in residential and commercial projects',
                    ],
                ],
                'website' => 'https://construction.com',
                'order' => 3,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'translations' => [
                    'ar' => [
                        'name' => 'شركة التسويق الرقمي',
                        'description' => 'خبرة عارمة في التسويق الإلكتروني والإعلانات',
                    ],
                    'en' => [
                        'name' => 'Digital Marketing Agency',
                        'description' => 'Vast experience in digital marketing and advertising',
                    ],
                ],
                'website' => 'https://marketing.com',
                'order' => 4,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'translations' => [
                    'ar' => [
                        'name' => 'شركة التصميم الإبداعي',
                        'description' => 'تصميم الهويات البصرية والمواقع الإلكترونية',
                    ],
                    'en' => [
                        'name' => 'Creative Design Studio',
                        'description' => 'Visual identity and website design',
                    ],
                ],
                'website' => 'https://design.com',
                'order' => 5,
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($companies as $company) {
            Company::create([
                ...$company,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}
