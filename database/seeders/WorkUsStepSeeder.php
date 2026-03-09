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
        $user = getActiveUser() ?? User::where('email', 'content@example.com')->first() ?? User::first();

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
            echo "\n--- Processing Step $i: {$step['en']['title']} ---\n";
            echo "  Source file: $sourceFile\n";
            echo "  Source exists: " . (file_exists($sourceFile) ? 'YES' : 'NO') . "\n";

            if (File::exists($sourceFile)) {
                // Create directory for this work us step
                $workUsStepDir = $destBasePath . '/' . $i;
                echo "  Destination dir: $workUsStepDir\n";

                if (!File::isDirectory($workUsStepDir)) {
                    echo "  Creating directory...\n";
                    File::makeDirectory($workUsStepDir, 0755, true);
                    echo "  Dir created: " . (is_dir($workUsStepDir) ? 'YES' : 'NO') . "\n";
                    echo "  Dir writable: " . (is_writable($workUsStepDir) ? 'YES' : 'NO') . "\n";
                } else {
                    echo "  Dir already exists\n";
                }

                // Copy the image with original filename to preserve extension
                $destFile = $workUsStepDir . '/' . $step['image'];
                echo "  Destination file: $destFile\n";

                // Only copy if destination doesn't exist
                if (!File::exists($destFile)) {
                    try {
                        echo "  Attempting File::copy()...\n";
                        $copyResult = File::copy($sourceFile, $destFile);
                        echo "  Copy returned: " . ($copyResult ? 'TRUE' : 'FALSE') . "\n";
                        echo "  File exists after copy: " . (file_exists($destFile) ? 'YES' : 'NO') . "\n";
                        echo "✓ Image copying completed for step $i\n";
                    } catch (\Exception $e) {
                        echo "✗ Exception during copy: {$e->getMessage()}\n";
                        $destFile = null;
                    }
                } else {
                    echo "⚠️  Image already exists at destination\n";
                }

                // Save relative path for database storage
                if ($destFile && File::exists($destFile)) {
                    $imagePath = 'uploads/work-us-steps/' . $i . '/' . $step['image'];
                    echo "✓ Database path set: $imagePath\n";
                } else {
                    echo "✗ Destination file not confirmed to exist\n";
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
                    'is_featured' => $i <= 2,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );

            echo "✓ WorkUsStep created: {$step['en']['title']}\n";
        }
    }
}