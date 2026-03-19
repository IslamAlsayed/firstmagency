<?php

namespace Database\Seeders;

use App\Models\ProjectStep;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProjectStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProjectStep::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@firstmagency.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        $projectSteps = [
            [
                'translations_ar' => [
                    'title' => 'التخطيط والتحليل',
                    'content' => 'نحلل متطلباتك ونضع خطة مشروع تفصيلية لضمان النجاح. يعمل فريقنا بشكل وثيق معك لفهم رؤيتك وتحديد الأهداف الواضحة.',
                ],
                'translations_en' => [
                    'title' => 'Planning & Analysis',
                    'content' => 'We analyze your requirements and create a detailed project plan to ensure success. Our team works closely with you to understand your vision and define clear objectives.',
                ],
                'icon' => 'fas fa-chart-pie',
                'order' => 1,
            ],
            [
                'translations_ar' => [
                    'title' => 'التصميم والنموذج الأولي',
                    'content' => 'يصمم فريقنا الإبداعي واجهات جميلة وسهلة الاستخدام. نقوم بإنشاء نماذج أولية تفاعلية لمراجعتك وملاحظاتك قبل بدء التطوير.',
                ],
                'translations_en' => [
                    'title' => 'Design & Prototyping',
                    'content' => 'Our creative designers craft beautiful and intuitive interface designs. We create interactive prototypes for your review and feedback before development begins.',
                ],
                'icon' => 'fas fa-pencil-ruler',
                'order' => 2,
            ],
            [
                'translations_ar' => [
                    'title' => 'التطوير',
                    'content' => 'يحول فريقنا من المطورين ذوي الخبرة تصميمك إلى واقع برمجي نظيف وفعال. نتبع أفضل الممارسات والمعايير الصناعية لضمان الجودة والصيانة.',
                ],
                'translations_en' => [
                    'title' => 'Development',
                    'content' => 'Our experienced developers bring your design to life with clean, efficient code. We follow best practices and industry standards to ensure quality and maintainability.',
                ],
                'icon' => 'fas fa-code',
                'order' => 3,
            ],
            [
                'translations_ar' => [
                    'title' => 'الاختبار والإطلاق',
                    'content' => 'الاختبار الشامل يضمن أن مشروعك يعمل بشكل مثالي على جميع الأنظمة الأساسية. نجري ضمان الجودة وإصلاح الأخطاء وتحسين الأداء قبل الإطلاق.',
                ],
                'translations_en' => [
                    'title' => 'Testing & Launch',
                    'content' => 'Comprehensive testing ensures your project works perfectly across all platforms. We conduct quality assurance, fix bugs, and optimize performance before launch.',
                ],
                'icon' => 'fas fa-desktop',
                'order' => 4,
            ],
        ];

        foreach ($projectSteps as $step) {
            ProjectStep::create([
                'translations' => [
                    'ar' => $step['translations_ar'],
                    'en' => $step['translations_en'],
                ],
                'icon' => $step['icon'],
                'order' => $step['order'],
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}
