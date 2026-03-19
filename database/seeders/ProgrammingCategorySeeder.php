<?php

namespace Database\Seeders;

use App\Models\ProgrammingCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ProgrammingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProgrammingCategory::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@firstmagency.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        $programmingCategories = [
            [
                'alt_text' => 'Web Development',
                'image' => '1.png',
                'order' => 1,
            ],
            [
                'alt_text' => 'Mobile App Development',
                'image' => '2.png',
                'order' => 2,
            ],
            [
                'alt_text' => 'E-Commerce Solutions',
                'image' => '3.png',
                'order' => 3,
            ],
            [
                'alt_text' => 'API Development',
                'image' => '4.png',
                'order' => 4,
            ],
            [
                'alt_text' => 'API Development',
                'image' => '5.png',
                'order' => 5,
            ],
        ];

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/categories');
        $destBasePath = storage_path('app/public/uploads/programming-categories');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        foreach ($programmingCategories as $i => $data) {
            $sourceImageFile = $sourcePath . '/' . $data['image'];

            if (!File::exists($sourceImageFile)) {
                echo "⚠️  Source file not found for programming system index " . $i . ": $sourceImageFile\n";
                continue;
            }

            // Create directory for this programming system
            $mainDir = $destBasePath . '/' . ($i + 1);
            if (!File::isDirectory($mainDir)) {
                File::makeDirectory($mainDir, 0755, true);
            }

            // Copy the main image
            $destImageFile = $mainDir . '/' . $data['image'];
            if (!File::exists($destImageFile)) {
                File::copy($sourceImageFile, $destImageFile);
            }

            // Save relative paths for database storage
            $data['image'] = 'uploads/programming-categories/' . ($i + 1) . '/' . $data['image'];

            ProgrammingCategory::create([
                ...$data,
                'slug' => 'category-' . ($i + 1),
                'image' => $data['image'],
                'is_active' => true,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}
