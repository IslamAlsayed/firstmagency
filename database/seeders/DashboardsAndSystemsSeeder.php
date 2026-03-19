<?php

namespace Database\Seeders;

use App\Models\DashboardsAndSystem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DashboardsAndSystemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DashboardsAndSystem::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@firstmagency.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        // ==================== Operating Systems ====================
        $osSourcePath = base_path('public/assets/images/website/hosting/operating-systems');
        $osDestBasePath = storage_path('app/public/uploads/operating-systems');

        if (!File::isDirectory($osDestBasePath)) {
            File::makeDirectory($osDestBasePath, 0755, true);
        }

        $operatingSystems = config('operating-systems') ?? [];

        for ($index = 1; $index <= 12; $index++) {
            $sourceFile = $osSourcePath . '/' . $index . '.png';

            if (!File::exists($sourceFile)) {
                echo "⚠️  Source file not found: $sourceFile\n";
                continue;
            }

            // Get title from config or use default
            $title = isset($operatingSystems[$index - 1]) ? $operatingSystems[$index - 1]['title'] : "Operating System $index";

            // Create directory for this OS
            $osDir = $osDestBasePath . '/' . $index;
            if (!File::isDirectory($osDir)) {
                File::makeDirectory($osDir, 0755, true);
            }

            // Copy the image
            $destFileName = 'os_' . $index . '.png';
            $destFile = $osDir . '/' . $destFileName;

            if (!File::exists($destFile)) {
                File::copy($sourceFile, $destFile);
            }

            $imagePath = 'uploads/operating-systems/' . $index . '/' . $destFileName;

            DashboardsAndSystem::create([
                'slug' => Str::slug($title),
                'type' => 'operating-system',
                'translations' => [
                    'ar' => ['title' => $title],
                    'en' => ['title' => $title],
                ],
                'image' => $imagePath,
                'order' => $index,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }

        // ==================== Dashboards And Apps ====================
        $dashSourcePath = base_path('public/assets/images/website/hosting/dashboards-and-apps');
        $dashDestBasePath = storage_path('app/public/uploads/dashboards-and-apps');

        if (!File::isDirectory($dashDestBasePath)) {
            File::makeDirectory($dashDestBasePath, 0755, true);
        }

        $dashboardsAndSystems = [
            ['title' => 'cPanel', 'file_index' => 1],
            ['title' => 'Plesk', 'file_index' => 2],
            ['title' => 'CyberPanel', 'file_index' => 3],
            ['title' => 'CWP', 'file_index' => 4],
            ['title' => 'Webmin', 'file_index' => 5],
            ['title' => 'aaPanel', 'file_index' => 6],
            ['title' => 'WordPress', 'file_index' => 7],
            ['title' => 'Joomla', 'file_index' => 8],
            ['title' => 'Magento', 'file_index' => 9],
            ['title' => 'PrestaShop', 'file_index' => 10],
            ['title' => 'Drupal', 'file_index' => 11],
            ['title' => 'OpenCart', 'file_index' => 12],
        ];

        foreach ($dashboardsAndSystems as $app) {
            $sourceFile = $dashSourcePath . '/' . $app['file_index'] . '.png';

            if (!File::exists($sourceFile)) {
                echo "⚠️  Source file not found: $sourceFile\n";
                continue;
            }

            // Create directory for this app
            $appDir = $dashDestBasePath . '/' . $app['file_index'];
            if (!File::isDirectory($appDir)) {
                File::makeDirectory($appDir, 0755, true);
            }

            // Copy the image
            $destFileName = 'app_' . $app['file_index'] . '.png';
            $destFile = $appDir . '/' . $destFileName;

            if (!File::exists($destFile)) {
                File::copy($sourceFile, $destFile);
            }

            $imagePath = 'uploads/dashboards-and-apps/' . $app['file_index'] . '/' . $destFileName;

            DashboardsAndSystem::create([
                'slug' => Str::slug($app['title']),
                'type' => 'dashboard-app',
                'translations' => [
                    'ar' => ['title' => $app['title']],
                    'en' => ['title' => $app['title']],
                ],
                'image' => $imagePath,
                'order' => $app['file_index'],
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}