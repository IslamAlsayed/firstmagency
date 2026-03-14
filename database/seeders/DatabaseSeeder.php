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
            DepartmentSeeder::class,
            SectionSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            ServiceSeeder::class,
            ProjectSeeder::class,
            ReviewSeeder::class,
            ClientSeeder::class,
            LineWorkSeeder::class,
            PartnerSeeder::class,
            FAQSeeder::class,
            ProgrammingCategorySeeder::class,
            ProgrammingSystemSeeder::class,
            ProjectStepSeeder::class,
            HostingFeatureSeeder::class,
            DashboardsAndSystemsSeeder::class,
            HostingPackageSeeder::class,
            PestDomainSeeder::class,
            OfficialDomainSeeder::class,
            WhyUsSeeder::class,
            PlatformManagementSeeder::class,
            WorkUsStepSeeder::class,
            MarketingPackageSeeder::class,
        ]);
    }
};
