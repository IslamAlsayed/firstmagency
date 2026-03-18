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

            // Departments Permissions
            ['name' => 'departments-create', 'guard_name' => 'web', 'description' => 'Create new departments'],
            ['name' => 'departments-read', 'guard_name' => 'web', 'description' => 'View departments'],
            ['name' => 'departments-update', 'guard_name' => 'web', 'description' => 'Edit departments'],
            ['name' => 'departments-delete', 'guard_name' => 'web', 'description' => 'Delete departments'],
            ['name' => 'departments-restore', 'guard_name' => 'web', 'description' => 'Restore departments'],
            ['name' => 'departments-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete departments'],

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

            // Project Permissions
            ['name' => 'project-create', 'guard_name' => 'web', 'description' => 'Create project'],
            ['name' => 'project-read', 'guard_name' => 'web', 'description' => 'View project'],
            ['name' => 'project-update', 'guard_name' => 'web', 'description' => 'Edit project'],
            ['name' => 'project-delete', 'guard_name' => 'web', 'description' => 'Delete project'],
            ['name' => 'project-restore', 'guard_name' => 'web', 'description' => 'Restore project'],
            ['name' => 'project-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete project'],

            // Companies Permissions
            ['name' => 'companies-create', 'guard_name' => 'web', 'description' => 'Create companies'],
            ['name' => 'companies-read', 'guard_name' => 'web', 'description' => 'View companies'],
            ['name' => 'companies-update', 'guard_name' => 'web', 'description' => 'Edit companies'],
            ['name' => 'companies-delete', 'guard_name' => 'web', 'description' => 'Delete companies'],
            ['name' => 'companies-restore', 'guard_name' => 'web', 'description' => 'Restore companies'],
            ['name' => 'companies-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete companies'],

            // Clients Permissions
            ['name' => 'clients-create', 'guard_name' => 'web', 'description' => 'Create clients'],
            ['name' => 'clients-read', 'guard_name' => 'web', 'description' => 'View clients'],
            ['name' => 'clients-update', 'guard_name' => 'web', 'description' => 'Edit clients'],
            ['name' => 'clients-delete', 'guard_name' => 'web', 'description' => 'Delete clients'],
            ['name' => 'clients-restore', 'guard_name' => 'web', 'description' => 'Restore clients'],
            ['name' => 'clients-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete clients'],

            // Partners Permissions
            ['name' => 'partners-create', 'guard_name' => 'web', 'description' => 'Create partners'],
            ['name' => 'partners-read', 'guard_name' => 'web', 'description' => 'View partners'],
            ['name' => 'partners-update', 'guard_name' => 'web', 'description' => 'Edit partners'],
            ['name' => 'partners-delete', 'guard_name' => 'web', 'description' => 'Delete partners'],
            ['name' => 'partners-restore', 'guard_name' => 'web', 'description' => 'Restore partners'],
            ['name' => 'partners-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete partners'],

            // LineWorks Permissions
            ['name' => 'line-works-create', 'guard_name' => 'web', 'description' => 'Create line works'],
            ['name' => 'line-works-read', 'guard_name' => 'web', 'description' => 'View line works'],
            ['name' => 'line-works-update', 'guard_name' => 'web', 'description' => 'Edit line works'],
            ['name' => 'line-works-delete', 'guard_name' => 'web', 'description' => 'Delete line works'],
            ['name' => 'line-works-restore', 'guard_name' => 'web', 'description' => 'Restore line works'],
            ['name' => 'line-works-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete line works'],

            // Reviews Permissions
            ['name' => 'reviews-create', 'guard_name' => 'web', 'description' => 'Create reviews'],
            ['name' => 'reviews-read', 'guard_name' => 'web', 'description' => 'View reviews'],
            ['name' => 'reviews-update', 'guard_name' => 'web', 'description' => 'Edit reviews'],
            ['name' => 'reviews-delete', 'guard_name' => 'web', 'description' => 'Delete reviews'],
            ['name' => 'reviews-restore', 'guard_name' => 'web', 'description' => 'Restore reviews'],
            ['name' => 'reviews-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete reviews'],

            // Programming Permissions
            ['name' => 'programming-systems-create', 'guard_name' => 'web', 'description' => 'Create programming systems'],
            ['name' => 'programming-systems-read', 'guard_name' => 'web', 'description' => 'View programming systems'],
            ['name' => 'programming-systems-update', 'guard_name' => 'web', 'description' => 'Edit programming systems'],
            ['name' => 'programming-systems-delete', 'guard_name' => 'web', 'description' => 'Delete programming systems'],
            ['name' => 'programming-systems-restore', 'guard_name' => 'web', 'description' => 'Restore programming systems'],
            ['name' => 'programming-systems-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete programming systems'],

            // Our Programming Permissions
            ['name' => 'programming-categories-create', 'guard_name' => 'web', 'description' => 'Create programming categories'],
            ['name' => 'programming-categories-read', 'guard_name' => 'web', 'description' => 'View programming categories'],
            ['name' => 'programming-categories-update', 'guard_name' => 'web', 'description' => 'Edit programming categories'],
            ['name' => 'programming-categories-delete', 'guard_name' => 'web', 'description' => 'Delete programming categories'],
            ['name' => 'programming-categories-restore', 'guard_name' => 'web', 'description' => 'Restore programming categories'],
            ['name' => 'programming-categories-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete programming categories'],

            // Project Steps Permissions
            ['name' => 'project-steps-create', 'guard_name' => 'web', 'description' => 'Create project steps'],
            ['name' => 'project-steps-read', 'guard_name' => 'web', 'description' => 'View project steps'],
            ['name' => 'project-steps-update', 'guard_name' => 'web', 'description' => 'Edit project steps'],
            ['name' => 'project-steps-delete', 'guard_name' => 'web', 'description' => 'Delete project steps'],
            ['name' => 'project-steps-restore', 'guard_name' => 'web', 'description' => 'Restore project steps'],
            ['name' => 'project-steps-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete project steps'],

            // Hosting Features Permissions
            ['name' => 'hosting-features-create', 'guard_name' => 'web', 'description' => 'Create hosting features'],
            ['name' => 'hosting-features-read', 'guard_name' => 'web', 'description' => 'View hosting features'],
            ['name' => 'hosting-features-update', 'guard_name' => 'web', 'description' => 'Edit hosting features'],
            ['name' => 'hosting-features-delete', 'guard_name' => 'web', 'description' => 'Delete hosting features'],
            ['name' => 'hosting-features-restore', 'guard_name' => 'web', 'description' => 'Restore hosting features'],
            ['name' => 'hosting-features-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete hosting features'],

            // Dashboards And Apps Permissions
            ['name' => 'dashboards-and-systems-create', 'guard_name' => 'web', 'description' => 'Create dashboards and apps'],
            ['name' => 'dashboards-and-systems-read', 'guard_name' => 'web', 'description' => 'View dashboards and apps'],
            ['name' => 'dashboards-and-systems-update', 'guard_name' => 'web', 'description' => 'Edit dashboards and apps'],
            ['name' => 'dashboards-and-systems-delete', 'guard_name' => 'web', 'description' => 'Delete dashboards and apps'],
            ['name' => 'dashboards-and-systems-restore', 'guard_name' => 'web', 'description' => 'Restore dashboards and apps'],
            ['name' => 'dashboards-and-systems-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete dashboards and apps'],

            // FAQs Permissions
            ['name' => 'faqs-create', 'guard_name' => 'web', 'description' => 'Create FAQs'],
            ['name' => 'faqs-read', 'guard_name' => 'web', 'description' => 'View FAQs'],
            ['name' => 'faqs-update', 'guard_name' => 'web', 'description' => 'Edit FAQs'],
            ['name' => 'faqs-delete', 'guard_name' => 'web', 'description' => 'Delete FAQs'],
            ['name' => 'faqs-restore', 'guard_name' => 'web', 'description' => 'Restore FAQs'],
            ['name' => 'faqs-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete FAQs'],

            // Tickets Permissions
            ['name' => 'tickets-create', 'guard_name' => 'web', 'description' => 'Create tickets'],
            ['name' => 'tickets-read', 'guard_name' => 'web', 'description' => 'View tickets'],
            ['name' => 'tickets-update', 'guard_name' => 'web', 'description' => 'Edit tickets'],
            ['name' => 'tickets-delete', 'guard_name' => 'web', 'description' => 'Delete tickets'],
            ['name' => 'tickets-restore', 'guard_name' => 'web', 'description' => 'Restore tickets'],
            ['name' => 'tickets-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete tickets'],

            // Hosting Packages Permissions
            ['name' => 'hosting-packages-create', 'guard_name' => 'web', 'description' => 'Create hosting packages'],
            ['name' => 'hosting-packages-read', 'guard_name' => 'web', 'description' => 'View hosting packages'],
            ['name' => 'hosting-packages-update', 'guard_name' => 'web', 'description' => 'Edit hosting packages'],
            ['name' => 'hosting-packages-delete', 'guard_name' => 'web', 'description' => 'Delete hosting packages'],
            ['name' => 'hosting-packages-restore', 'guard_name' => 'web', 'description' => 'Restore hosting packages'],
            ['name' => 'hosting-packages-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete hosting packages'],

            // Pest Domains Permissions
            ['name' => 'pest-domains-create', 'guard_name' => 'web', 'description' => 'Create pest domains'],
            ['name' => 'pest-domains-read', 'guard_name' => 'web', 'description' => 'View pest domains'],
            ['name' => 'pest-domains-update', 'guard_name' => 'web', 'description' => 'Edit pest domains'],
            ['name' => 'pest-domains-delete', 'guard_name' => 'web', 'description' => 'Delete pest domains'],
            ['name' => 'pest-domains-restore', 'guard_name' => 'web', 'description' => 'Restore pest domains'],
            ['name' => 'pest-domains-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete pest domains'],

            // Official Domains Permissions
            ['name' => 'official-domains-create', 'guard_name' => 'web', 'description' => 'Create official domains'],
            ['name' => 'official-domains-read', 'guard_name' => 'web', 'description' => 'View official domains'],
            ['name' => 'official-domains-update', 'guard_name' => 'web', 'description' => 'Edit official domains'],
            ['name' => 'official-domains-delete', 'guard_name' => 'web', 'description' => 'Delete official domains'],
            ['name' => 'official-domains-restore', 'guard_name' => 'web', 'description' => 'Restore official domains'],
            ['name' => 'official-domains-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete official domains'],

            // Why Us Permissions
            ['name' => 'why-us-create', 'guard_name' => 'web', 'description' => 'Create Why Us items'],
            ['name' => 'why-us-read', 'guard_name' => 'web', 'description' => 'View Why Us items'],
            ['name' => 'why-us-update', 'guard_name' => 'web', 'description' => 'Edit Why Us items'],
            ['name' => 'why-us-delete', 'guard_name' => 'web', 'description' => 'Delete Why Us items'],
            ['name' => 'why-us-restore', 'guard_name' => 'web', 'description' => 'Restore Why Us items'],
            ['name' => 'why-us-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete Why Us items'],

            // Platform Management Permissions
            ['name' => 'platform-management-create', 'guard_name' => 'web', 'description' => 'Create Platform Management items'],
            ['name' => 'platform-management-read', 'guard_name' => 'web', 'description' => 'View Platform Management items'],
            ['name' => 'platform-management-update', 'guard_name' => 'web', 'description' => 'Edit Platform Management items'],
            ['name' => 'platform-management-delete', 'guard_name' => 'web', 'description' => 'Delete Platform Management items'],
            ['name' => 'platform-management-restore', 'guard_name' => 'web', 'description' => 'Restore Platform Management items'],
            ['name' => 'platform-management-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete Platform Management items'],

            // Work Us Step Permissions
            ['name' => 'work-us-step-create', 'guard_name' => 'web', 'description' => 'Create Work Us Step items'],
            ['name' => 'work-us-step-read', 'guard_name' => 'web', 'description' => 'View Work Us Step items'],
            ['name' => 'work-us-step-update', 'guard_name' => 'web', 'description' => 'Edit Work Us Step items'],
            ['name' => 'work-us-step-delete', 'guard_name' => 'web', 'description' => 'Delete Work Us Step items'],
            ['name' => 'work-us-step-restore', 'guard_name' => 'web', 'description' => 'Restore Work Us Step items'],
            ['name' => 'work-us-step-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete Work Us Step items'],

            // Marketing Packages Permissions
            ['name' => 'marketing-packages-create', 'guard_name' => 'web', 'description' => 'Create Marketing Package items'],
            ['name' => 'marketing-packages-read', 'guard_name' => 'web', 'description' => 'View Marketing Package items'],
            ['name' => 'marketing-packages-update', 'guard_name' => 'web', 'description' => 'Edit Marketing Package items'],
            ['name' => 'marketing-packages-delete', 'guard_name' => 'web', 'description' => 'Delete Marketing Package items'],
            ['name' => 'marketing-packages-restore', 'guard_name' => 'web', 'description' => 'Restore Marketing Package items'],
            ['name' => 'marketing-packages-force-delete', 'guard_name' => 'web', 'description' => 'Permanently delete Marketing Package items'],

            // Dashboard Permissions
            ['name' => 'dashboard-access', 'guard_name' => 'web', 'description' => 'Access dashboard'],
            ['name' => 'dashboard-manage', 'guard_name' => 'web', 'description' => 'Manage dashboard'],

            // Settings Permissions
            ['name' => 'settings-read', 'guard_name' => 'web', 'description' => 'View settings'],
            ['name' => 'settings-update', 'guard_name' => 'web', 'description' => 'Edit settings'],
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
            'departments-create',
            'departments-read',
            'departments-update',
            'departments-delete',
            'roles-create',
            'roles-read',
            'roles-update',
            'roles-delete',
            'permissions-create',
            'permissions-read',
            'permissions-update',
            'permissions-delete',
            'content-create',
            'content-read',
            'content-update',
            'content-delete',
            'articles-create',
            'articles-read',
            'articles-update',
            'articles-delete',
            'services-create',
            'services-read',
            'services-update',
            'services-delete',
            'projects-create',
            'projects-read',
            'projects-update',
            'projects-delete',
            'companies-create',
            'companies-read',
            'companies-update',
            'companies-delete',
            'clients-create',
            'clients-read',
            'clients-update',
            'clients-delete',
            'partners-create',
            'partners-read',
            'partners-update',
            'partners-delete',
            'line-works-create',
            'line-works-read',
            'line-works-update',
            'line-works-delete',
            'reviews-create',
            'reviews-read',
            'reviews-update',
            'reviews-delete',
            'programming-systems-create',
            'programming-systems-read',
            'programming-systems-update',
            'programming-systems-delete',
            'programming-categories-create',
            'programming-categories-read',
            'programming-categories-update',
            'programming-categories-delete',
            'categories-programming-create',
            'categories-programming-read',
            'categories-programming-update',
            'categories-programming-delete',
            'project-steps-create',
            'project-steps-read',
            'project-steps-update',
            'project-steps-delete',
            'hosting-features-create',
            'hosting-features-read',
            'hosting-features-update',
            'hosting-features-delete',
            'faqs-create',
            'faqs-read',
            'faqs-update',
            'faqs-delete',
            'tickets-create',
            'tickets-read',
            'tickets-update',
            'tickets-delete',
            'dashboards-and-systems-create',
            'dashboards-and-systems-read',
            'dashboards-and-systems-update',
            'dashboards-and-systems-delete',
            'hosting-packages-create',
            'hosting-packages-read',
            'hosting-packages-update',
            'hosting-packages-delete',
            'pest-domains-create',
            'pest-domains-read',
            'pest-domains-update',
            'pest-domains-delete',
            'official-domains-create',
            'official-domains-read',
            'official-domains-update',
            'official-domains-delete',
            'why-us-create',
            'why-us-read',
            'why-us-update',
            'why-us-delete',
            'platform-management-create',
            'platform-management-read',
            'platform-management-update',
            'platform-management-delete',
            'work-us-step-create',
            'work-us-step-read',
            'work-us-step-update',
            'work-us-step-delete',
            'marketing-packages-create',
            'marketing-packages-read',
            'marketing-packages-update',
            'marketing-packages-delete',
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
            'clients-create',
            'clients-read',
            'clients-update',
            'partners-create',
            'partners-read',
            'partners-update',
            'line-works-create',
            'line-works-read',
            'line-works-update',
            'reviews-create',
            'reviews-read',
            'reviews-update',
            'programming-systems-create',
            'programming-systems-read',
            'programming-systems-update',
            'programming-categories-create',
            'programming-categories-read',
            'programming-categories-update',
            'categories-programming-create',
            'categories-programming-read',
            'categories-programming-update',
            'project-steps-create',
            'project-steps-read',
            'project-steps-update',
            'faqs-read',
            'faqs-update',
            'dashboard-access',
            'settings-read',
            'settings-update',
        ])->get();
        $contentManagerRole->syncPermissions($contentManagerPermissions);

        // Assign Support permissions
        $supportPermissions = Permission::whereIn('name', [
            'content-read',
            'dashboard-access',

            'tickets-create',
            'tickets-read',
            'tickets-update',
        ])->get();
        $supportRole->syncPermissions($supportPermissions);
    }
}
