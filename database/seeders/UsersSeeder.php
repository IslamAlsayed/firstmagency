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
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => fake()->imageUrl(),
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
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => fake()->imageUrl(),
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
            ['email' => 'content@example.com'],
            [
                'name' => 'Content Manager',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => fake()->imageUrl(),
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

        // Support
        $support = User::firstOrCreate(
            ['email' => 'support@example.com'],
            [
                'name' => 'Support',
                'password' => '12345678',
                'email_verified_at' => now(),
                'address' => fake()->address(),
                'bio' => fake()->text(),
                'mobile' => fake()->phoneNumber(),
                'phone' => fake()->phoneNumber(),
                'photo' => fake()->imageUrl(),
                'role' => 'support',
                'last_login_ip' => null,
                'last_login_at' => null,
                'password_changed_at' => null,
                'status' => 'inactive',
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
            ]
        );
        $support->assignRole('support');
    }
}
