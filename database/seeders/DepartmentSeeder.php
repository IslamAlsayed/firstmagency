<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Department::truncate();
        Schema::enableForeignKeyConstraints();

        // Get users (they must exist from UsersSeeder)
        $superadmin = User::where('email', 'info@firstmagency.com')->first();
        // $admin = User::where('email', 'admin@live4.firstmagency.com')->first();
        // $contentManager = User::where('email', 'contentmanager@live4.firstmagency.com')->first();

        // $adminUser = User::where('email', 'admin@firstmagency.com')->first() ?? User::first();
        // if (!$superadmin) return;

        $departments = [
            // [
            //     'name' => 'Technical Support',
            //     'name_ar' => 'الدعم الفني',
            //     'user_id' => $superadmin->id,
            //     'bg_color' => '#eff6ff',
            //     'border_color' => '#bedbff',
            //     'border_main_color' => '#155dfb',
            //     'badge_color' => '#155dfb',
            // ],
            // [
            //     'name' => 'sales',
            //     'name_ar' => 'المبيعات',
            //     'user_id' => $supportSales->id,
            //     'bg_color' => '#f0fdf4',
            //     'border_color' => '#232524',
            //     'border_main_color' => '#00a63e',
            //     'badge_color' => '#00a63e',
            // ],
            // [
            //     'name' => 'billing',
            //     'name_ar' => 'الفوترة',
            //     'user_id' => $contentManager->id,
            //     'bg_color' => '#fefce8',
            //     'border_color' => '#fef08a',
            //     'border_main_color' => '#ca8a04',
            //     'badge_color' => '#ca8a04',
            // ],
            // [
            //     'name' => 'complaints_and_suggestions',
            //     'name_ar' => 'الشكاوى والاقتراحات',
            //     'user_id' => $supportComplaints->id,
            //     'bg_color' => '#fff7f5',
            //     'border_color' => '#ffd5cd',
            //     'border_main_color' => '#f92434',
            //     'badge_color' => '#f92434',
            // ],
        ];

        // foreach ($departments as $department) {
        //     Department::create([...$department]);
        // }
    }
}