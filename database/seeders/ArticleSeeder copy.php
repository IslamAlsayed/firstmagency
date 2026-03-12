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
                    'description' => 'شركة استضافة مواقع في مصر شركة استضافة مواقع في مصر…',
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

        $user = User::where('email', 'admin@example.com')->first() 
            ?? User::where('email', 'super@example.com')->first() 
            ?? User::first();

        foreach ($articlesData as $data) {
            $category = $categories->firstWhere('name', $data['category']) ?? $categories->first();

            Article::create([
                'slug' => Str::slug($data['ar']['title']),
                'photo' => null,
                'thumbnail' => null,
                'category_id' => $category?->id,
                'translations' => [
                    'ar' => $data['ar'],
                    'en' => $data['en'],
                ],
                'status' => 'published',
                'is_active' => true,
                'featured' => rand(0, 1) === 1,
                'visitors' => rand(10, 500),
                'view_count' => rand(10, 500),
                'likes_count' => rand(0, 100),
                'comments_count' => rand(0, 50),
                'read_time' => rand(3, 15),
                'created_by' => $user?->id,
                'updated_by' => $user?->id,
                'published_at' => now()->subDays(rand(1, 90)),
            ]);
        }
    }
}

                        'meta_description' => 'Best web hosting services in Egypt',
                    ],
                    'fr' => [
                        'title' => 'Hébergement de Sites Web en Égypte',
                        'description' => 'Entreprise d\'hébergement de sites web en Égypte...',
                        'content' => 'Contenu de l\'article sur l\'hébergement web...',
                        'keywords' => 'hébergement, Égypte, web',
                        'meta_description' => 'Meilleurs services d\'hébergement web en Égypte',
                    ],
                ],
            ],
            [
                'title' => 'تصميم مواقع احترافية',
                'description' => 'شركة تصميم مواقع احترافية شركة تصميم مواقع احترافية امتلاك موقع…',
                'content' => 'محتوى المقال حول تصميم المواقع الاحترافية...',
                'keywords' => 'تصميم، مواقع، احترافي',
                'meta_description' => 'تصميم مواقع احترافية وحديثة',
                'translations' => [
                    'ar' => [
                        'title' => 'تصميم مواقع احترافية',
                        'description' => 'شركة تصميم مواقع احترافية',
                        'content' => 'محتوى المقال حول تصميم المواقع الاحترافية...',
                        'keywords' => 'تصميم، مواقع، احترافي',
                        'meta_description' => 'تصميم مواقع احترافية وحديثة',
                    ],
                    'en' => [
                        'title' => 'Professional Web Design',
                        'description' => 'Professional web design company...',
                        'content' => 'Content about professional web design services...',
                        'keywords' => 'web design, professional, website',
                        'meta_description' => 'Professional website design services',
                    ],
                    'fr' => [
                        'title' => 'Conception Web Professionnelle',
                        'description' => 'Entreprise de conception web professionnelle...',
                        'content' => 'Contenu sur la conception web professionnelle...',
                        'keywords' => 'conception web, professionnel, site',
                        'meta_description' => 'Services de conception web professionnelle',
                    ],
                ],
            ],
            [
                'title' => 'برمجة تطبيقات موبيل في مصر',
                'description' => 'شركة برمجة تطبيقات موبيل في مصر شركة برمجة التطبيقات هي…',
                'content' => 'محتوى المقال حول برمجة التطبيقات...',
                'keywords' => 'برمجة، تطبيقات، موبيل',
                'meta_description' => 'خدمات برمجة تطبيقات الموبايل',
                'translations' => [
                    'ar' => [
                        'title' => 'برمجة تطبيقات موبيل في مصر',
                        'description' => 'شركة برمجة تطبيقات موبيل في مصر',
                        'content' => 'محتوى المقال حول برمجة التطبيقات...',
                        'keywords' => 'برمجة، تطبيقات، موبيل',
                        'meta_description' => 'خدمات برمجة تطبيقات الموبايل',
                    ],
                    'en' => [
                        'title' => 'Mobile App Development in Egypt',
                        'description' => 'Mobile app programming company in Egypt...',
                        'content' => 'Content about mobile app development...',
                        'keywords' => 'mobile apps, development, programming',
                        'meta_description' => 'Mobile app development services',
                    ],
                    'fr' => [
                        'title' => 'Développement d\'Applications Mobiles en Égypte',
                        'description' => 'Entreprise de développement d\'applications mobiles en Égypte...',
                        'content' => 'Contenu sur le développement d\'applications mobiles...',
                        'keywords' => 'applications mobiles, développement',
                        'meta_description' => 'Services de développement d\'applications mobiles',
                    ],
                ],
            ],
            [
                'title' => 'مواقع إلكترونية في الجيزة',
                'description' => 'تصميم مواقع إلكترونية في الجيزة تصميم مواقع الكترونية في الجيزة…',
                'content' => 'محتوى المقال حول المواقع الإلكترونية...',
                'keywords' => 'جيزة، مواقع، تصميم',
                'meta_description' => 'تصميم مواقع في الجيزة',
            ],
            [
                'title' => 'مواقع المتاجر الإلكترونية',
                'description' => 'تصميم مواقع المتاجر الإلكترونية تصميم مواقع المتاجر الإلكترونية من أهم…',
                'content' => 'محتوى المقال حول المتاجر الإلكترونية...',
                'keywords' => 'متاجر، إلكترونية، تجارة',
                'meta_description' => 'حلول المتاجر الإلكترونية',
            ],
            [
                'title' => 'مواقع الاخبار',
                'description' => 'تصميم مواقع الاخبار تصميم مواقع الاخبار يتطلب الاهتمام بالعديد من…',
                'content' => 'محتوى المقال حول مواقع الأخبار...',
                'keywords' => 'أخبار، مواقع، تصميم',
                'meta_description' => 'منصات أخبار احترافية',
            ],
            [
                'title' => 'المنصات التعليمية',
                'description' => 'برمجة وتصميم المنصات التعليمية تعتبر المنصات التعليمية من الأدوات الحديثة…',
                'content' => 'محتوى المقال حول المنصات التعليمية...',
                'keywords' => 'تعليم، منصات، برمجة',
                'meta_description' => 'منصات تعليمية تفاعلية',
            ],
            [
                'title' => 'البرمجة في فرست ماركتينج في 2025',
                'description' => 'البرمجة في فرست ماركتينج تُعد البرمجة جزءًا أساسيًا في شركة…',
                'content' => 'محتوى المقال حول البرمجة...',
                'keywords' => 'برمجة، فرست، ماركتينج',
                'meta_description' => 'خدمات البرمجة المتقدمة',
            ],
            [
                'title' => 'تسويق الكتروني في مصر 2025',
                'description' => 'شركة تسويق الكتروني في مصر 2025 التسويق الإلكتروني هو استراتيجية…',
                'content' => 'محتوى المقال حول التسويق الإلكتروني...',
                'keywords' => 'تسويق، إلكتروني، مصر',
                'meta_description' => 'استراتيجيات التسويق الإلكتروني',
            ],
            [
                'title' => 'التسويق الالكتروني للشركات 2025',
                'description' => 'اهمية التسويق الالكتروني للشركات اهمية التسويق الالكترونى للشركات عبارة عن…',
                'content' => 'محتوى المقال حول أهمية التسويق...',
                'keywords' => 'شركات، تسويق، إلكتروني',
                'meta_description' => 'تسويق إلكتروني للمؤسسات',
            ],
            [
                'title' => 'شركة تصميم مواقع',
                'description' => 'هل تبحث عن شركة تصميم مواقع احترافية لمشروعك الرقمي؟ اختيار…',
                'content' => 'محتوى المقال حول اختيار شركة التصميم...',
                'keywords' => 'شركة، تصميم، اختيار',
                'meta_description' => 'اختيار أفضل شركة تصميم',
            ],
            [
                'title' => 'اختيار أفضل شركة تصميم مواقع الكترونية',
                'description' => 'طريقة اختيار أفضل شركة تصميم مواقع الكترونية؟ إن اختيار أفضل…',
                'content' => 'محتوى المقال حول الاختيار...',
                'keywords' => 'اختيار، شركة، تصميم',
                'meta_description' => 'نصائح اختيار شركة التصميم',
            ],
            [
                'title' => 'كيف تقوم بتنصيب ووردبريس بطريقة سهلة وسريعة 2024',
                'description' => 'كيفية تنصيب ووردبريس بطريقة سهلة وسريعة 2024 تعد منصة ووردبريس…',
                'content' => 'محتوى المقال حول تنصيب ووردبريس...',
                'keywords' => 'ووردبريس، تنصيب، سهل',
                'meta_description' => 'دليل تنصيب ووردبريس بسهولة',
            ],
            [
                'title' => 'شركة اعلانات سوشيال ميديا في مصر',
                'description' => 'تعرف علي افضل شركة اعلانات سوشيال ميديا في مصر تعد…',
                'content' => 'محتوى المقال حول إعلانات السوشيال ميديا...',
                'keywords' => 'سوشيال ميديا، إعلانات، مصر',
                'meta_description' => 'خدمات إعلانات وسائل التواصل',
            ],
            [
                'title' => 'افضل شركة استضافة مواقع في الوطن العربي',
                'description' => 'افضل شركة استضافة مواقع في مصر مرحبا بكم في فرست…',
                'content' => 'محتوى المقال حول أفضل الشركات...',
                'keywords' => 'استضافة، عربي، أفضل',
                'meta_description' => 'أفضل خدمات الاستضافة العربية',
            ],
            [
                'title' => 'قالب ووردبريس لإنشاء متجرك الإلكتروني 2024',
                'description' => 'إليك أفضل قالب ووردبريس للمتاجر الإلكترونية في عام 2024: خيارات…',
                'content' => 'محتوى المقال حول قوالب ووردبريس...',
                'keywords' => 'قالب، ووردبريس، متجر',
                'meta_description' => 'أفضل قوالب ووردبريس للمتاجر',
            ],
            [
                'title' => 'افضل شركات الدفع الالكتروني في مصر',
                'description' => 'من افضل شركات الدفع الالكتروني في مصر افضل شركات الدفع…',
                'content' => 'محتوى المقال حول خدمات الدفع...',
                'keywords' => 'دفع، إلكتروني، مصر',
                'meta_description' => 'خدمات الدفع الإلكترونية',
            ],
            [
                'title' => 'إدارة صفحات السوشيال ميديا و تصميم المواقع بشكل فعال 2024',
                'description' => 'تُقدم فيرست ماركيتينج حلولًا متكاملة لإدارة مواقع التواصل الاجتماعي لعلامتك…',
                'content' => 'محتوى المقال حول إدارة السوشيال ميديا...',
                'keywords' => 'سوشيال ميديا، تصميم، إدارة',
                'meta_description' => 'إدارة فعالة للتواصل الاجتماعي',
            ],
            [
                'title' => '5 اضافات تصميم موقع ووردبريس المجانية 2024',
                'description' => 'عند التفكير في تصميم موقع باستخدام منصة ووردبريس، يعتبر اختيار…',
                'content' => 'محتوى المقال حول اضافات ووردبريس...',
                'keywords' => 'اضافات، ووردبريس، مجاني',
                'meta_description' => 'أفضل إضافات ووردبريس المجانية',
            ],
            [
                'title' => 'رفع حجم الابلود والذاكرة علي ووردبريس',
                'description' => 'رفع حجم الابلود والذاكرة علي ووردبريس رفع حجم الابلود والذاكرة…',
                'content' => 'محتوى المقال حول رفع الحد الأقصى...',
                'keywords' => 'ووردبريس، ذاكرة، رفع',
                'meta_description' => 'كيفية زيادة حد الرفع',
            ],
            [
                'title' => 'تحسين سرعة موقعك مع الاستضافة السحابية 2024',
                'description' => 'تحسين سرعة موقع الويب الخاص بك هو عامل حاسم لنجاح…',
                'content' => 'محتوى المقال حول الاستضافة السحابية...',
                'keywords' => 'سحابية، استضافة، سرعة',
                'meta_description' => 'الاستضافة السحابية وتحسين الأداء',
            ],
            [
                'title' => 'ما المقصود باستضافة الريسلر',
                'description' => 'هل تعرف ما المقصود باستضافة الريسلر؟ ما المقصود باستضافة الريسيلر…',
                'content' => 'محتوى المقال حول استضافة الريسلر...',
                'keywords' => 'ريسلر، استضافة، شرح',
                'meta_description' => 'شرح استضافة الريسلر',
            ],
            [
                'title' => 'استراتيجيات تحسين موقعك في محركات البحث (SEO)',
                'description' => 'أفضل سيو مواقع تحسين موقعك في محركات البحث (شركة خدمات…',
                'content' => 'محتوى المقال حول استراتيجيات السيو...',
                'keywords' => 'سيو، محركات البحث، تحسين',
        ];

        $user = User::where('email', 'admin@example.com')->first() 
            ?? User::where('email', 'super@example.com')->first() 
            ?? User::first();

        foreach ($articlesData as $data) {
            $category = $categories->firstWhere('name', $data['category']) ?? $categories->first();

            Article::create([
                'slug' => Str::slug($data['ar']['title']),
                'photo' => null,
                'thumbnail' => null,
                'category_id' => $category?->id,
                'translations' => [
                    'ar' => $data['ar'],
                    'en' => $data['en'],
                ],
                'status' => 'published',
                'is_active' => true,
                'featured' => rand(0, 1) === 1,
                'visitors' => rand(10, 500),
                'view_count' => rand(10, 500),
                'likes_count' => rand(0, 100),
                'comments_count' => rand(0, 50),
                'read_time' => rand(3, 15),
                'created_by' => $user?->id,
                'updated_by' => $user?->id,
                'published_at' => now()->subDays(rand(1, 90)),
            ]);
        }
    }
}
