<?php

namespace Database\Seeders;

use App\Models\HostingPackage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class HostingPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        HostingPackage::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user
        $user = getActiveUser() ?? User::where('email', 'content@firstmagency.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        $sourcePath = base_path('public/assets/images/website/hosting/hosting-packages');
        $destBasePath = storage_path('app/public/uploads/hosting-packages');

        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        // Get config packages
        $config = config('packages-hosting') ?? [];

        $order = 1;

        foreach ($config as $category => $packages) {
            foreach ($packages as $index => $packageData) {
                // Copy image
                $sourceFile = $sourcePath . '/plan-' . ($index + 1) . '.png';
                $destDir = $destBasePath . '/' . $order;

                if (!File::isDirectory($destDir)) {
                    File::makeDirectory($destDir, 0755, true);
                }

                $destFileName = 'package_' . $order . '.png';
                $destFile = $destDir . '/' . $destFileName;

                if (File::exists($sourceFile) && !File::exists($destFile)) {
                    File::copy($sourceFile, $destFile);
                }

                $imagePath = 'uploads/hosting-packages/' . $order . '/' . $destFileName;

                // Extract features from config
                $features = [];
                if (isset($packageData['features']) && is_array($packageData['features'])) {
                    foreach ($packageData['features'] as $feature) {
                        $features[] = [
                            'title_en' => $feature['title'] ?? '',
                            'label_en' => $feature['label'] ?? '',
                            'title_ar' => $feature['title'] ?? '', // Using same in demo
                            'label_ar' => $feature['label'] ?? '',
                        ];
                    }
                }

                HostingPackage::create([
                    'category' => $category,
                    'slug' => $category . '-' . str_replace(' ', '-', strtolower($packageData['name'] ?? 'package-' . $order)),
                    'translations' => [
                        'ar' => [
                            'title' => $packageData['name'] ?? 'Package ' . $order,
                            'description' => 'باقة ' . ($packageData['name'] ?? 'Package ' . $order),
                        ],
                        'en' => [
                            'title' => $packageData['name'] ?? 'Package ' . $order,
                            'description' => 'Package ' . ($packageData['name'] ?? 'Package ' . $order),
                        ],
                    ],
                    'monthly_price' => $packageData['month_price'] ?? 0,
                    'yearly_price' => $packageData['year_price'] ?? 0,
                    'features' => $features,
                    'image' => File::exists($destFile) ? $imagePath : null,
                    'is_popular' => $packageData['is_popular'] ?? false,
                    'is_active' => $packageData['is_active'] ?? false,
                    'order' => $order,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]);
                $order++;
            }
        }
    }
}
