<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Partner::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@firstmagency.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/partners');
        $destBasePath = storage_path('app/public/uploads/partners');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        // Create 6 partners with real image uploads
        for ($i = 1; $i <= 6; $i++) {
            $sourceFile = $sourcePath . '/' . $i . '.png';

            if (!File::exists($sourceFile)) {
                echo "⚠️  Source file not found: $sourceFile\n";
                continue;
            }

            // Create directory for this partner
            $partnerDir = $destBasePath . '/' . $i;
            if (!File::isDirectory($partnerDir)) {
                File::makeDirectory($partnerDir, 0755, true);
            }

            // Copy the image with a new name
            $destFileName = 'partner_' . $i . '.png';
            $destFile = $partnerDir . '/' . $destFileName;

            // Only copy if destination doesn't exist
            if (!File::exists($destFile)) {
                File::copy($sourceFile, $destFile);
            }

            // Save relative path for database storage (like: uploads/partners/1/partner_1.png)
            $imagePath = 'uploads/partners/' . $i . '/' . $destFileName;

            // Create or update partner record
            Partner::updateOrCreate(
                ['slug' => 'partner-' . str_pad($i, 2, '0', STR_PAD_LEFT)],
                [
                    'translations' => [
                        'ar' => [
                            'name' => 'شريك #' . $i,
                            'description' => 'وصف الشريك رقم ' . $i . ' - شركة متميزة في مجالها',
                        ],
                        'en' => [
                            'name' => 'Partner #' . $i,
                            'description' => 'Description for partner number ' . $i . ' - A leading company in its field',
                        ],
                    ],
                    'image' => $imagePath,
                    'alt_text' => 'Partner ' . $i . ' Logo',
                    'website' => 'https://example-partner-' . $i . '.com',
                    'order' => $i,
                    'status' => 'published',
                    'is_active' => true,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }
    }
}
