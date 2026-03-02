<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $user = User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) return; // لا توجد مستخدمين

        $articlesData = [
            [
                'category' => 'التسويق الرقمي',
                'ar' => [
                    'title' => 'إعلانات ممولة في مصر',
                    'description' => 'شركة إعلانات ممولة في مصر لماذا تحتاج شركة إعلانات ممولة…',
                    'content' => 'محتوى المقال حول الإعلانات الممولة في مصر...',
                    'keywords' => 'إعلانات، مصر، التسويق الرقمي',
                    'meta_description' => 'خدمات الإعلانات الممولة في مصر',
                ],
                'en' => [
                    'title' => 'Paid Advertising in Egypt',
                    'description' => 'Why your company needs paid advertising services...',
                    'content' => 'Article content about paid advertising...',
                    'keywords' => 'advertising, Egypt, digital marketing',
                    'meta_description' => 'Paid advertising services in Egypt',
                ],
            ],
            [
                'category' => 'استضافة وسيرفرات',
                'ar' => [
                    'title' => 'استضافة مواقع في مصر',
                    'description' => 'شركة استضافة مواقع في مصر توفر خدمات استضافة عالية الجودة…',
                    'content' => 'محتوى المقال حول استضافة المواقع...',
                    'keywords' => 'استضافة، مواقع، مصر',
                    'meta_description' => 'أفضل خدمات استضافة المواقع في مصر',
                ],
                'en' => [
                    'title' => 'Web Hosting in Egypt',
                    'description' => 'Web hosting company in Egypt. Best hosting services...',
                    'content' => 'Article content about web hosting services...',
                    'keywords' => 'hosting, Egypt, web hosting',
                    'meta_description' => 'Best web hosting services in Egypt',
                ],
            ],
            [
                'category' => 'تطوير الويب',
                'ar' => [
                    'title' => 'البرمجة في فرست ماركتينج في 2025',
                    'description' => 'البرمجة في فرست ماركتينج تُعد البرمجة جزءًا أساسيًا…',
                    'content' => 'محتوى المقال حول البرمجة...',
                    'keywords' => 'برمجة، فرست، ماركتينج',
                    'meta_description' => 'خدمات البرمجة المتقدمة',
                ],
                'en' => [
                    'title' => 'Web Development at First Marketing',
                    'description' => 'Programming is a core part of our services...',
                    'content' => 'Article content about web development...',
                    'keywords' => 'programming, development, services',
                    'meta_description' => 'Advanced web development services',
                ],
            ],
            [
                'category' => 'التسويق الرقمي',
                'ar' => [
                    'title' => 'تسويق الكتروني في مصر 2025',
                    'description' => 'شركة تسويق الكتروني في مصر 2025 التسويق الإلكتروني…',
                    'content' => 'محتوى المقال حول التسويق الإلكتروني...',
                    'keywords' => 'تسويق، إلكتروني، مصر',
                    'meta_description' => 'استراتيجيات التسويق الإلكتروني',
                ],
                'en' => [
                    'title' => 'Electronic Marketing in Egypt 2025',
                    'description' => 'Electronic marketing is a multi-faceted strategy...',
                    'content' => 'Article content about e-marketing...',
                    'keywords' => 'marketing, electronic, strategy',
                    'meta_description' => 'E-marketing strategies and tactics',
                ],
            ],
            [
                'category' => 'تطوير الويب',
                'ar' => [
                    'title' => 'شركة تصميم مواقع',
                    'description' => 'هل تبحث عن شركة تصميم مواقع احترافية…',
                    'content' => 'محتوى المقال حول اختيار شركة التصميم...',
                    'keywords' => 'شركة، تصميم، اختيار',
                    'meta_description' => 'اختيار أفضل شركة تصميم',
                ],
                'en' => [
                    'title' => 'Website Design Company',
                    'description' => 'Looking for a professional website design company...',
                    'content' => 'Article content about choosing design company...',
                    'keywords' => 'company, design, professional',
                    'meta_description' => 'Choosing the best design company',
                ],
            ],
            [
                'category' => 'تحسين محركات البحث',
                'ar' => [
                    'title' => 'كيفية تحسين ترتيب موقعك في محركات البحث',
                    'description' => 'تعرف على أفضل طرق تحسين ترتيب موقعك…',
                    'content' => 'محتوى المقال حول تحسين ترتيب الموقع...',
                    'keywords' => 'SEO، محركات بحث، ترتيب',
                    'meta_description' => 'استراتيجيات تحسين محركات البحث',
                ],
                'en' => [
                    'title' => 'How to Improve Your Website Ranking',
                    'description' => 'Learn the best methods to improve your ranking...',
                    'content' => 'Article content about SEO optimization...',
                    'keywords' => 'SEO, search engines, ranking',
                    'meta_description' => 'Search engine optimization strategies',
                ],
            ],
            [
                'category' => 'الأمان السيبراني',
                'ar' => [
                    'title' => 'حماية موقعك من الهجمات السيبرانية',
                    'description' => 'نصائح أمان مهمة لحماية موقعك…',
                    'content' => 'محتوى المقال حول الأمان السيبراني...',
                    'keywords' => 'أمان، سيبراني، حماية',
                    'meta_description' => 'نصائح لحماية موقعك',
                ],
                'en' => [
                    'title' => 'Protecting Your Website from Cyber Attacks',
                    'description' => 'Important security tips to protect your website...',
                    'content' => 'Article content about cybersecurity...',
                    'keywords' => 'security, cyber, protection',
                    'meta_description' => 'Website protection tips',
                ],
            ],
            [
                'category' => 'تطوير التطبيقات',
                'ar' => [
                    'title' => 'تطوير تطبيقات موبايل احترافية',
                    'description' => 'خطوات تطوير تطبيق موبايل ناجح…',
                    'content' => 'محتوى المقال حول تطوير التطبيقات...',
                    'keywords' => 'تطبيقات، موبايل، تطوير',
                    'meta_description' => 'دليل تطوير التطبيقات',
                ],
                'en' => [
                    'title' => 'Professional Mobile App Development',
                    'description' => 'Steps to develop a successful mobile application...',
                    'content' => 'Article content about app development...',
                    'keywords' => 'apps, mobile, development',
                    'meta_description' => 'Guide to app development',
                ],
            ],
        ];

        foreach ($articlesData as $data) {
            $category = $categories->firstWhere('name', $data['category']) ?? $categories->first();

            Article::create([
                'slug' => Str::slug($data['ar']['title']),
                'image' => null,
                'thumbnail' => null,
                'category_id' => $category?->id,
                'translations' => [
                    'ar' => $data['ar'],
                    'en' => $data['en'],
                ],
                'status' => 'published',
                'is_active' => true,
                'is_featured' => rand(0, 1) === 1,
                'visitors' => rand(10, 500),
                'view_count' => rand(10, 500),
                'likes_count' => rand(0, 100),
                'comments_count' => rand(0, 50),
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'published_at' => now()->subDays(rand(1, 90)),
            ]);
        }
    }
}