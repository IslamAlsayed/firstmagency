<?php

namespace Database\Seeders;

use App\Models\WorkUsStep;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class WorkUsStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        WorkUsStep::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@firstmagency.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/services-marketing/work-lines');
        $destBasePath = storage_path('app/public/uploads/work-us-steps');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        // Work Us Steps data with proper translations and image filenames
        $steps = [
            [
                'slug' => 'analysis-and-research',
                'image' => 'content-marketing.png',
                'en' => ['title' => 'Analysis and Research', 'description' => 'Deep understanding of your business and market'],
                'ar' => ['title' => 'التحليل والبحث', 'description' => 'فهم عميق لعملك والسوق'],
                'order' => 1,
            ],
            [
                'slug' => 'strategy-planning',
                'image' => 'strategy-development.png',
                'en' => ['title' => 'Strategy Planning', 'description' => 'Developing comprehensive strategies with clear goals'],
                'ar' => ['title' => 'تخطيط الاستراتيجية', 'description' => 'تطوير استراتيجيات شاملة بأهداف واضحة'],
                'order' => 2,
            ],
            [
                'slug' => 'implementation',
                'image' => 'planning.png',
                'en' => ['title' => 'Implementation', 'description' => 'Executing the plan with precision and excellence'],
                'ar' => ['title' => 'التنفيذ', 'description' => 'تنفيذ الخطة بدقة وتميز'],
                'order' => 3,
            ],
            [
                'slug' => 'monitoring-optimization',
                'image' => 'qatar-marketing.png',
                'en' => ['title' => 'Monitoring and Optimization', 'description' => 'Continuous monitoring and improvements for success'],
                'ar' => ['title' => 'المراقبة والتحسين', 'description' => 'المراقبة المستمرة والتحسينات المستمرة'],
                'order' => 4,
            ],
            [
                'slug' => 'market-analysis',
                'image' => 'map.png',
                'en' => ['title' => 'Market Analysis', 'description' => 'Understanding market trends and opportunities'],
                'ar' => ['title' => 'تحليل السوق', 'description' => 'فهم اتجاهات السوق والفرص المتاحة'],
                'order' => 5,
            ],
            [
                'slug' => 'final-delivery',
                'image' => 'targeted.png',
                'en' => ['title' => 'Final Delivery', 'description' => 'Delivering results and measuring success'],
                'ar' => ['title' => 'التسليم النهائي', 'description' => 'تسليم النتائج وقياس النجاح'],
                'order' => 6,
            ],
        ];

        // Create work us steps
        foreach ($steps as $index => $step) {
            $i = $index + 1;
            $sourceFile = $sourcePath . '/' . $step['image'];

            $imagePath = null;
            if (File::exists($sourceFile)) {
                // Create directory for this work us step
                $workUsStepDir = $destBasePath . '/' . $i;

                if (!File::isDirectory($workUsStepDir)) {
                    File::makeDirectory($workUsStepDir, 0755, true);
                }

                // Copy the image with original filename to preserve extension
                $destFile = $workUsStepDir . '/' . $step['image'];

                // Only copy if destination doesn't exist
                if (!File::exists($destFile)) {
                    try {
                        $copyResult = File::copy($sourceFile, $destFile);
                        echo "  Copy returned: " . ($copyResult ? 'TRUE' : 'FALSE') . "\n";
                    } catch (\Exception $e) {
                        echo "✗ Exception during copy: {$e->getMessage()}\n";
                        $destFile = null;
                    }
                }

                // Save relative path for database storage
                if ($destFile && File::exists($destFile)) {
                    $imagePath = 'uploads/work-us-steps/' . $i . '/' . $step['image'];
                }
            } else {
                echo "✗ Source image NOT found: $sourceFile\n";
            }

            // Create or update work us step record
            WorkUsStep::updateOrCreate(
                ['slug' => $step['slug']],
                [
                    'translations' => [
                        'ar' => $step['ar'],
                        'en' => $step['en'],
                    ],
                    'image' => $imagePath,
                    'alt_text' => $step['en']['title'],
                    'order' => $step['order'],
                    'status' => 'published',
                    'is_active' => true,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }
    }
}
