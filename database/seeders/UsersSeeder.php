<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // Super Admin
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@firstmagency.com'],

            [
                'name' => 'Super Admin',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => '1.png',
                'role' => 'superadmin',
                'last_login_ip' => null,
                'last_login_at' => null,
                'password_changed_at' => null,
                'status' => 'inactive',
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
            ]
        );

        $superadmin->assignRole('superadmin');

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@firstmagency.com'],

            [
                'name' => 'Admin',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => '2.png',
                'role' => 'admin',
                'last_login_ip' => null,
                'last_login_at' => null,
                'password_changed_at' => null,
                'status' => 'inactive',
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
            ]
        );

        $admin->assignRole('admin');

        // Content Manager
        $content_manager = User::firstOrCreate(
            ['email' => 'content@firstmagency.com'],

            [
                'name' => 'Content Manager',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => '6.png',
                'role' => 'content_manager',
                'last_login_ip' => null,
                'last_login_at' => null,
                'password_changed_at' => null,
                'status' => 'inactive',
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
            ]
        );

        $content_manager->assignRole('content_manager');

        // Support - Technical Support
        $support_technical = User::firstOrCreate(
            ['email' => 'support@firstmagency.com'],

            [
                'name' => 'محمد احمد',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => '8.png',
                'role' => 'support',
                'last_login_ip' => null,
                'last_login_at' => null,
                'password_changed_at' => null,
                'status' => 'active',
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
                'website_locale' => 'en',
                'dashboard_locale' => 'en',
            ]
        );
        $support_technical->assignRole('support');

        // Support - Sales
        $support_sales = User::firstOrCreate(
            ['email' => 'sales@firstmagency.com'],

            [
                'name' => 'احمد محمد',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => '6.png',
                'role' => 'support',
                'last_login_ip' => null,
                'last_login_at' => null,
                'password_changed_at' => null,
                'status' => 'active',
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
                'website_locale' => 'en',
                'dashboard_locale' => 'en',
            ]
        );
        $support_sales->assignRole('support');

        // Support - Billing
        $support_billing = User::firstOrCreate(
            ['email' => 'billing@firstmagency.com'],

            [
                'name' => 'علي حسن',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => '9.png',
                'role' => 'support',
                'last_login_ip' => null,
                'last_login_at' => null,
                'password_changed_at' => null,
                'status' => 'active',
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
                'website_locale' => 'en',
                'dashboard_locale' => 'en',
            ]
        );
        $support_billing->assignRole('support');

        // Support - Complaints
        $support_complaints = User::firstOrCreate(
            ['email' => 'complaints@firstmagency.com'],

            [
                'name' => 'سارة علي',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => '3.png',
                'role' => 'support',
                'last_login_ip' => null,
                'last_login_at' => null,
                'password_changed_at' => null,
                'status' => 'active',
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
                'website_locale' => 'en',
                'dashboard_locale' => 'en',
            ]
        );
        $support_complaints->assignRole('support');
    }
}
