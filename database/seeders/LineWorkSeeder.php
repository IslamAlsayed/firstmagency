<?php

namespace Database\Seeders;

use App\Models\LineWork;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class LineWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        LineWork::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/line-works');
        $destBasePath = storage_path('app/public/uploads/line-works');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        // Create 4 line works with real image uploads
        for ($i = 1; $i <= 4; $i++) {
            $sourceFile = $sourcePath . '/' . $i . '.png';

            if (!File::exists($sourceFile)) {
                echo "⚠️  Source file not found: $sourceFile\n";
                continue;
            }

            // Create directory for this line work
            $lineWorkDir = $destBasePath . '/' . $i;
            if (!File::isDirectory($lineWorkDir)) {
                File::makeDirectory($lineWorkDir, 0755, true);
            }

            // Copy the image with a new name
            $destFileName = 'line_work_' . $i . '.png';
            $destFile = $lineWorkDir . '/' . $destFileName;

            // Only copy if destination doesn't exist
            if (!File::exists($destFile)) {
                File::copy($sourceFile, $destFile);
            }

            // Save relative path for database storage (like: uploads/line-works/1/line_work_1.png)
            $imagePath = 'uploads/line-works/' . $i . '/' . $destFileName;

            // Create or update line work record
            LineWork::updateOrCreate(
                ['slug' => 'line-work-step-' . $i],
                [
                    'translations' => [
                        'ar' => [
                            'title' => __('main.line_work_step' . $i . '_title'),
                            'description' => __('main.line_work_step' . $i . '_desc'),
                        ],
                        'en' => [
                            'title' => __('main.line_work_step' . $i . '_title'),
                            'description' => __('main.line_work_step' . $i . '_desc'),
                        ],
                    ],
                    'image' => $imagePath,
                    'alt_text' => 'Line Work Step ' . $i,
                    'order' => $i,
                    'status' => 'published',
                    'is_active' => true,
                    'is_featured' => $i <= 2,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );

            echo "✓ LineWork Step #$i created with image: $imagePath\n";
        }

        echo "\n✅ 4 LineWorks seeded successfully!\n";
        echo "📁 Images stored in: $destBasePath\n";
    }
}
