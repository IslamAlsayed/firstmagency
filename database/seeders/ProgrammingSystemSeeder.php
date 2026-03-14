<?php

namespace Database\Seeders;

use App\Models\ProgrammingSystem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProgrammingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProgrammingSystem::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        $programmingSystems = config('programming-systems');

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/developer');
        $destBasePath = storage_path('app/public/uploads/programming-systems');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        foreach ($programmingSystems as $i => $data) {
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
            $data['image'] = 'uploads/programming-systems/' . ($i + 1) . '/' . $data['image'];

            ProgrammingSystem::create([
                ...$data,
                'slug' => Str::slug($data['title']),
                'image' => $data['image'],
                'alt_text' => $data['title'],
                'is_active' => true,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}