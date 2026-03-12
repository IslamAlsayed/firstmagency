<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Client::truncate();
        Schema::enableForeignKeyConstraints();

        // Get current user or find content user
        $user = getActiveUser() ?? User::where('email', 'content@example.com')->first() ?? User::first();

        if (!$user) {
            echo "⚠️  No users found. Please create users first.\n";
            return;
        }

        // Paths configuration
        $sourcePath = base_path('public/assets/images/website/clients');
        $destBasePath = storage_path('app/public/uploads/clients');

        // Ensure the destination directory exists
        if (!File::isDirectory($destBasePath)) {
            File::makeDirectory($destBasePath, 0755, true);
        }

        // Create 12 clients with real image uploads
        for ($i = 1; $i <= 12; $i++) {
            $sourceFile = $sourcePath . '/' . $i . '.png';

            if (!File::exists($sourceFile)) {
                echo "⚠️  Source file not found: $sourceFile\n";
                continue;
            }

            // Create directory for this client
            $clientDir = $destBasePath . '/' . $i;
            if (!File::isDirectory($clientDir)) {
                File::makeDirectory($clientDir, 0755, true);
            }

            // Copy the image with a new name
            $destFileName = 'client_' . $i . '.png';
            $destFile = $clientDir . '/' . $destFileName;

            // Only copy if destination doesn't exist
            if (!File::exists($destFile)) {
                File::copy($sourceFile, $destFile);
            }

            // Save relative path for database storage (like: uploads/clients/1/client_1.png)
            $imagePath = 'uploads/clients/' . $i . '/' . $destFileName;

            // Create or update client record
            Client::updateOrCreate(
                ['slug' => 'client-' . str_pad($i, 2, '0', STR_PAD_LEFT)],
                [
                    'translations' => [
                        'ar' => [
                            'name' => 'عميل #' . $i,
                            'description' => 'وصف العميل رقم ' . $i . ' - شركة متميزة في مجالها',
                        ],
                        'en' => [
                            'name' => 'Client #' . $i,
                            'description' => 'Description for client number ' . $i . ' - A leading company in its field',
                        ],
                    ],
                    'image' => $imagePath,
                    'alt_text' => 'Client ' . $i . ' Logo',
                    'website' => 'https://example-client-' . $i . '.com',
                    'order' => $i,
                    'status' => 'published',
                    'is_active' => true,
                    'is_featured' => $i <= 4, // Featured first 4 clients
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );
        }
    }
}
