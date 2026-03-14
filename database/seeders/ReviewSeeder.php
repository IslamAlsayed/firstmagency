<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Review::truncate();
        Schema::enableForeignKeyConstraints();

        $user = User::where('email', 'content@example.com')->first() ?? User::first();
        if (!$user) return; // لا توجد مستخدمين

        $reviews = config('main-reviews');

        // Paths configuration
        $sourcePath = base_path('public/assets/images/avatars');
        $destBasePath = storage_path('app/public/uploads/reviews');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        foreach ($reviews as $i => $data) {
            $sourceImageFile = $sourcePath . '/' . $data['photo'];

            if (!File::exists($sourceImageFile)) {
                echo "⚠️  Source file not found for review index " . $i . ": $sourceImageFile\n";
                continue;
            }

            // Create directory for this review
            $mainDir = $destBasePath . '/' . ($i + 1);
            if (!File::isDirectory($mainDir)) {
                File::makeDirectory($mainDir, 0755, true);
            }

            // Copy the main image
            $destImageFile = $mainDir . '/' . $data['photo'];
            if (!File::exists($destImageFile)) {
                File::copy($sourceImageFile, $destImageFile);
            }

            // Save relative paths for database storage
            $data['photo'] = 'uploads/reviews/' . ($i + 1) . '/' . $data['photo'];

            Review::create([
                ...$data,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}