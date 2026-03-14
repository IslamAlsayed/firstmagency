<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Portfolio::truncate();
        Schema::enableForeignKeyConstraints();

        $user = User::where('email', 'content@example.com')->first() ?? User::first();
        if (!$user) return; // لا توجد مستخدمين

        $portfolio = config('portfolio');

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/portfolio');
        $destBasePath = storage_path('app/public/uploads/portfolio');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        foreach ($portfolio as $i => $data) {
            $sourceImageFile = $sourcePath . '/' . $data['image'];

            if (!File::exists($sourceImageFile)) {
                echo "⚠️  Source file not found for portfolio index " . ($i + 1) . ": $sourceImageFile\n";
                continue;
            }

            // Create directory for this portfolio item
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
            $data['slug'] = strtolower(str_replace(' ', '-', $data['title']));
            $data['image'] = 'uploads/portfolio/' . ($i + 1) . '/' . $data['image'];

            Portfolio::create([
                ...$data,
                'is_active' => true,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}