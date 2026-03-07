<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            SettingsSeeder::class,
            UsersSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            ServiceSeeder::class,
            CompanySeeder::class,
            ClientSeeder::class,
            PartnerSeeder::class,
            FAQSeeder::class,
            OurProgrammingSeeder::class,
            ProjectStepSeeder::class,
        ]);
    }
}
