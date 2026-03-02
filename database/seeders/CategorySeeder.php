<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'التسويق الرقمي',
                'description' => 'مقالات وتجارب في مجال التسويق الرقمي والتطبيقات الحديثة',
                'icon' => 'fas fa-bullhorn',
                'is_active' => true,
            ],
            [
                'name' => 'تطوير الويب',
                'description' => 'نصائح وأفضل الممارسات في تطوير وتصميم المواقع',
                'icon' => 'fas fa-code',
                'is_active' => true,
            ],
            [
                'name' => 'تطوير التطبيقات',
                'description' => 'موارد وشروحات لتطوير التطبيقات على مختلف الأنظمة',
                'icon' => 'fas fa-mobile-alt',
                'is_active' => true,
            ],
            [
                'name' => 'استضافة وسيرفرات',
                'description' => 'معلومات عن استضافة المواقع والخوادم والعناية بها',
                'icon' => 'fas fa-server',
                'is_active' => true,
            ],
            [
                'name' => 'تحسين محركات البحث',
                'description' => 'استراتيجيات وتقنيات لتحسين تصنيف موقعك في محركات البحث',
                'icon' => 'fas fa-search',
                'is_active' => true,
            ],
            [
                'name' => 'الأمان السيبراني',
                'description' => 'نصائح متقدمة لحماية مواقعك والبيانات الخاصة بك',
                'icon' => 'fas fa-shield-alt',
                'is_active' => true,
            ],
            [
                'name' => 'أخرى',
                'description' => 'مقالات متنوعة لا تندرج تحت التصنيفات الأخرى',
                'icon' => 'fas fa-folder-open',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']],$category);
        }
    }
}