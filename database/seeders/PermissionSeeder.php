<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing permissions and roles (with foreign key handling)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Role::truncate();
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Define all permissions
        $permissions = [
            // Users Permissions
            ['name' => 'users-create', 'guard_name' => 'web', 'description' => 'Create new users'],
            ['name' => 'users-read', 'guard_name' => 'web', 'description' => 'View users'],
            ['name' => 'users-update', 'guard_name' => 'web', 'description' => 'Edit users'],
            ['name' => 'users-delete', 'guard_name' => 'web', 'description' => 'Delete users'],
            ['name' => 'users-restore', 'guard_name' => 'web', 'description' => 'Restore users'],
            ['name' => 'users-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete users'],

            // Roles Permissions
            ['name' => 'roles-create', 'guard_name' => 'web', 'description' => 'Create new roles'],
            ['name' => 'roles-read', 'guard_name' => 'web', 'description' => 'View roles'],
            ['name' => 'roles-update', 'guard_name' => 'web', 'description' => 'Edit roles'],
            ['name' => 'roles-delete', 'guard_name' => 'web', 'description' => 'Delete roles'],
            ['name' => 'roles-restore', 'guard_name' => 'web', 'description' => 'Restore roles'],
            ['name' => 'roles-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete roles'],

            // Permissions Management
            ['name' => 'permissions-create', 'guard_name' => 'web', 'description' => 'Create permissions'],
            ['name' => 'permissions-read', 'guard_name' => 'web', 'description' => 'View permissions'],
            ['name' => 'permissions-update', 'guard_name' => 'web', 'description' => 'Edit permissions'],
            ['name' => 'permissions-delete', 'guard_name' => 'web', 'description' => 'Delete permissions'],
            ['name' => 'permissions-restore', 'guard_name' => 'web', 'description' => 'Restore permissions'],
            ['name' => 'permissions-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete permissions'],

            // Settings Permissions
            ['name' => 'settings-read', 'guard_name' => 'web', 'description' => 'View settings'],
            ['name' => 'settings-update', 'guard_name' => 'web', 'description' => 'Edit settings'],

            // Content Permissions
            ['name' => 'content-create', 'guard_name' => 'web', 'description' => 'Create content'],
            ['name' => 'content-read', 'guard_name' => 'web', 'description' => 'View content'],
            ['name' => 'content-update', 'guard_name' => 'web', 'description' => 'Edit content'],
            ['name' => 'content-delete', 'guard_name' => 'web', 'description' => 'Delete content'],
            ['name' => 'content-restore', 'guard_name' => 'web', 'description' => 'Restore content'],
            ['name' => 'content-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete content'],

            // Articles Permissions
            ['name' => 'articles-create', 'guard_name' => 'web', 'description' => 'Create articles'],
            ['name' => 'articles-read', 'guard_name' => 'web', 'description' => 'View articles'],
            ['name' => 'articles-update', 'guard_name' => 'web', 'description' => 'Edit articles'],
            ['name' => 'articles-delete', 'guard_name' => 'web', 'description' => 'Delete articles'],
            ['name' => 'articles-restore', 'guard_name' => 'web', 'description' => 'Restore articles'],
            ['name' => 'articles-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete articles'],

            // Services Permissions
            ['name' => 'services-create', 'guard_name' => 'web', 'description' => 'Create services'],
            ['name' => 'services-read', 'guard_name' => 'web', 'description' => 'View services'],
            ['name' => 'services-update', 'guard_name' => 'web', 'description' => 'Edit services'],
            ['name' => 'services-delete', 'guard_name' => 'web', 'description' => 'Delete services'],
            ['name' => 'services-restore', 'guard_name' => 'web', 'description' => 'Restore services'],
            ['name' => 'services-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete services'],

            // Companies Permissions
            ['name' => 'companies-create', 'guard_name' => 'web', 'description' => 'Create companies'],
            ['name' => 'companies-read', 'guard_name' => 'web', 'description' => 'View companies'],
            ['name' => 'companies-update', 'guard_name' => 'web', 'description' => 'Edit companies'],
            ['name' => 'companies-delete', 'guard_name' => 'web', 'description' => 'Delete companies'],
            ['name' => 'companies-restore', 'guard_name' => 'web', 'description' => 'Restore companies'],
            ['name' => 'companies-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete companies'],

            // Dashboard Permissions
            ['name' => 'dashboard-access', 'guard_name' => 'web', 'description' => 'Access dashboard'],
            ['name' => 'dashboard-manage', 'guard_name' => 'web', 'description' => 'Manage dashboard'],
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name'], 'guard_name' => $permission['guard_name']],
                $permission
            );
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $contentManagerRole = Role::firstOrCreate(['name' => 'content_manager', 'guard_name' => 'web']);
        $supportRole = Role::firstOrCreate(['name' => 'support', 'guard_name' => 'web']);

        // Assign all permissions to superadmin
        $superAdminRole->syncPermissions(Permission::all());

        // Assign admin permissions
        $adminPermissions = Permission::whereIn('name', [
            'users-create',
            'users-read',
            'users-update',
            'users-delete',
            'roles-create',
            'roles-read',
            'roles-update',
            'roles-delete',
            'settings-read',
            'settings-update',
            'content-create',
            'content-read',
            'content-update',
            'content-delete',
            'articles-create',
            'articles-read',
            'articles-update',
            'articles-delete',
            'articles-restore',
            'articles-force-delete',
            'services-create',
            'services-read',
            'services-update',
            'services-delete',
            'services-restore',
            'services-force-delete',
            'companies-create',
            'companies-read',
            'companies-update',
            'companies-delete',
            'companies-restore',
            'companies-force-delete',
            'dashboard-access',
            'dashboard-manage',
        ])->get();
        $adminRole->syncPermissions($adminPermissions);

        // Assign content manager permissions
        $contentManagerPermissions = Permission::whereIn('name', [
            'content-create',
            'content-read',
            'content-update',
            'articles-create',
            'articles-read',
            'articles-update',
            'services-create',
            'services-read',
            'services-update',
            'companies-create',
            'companies-read',
            'companies-update',
            'dashboard-access',
        ])->get();
        $contentManagerRole->syncPermissions($contentManagerPermissions);

        $supportPermissions = Permission::whereIn('name', [
            'content-read',
            'dashboard-access',
        ])->get();
        $supportRole->syncPermissions($supportPermissions);

        $this->command->info('Permissions and roles seeded successfully!');
    }
}
