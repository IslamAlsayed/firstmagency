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

        $user = User::where('email', 'admin@example.com')->first() ?? User::first();

        if (!$user) return;

        $departments = [
            [
                'name' => 'محمد احمد',
                'title' => 'Technical Support',
                'slug' => 'technical-support',
                'description' => 'دائرة الدعم الفني للعملاء',
                'email' => 'support@example.com',
                'phone' => '+966123456789',
                'whatsapp' => '+966123456789',
                'order' => 1,
                'image' => '1.jpg',
            ],
            [
                'name' => 'احمد محمد',
                'title' => 'Sales',
                'slug' => 'sales',
                'description' => 'دائرة المبيعات والاستشارات',
                'email' => 'sales@example.com',
                'phone' => '+966987654321',
                'whatsapp' => '+966987654321',
                'order' => 2,
                'image' => '2.jpg',
            ],
            [
                'name' => 'علي حسن',
                'title' => 'Billing',
                'slug' => 'billing',
                'description' => 'دائرة الفواتير والمدفوعات',
                'email' => 'billing@example.com',
                'phone' => '+966111111111',
                'whatsapp' => '+966111111111',
                'order' => 3,
                'image' => '3.jpg',
            ],
            [
                'name' => 'سارة علي',
                'title' => 'Complaints and Suggestions',
                'slug' => 'complaints',
                'description' => 'دائرة الشكاوى والاقتراحات',
                'email' => 'complaints@example.com',
                'phone' => '+966222222222',
                'whatsapp' => '+966222222222',
                'order' => 4,
                'image' => '4.jpg',
            ],
        ];

        foreach ($departments as $department) {
            Department::create([
                ...$department,
                'title' => strtolower(str_replace(' ', '_', $department['title'])),
                'is_active' => true,
                'created_by' => $user->id,
            ]);
        }
    }
}
