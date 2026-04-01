<?php

namespace Database\Seeders;

use App\Models\ProgrammingSystem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

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

        // Get current user or find admin user
        $user = getActiveUser() ?? User::where('email', 'admin@firstmagency.com')->first() ?? User::first();

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
            $sourceImageFile = $sourcePath . '/' . $data['icon'];

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
            $destImageFile = $mainDir . '/' . $data['icon'];
            if (!File::exists($destImageFile)) {
                File::copy($sourceImageFile, $destImageFile);
            }

            // Save relative paths for database storage
            $data['icon'] = 'uploads/programming-systems/' . ($i + 1) . '/' . $data['icon'];

            ProgrammingSystem::create([
                ...$data,
                'alt_text' => $data['translations']['en']['name'],
                'is_active' => true,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}
