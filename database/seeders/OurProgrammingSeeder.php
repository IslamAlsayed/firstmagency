<?php

namespace Database\Seeders;

use App\Models\OurProgramming;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class OurProgrammingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        OurProgramming::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/categories');
        $destBasePath = storage_path('app/public/uploads/our-programmings');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        $ourProgrammings = [
            [
                'alt_text' => 'Web Development',
                'order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'image_number' => 1,
            ],
            [
                'alt_text' => 'Mobile App Development',
                'order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'image_number' => 2,
            ],
            [
                'alt_text' => 'E-Commerce Solutions',
                'order' => 3,
                'is_active' => true,
                'is_featured' => false,
                'image_number' => 3,
            ],
            [
                'alt_text' => 'API Development',
                'order' => 4,
                'is_active' => true,
                'is_featured' => false,
                'image_number' => 4,
            ],
        ];

        foreach ($ourProgrammings as $programming) {
            $sourceFile = $sourcePath . '/' . $programming['image_number'] . '.png';
            $imagePath = null;

            if (File::exists($sourceFile)) {
                // Create directory for this programming
                $progDir = $destBasePath . '/' . $programming['image_number'];
                if (!File::isDirectory($progDir)) {
                    File::makeDirectory($progDir, 0755, true);
                }

                // Copy the image with a new name
                $destFileName = 'programming_' . $programming['image_number'] . '.png';
                $destFile = $progDir . '/' . $destFileName;

                // Only copy if destination doesn't exist
                if (!File::exists($destFile)) {
                    File::copy($sourceFile, $destFile);
                }

                // Save relative path for database storage
                $imagePath = 'uploads/our-programmings/' . $programming['image_number'] . '/' . $destFileName;
                echo "✓ Image copied for Programming #" . $programming['image_number'] . ": $imagePath\n";
            } else {
                echo "⚠️  Source file not found: $sourceFile\n";
            }

            OurProgramming::create([
                'alt_text' => $programming['alt_text'],
                'image' => $imagePath,
                'order' => $programming['order'],
                'is_active' => $programming['is_active'],
                'is_featured' => $programming['is_featured'],
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            echo "✓ OurProgramming #" . $programming['image_number'] . " created successfully\n";
        }

        echo "\n✅ 4 OurProgrammings seeded successfully with images!\n";
        echo "📁 Images stored in: $destBasePath\n";
    }
}
