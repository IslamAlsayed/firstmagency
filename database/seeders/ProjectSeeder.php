<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Project::truncate();
        Schema::enableForeignKeyConstraints();

        $user = User::where('email', 'content@example.com')->first() ?? User::first();
        if (!$user) return; // لا توجد مستخدمين

        $projects = config('projects_companies');

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/projects');
        $destBasePath = storage_path('app/public/uploads/projects');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        foreach ($projects as $i => $data) {
            $sourceImageFile = $sourcePath . '/' . ($i + 1) . '.png';

            if (!File::exists($sourceImageFile)) {
                echo "⚠️  Source file not found for project index " . ($i + 1) . ": $sourceImageFile\n";
                continue;
            }

            // Create directory for this project
            $mainDir = $destBasePath . '/' . ($i + 1);
            if (!File::isDirectory($mainDir)) {
                File::makeDirectory($mainDir, 0755, true);
            }

            // Copy the main image
            $destImageFile = $mainDir . '/' . ($i + 1) . '.png';
            if (!File::exists($destImageFile)) {
                File::copy($sourceImageFile, $destImageFile);
            }

            // Save relative paths for database storage
            $data['slug'] = strtolower(str_replace(' ', '-', $data['title']));
            $data['image'] = 'uploads/projects/' . ($i + 1) . '/' . ($i + 1) . '.png';

            Project::create([
                ...$data,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}