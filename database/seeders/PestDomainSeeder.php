<?php

namespace Database\Seeders;

use App\Models\PestDomain;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class PestDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        PestDomain::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@firstmagency.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/domains/pest-domains');
        $destBasePath = storage_path('app/public/uploads/pest-domains');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        // Create 16 pest domains with real image uploads
        for ($i = 1; $i <= 16; $i++) {
            $sourceFile = $sourcePath . '/' . $i . '.png';

            if (!File::exists($sourceFile)) {
                echo "⚠️  Source file not found: $sourceFile\n";
                continue;
            }

            // Create directory for this pest domain
            $domainDir = $destBasePath . '/' . $i;
            if (!File::isDirectory($domainDir)) {
                File::makeDirectory($domainDir, 0755, true);
            }

            // Copy the image with a new name
            $destFileName = 'pest_domain_' . $i . '.png';
            $destFile = $domainDir . '/' . $destFileName;

            // Only copy if destination doesn't exist
            if (!File::exists($destFile)) {
                File::copy($sourceFile, $destFile);
            }

            // Save relative path for database storage (like: uploads/pest-domains/1/pest_domain_1.png)
            $imagePath = 'uploads/pest-domains/' . $i . '/' . $destFileName;

            // Create or update pest domain record
            PestDomain::updateOrCreate(
                ['slug' => 'pest-domain-' . str_pad($i, 2, '0', STR_PAD_LEFT)],
                [
                    'translations' => [
                        'ar' => [
                            'name' => 'نطاق #' . $i,
                            'description' => 'وصف النطاق رقم ' . $i . ' - نطاق متميز لخدمات ويب عالية الجودة',
                        ],
                        'en' => [
                            'name' => 'Domain #' . $i,
                            'description' => 'Description for domain number ' . $i . ' - A premium domain service',
                        ],
                    ],
                    'image' => $imagePath,
                    'alt_text' => 'Pest Domain ' . $i,
                    'website' => 'https://example-pest-domain-' . $i . '.com',
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
