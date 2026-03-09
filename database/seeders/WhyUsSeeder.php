<?php

namespace Database\Seeders;

use App\Models\WhyUs;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class WhyUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        WhyUs::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/domains/why-us');
        $destBasePath = storage_path('app/public/uploads/why-us');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        // Data array based on config
        $whyUsData = [
            [
                'title_ar' => 'حماية وخصوصية',
                'title_en' => 'Protection and Privacy',
                'description_ar' => 'حماية بياناتك وخيارات أمان قوية ضد محاولات الاحتيال',
                'description_en' => 'Protect your data and strong security options against fraud attempts',
                'image' => '1.svg',
            ],
            [
                'title_ar' => 'تفعيل سريع',
                'title_en' => 'Quick Activation',
                'description_ar' => 'تفعيل وتوثيق بسرعة مع إرشادات واضحة خطوة بخطوة',
                'description_en' => 'Quick activation and verification with clear step-by-step instructions',
                'image' => '2.svg',
            ],
            [
                'title_ar' => 'دعم حقيقي',
                'title_en' => 'Real Support',
                'description_ar' => 'فريق دعم جاهز لمساعدتك في أي وقت عند الحاجة',
                'description_en' => 'Support team ready to help you anytime when needed',
                'image' => '3.svg',
            ],
            [
                'title_ar' => 'لوحة تحكم سهلة',
                'title_en' => 'Easy Control Panel',
                'description_ar' => 'لوحة تحكم سهلة لتحكم في خيارات الدومين وادواته',
                'description_en' => 'Easy control panel to manage domain options and tools',
                'image' => '4.svg',
            ],
            [
                'title_ar' => 'سعر تنافسي وشفافية',
                'title_en' => 'Competitive Price and Transparency',
                'description_ar' => 'سعرنا ثابت عند التجديد لازيادة سنويا للنقل او التجديد',
                'description_en' => 'Our price is fixed upon renewal, no annual increase for transfer or renewal',
                'image' => '5.svg',
            ],
            [
                'title_ar' => 'تجديد مرن وتنبيهات',
                'title_en' => 'Flexible Renewal and Notifications',
                'description_ar' => 'تنبيهات اسبوعية قبل موعد التجديد بالبريد او الاتصال',
                'description_en' => 'Weekly notifications before renewal date via email or call',
                'image' => '6.svg',
            ],
        ];

        // Create 6 why us items with real image uploads
        foreach ($whyUsData as $index => $data) {
            $imageFile = $data['image'];
            $sourceFile = $sourcePath . '/' . $imageFile;

            if (!File::exists($sourceFile)) {
                echo "⚠️  Source file not found: $sourceFile\n";
                continue;
            }

            // Create directory for this item
            $itemDir = $destBasePath . '/' . ($index + 1);
            if (!File::isDirectory($itemDir)) {
                File::makeDirectory($itemDir, 0755, true);
            }

            // Copy the image with a new name
            $destFileName = 'why_us_' . ($index + 1) . '.svg';
            $destFile = $itemDir . '/' . $destFileName;

            // Only copy if destination doesn't exist
            if (!File::exists($destFile)) {
                File::copy($sourceFile, $destFile);
            }

            // Save relative path for database storage
            $imagePath = 'uploads/why-us/' . ($index + 1) . '/' . $destFileName;

            // Create or update why us record
            WhyUs::updateOrCreate(
                ['slug' => 'why-us-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT)],
                [
                    'translations' => [
                        'ar' => [
                            'title' => $data['title_ar'],
                            'description' => $data['description_ar'],
                        ],
                        'en' => [
                            'title' => $data['title_en'],
                            'description' => $data['description_en'],
                        ],
                    ],
                    'image' => $imagePath,
                    'alt_text' => $data['title_en'],
                    'order' => $index + 1,
                    'status' => 'published',
                    'is_active' => true,
                    'is_featured' => $index < 3, // Featured first 3 items
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );

            echo "✓ Why Us Item #" . ($index + 1) . " created with image: $imagePath\n";
        }

        echo "\n✅ 6 Why Us items seeded successfully!\n";
        echo "📁 Images stored in: $destBasePath\n";
    }
}
