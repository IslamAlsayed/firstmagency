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
            ['name' => 'users-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.users')])],
            ['name' => 'users-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.users')])],
            ['name' => 'users-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.users')])],
            ['name' => 'users-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.users')])],
            ['name' => 'users-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.users')])],
            ['name' => 'users-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.users')])],

            // Departments Permissions
            ['name' => 'departments-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.departments')])],
            ['name' => 'departments-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.departments')])],
            ['name' => 'departments-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.departments')])],
            ['name' => 'departments-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.departments')])],
            ['name' => 'departments-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.departments')])],
            ['name' => 'departments-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.departments')])],

            // Roles Permissions
            ['name' => 'roles-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.roles')])],
            ['name' => 'roles-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.roles')])],
            ['name' => 'roles-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.roles')])],
            ['name' => 'roles-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.roles')])],
            ['name' => 'roles-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.roles')])],
            ['name' => 'roles-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.roles')])],

            // Permissions Management
            ['name' => 'permissions-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.permissions')])],
            ['name' => 'permissions-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.permissions')])],
            ['name' => 'permissions-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.permissions')])],
            ['name' => 'permissions-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.permissions')])],
            ['name' => 'permissions-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.permissions')])],
            ['name' => 'permissions-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.permissions')])],

            // Content Permissions
            // ['name' => 'content-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.content')])],
            // ['name' => 'content-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.content')])],
            // ['name' => 'content-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.content')])],
            // ['name' => 'content-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.content')])],
            // ['name' => 'content-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.content')])],
            // ['name' => 'content-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.content')])],

            // Articles Permissions
            ['name' => 'articles-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.articles')])],
            ['name' => 'articles-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.articles')])],
            ['name' => 'articles-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.articles')])],
            ['name' => 'articles-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.articles')])],
            ['name' => 'articles-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.articles')])],
            ['name' => 'articles-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.articles')])],

            // Services Permissions
            ['name' => 'services-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.services')])],
            ['name' => 'services-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.services')])],
            ['name' => 'services-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.services')])],
            ['name' => 'services-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.services')])],
            ['name' => 'services-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.services')])],
            ['name' => 'services-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.services')])],

            // Project Permissions
            ['name' => 'projects-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.projects')])],
            ['name' => 'projects-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.projects')])],
            ['name' => 'projects-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.projects')])],
            ['name' => 'projects-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.projects')])],
            ['name' => 'projects-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.projects')])],
            ['name' => 'projects-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.projects')])],

            // Clients Permissions
            ['name' => 'clients-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.clients')])],
            ['name' => 'clients-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.clients')])],
            ['name' => 'clients-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.clients')])],
            ['name' => 'clients-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.clients')])],
            ['name' => 'clients-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.clients')])],
            ['name' => 'clients-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.clients')])],

            // Partners Permissions
            ['name' => 'partners-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.partners')])],
            ['name' => 'partners-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.partners')])],
            ['name' => 'partners-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.partners')])],
            ['name' => 'partners-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.partners')])],
            ['name' => 'partners-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.partners')])],
            ['name' => 'partners-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.partners')])],

            // LineWorks Permissions
            ['name' => 'line-works-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.line_works')])],
            ['name' => 'line-works-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.line_works')])],
            ['name' => 'line-works-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.line_works')])],
            ['name' => 'line-works-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.line_works')])],
            ['name' => 'line-works-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.line_works')])],
            ['name' => 'line-works-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.line_works')])],

            // Reviews Permissions
            ['name' => 'reviews-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.reviews')])],
            ['name' => 'reviews-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.reviews')])],
            ['name' => 'reviews-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.reviews')])],
            ['name' => 'reviews-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.reviews')])],
            ['name' => 'reviews-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.reviews')])],
            ['name' => 'reviews-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.reviews')])],

            // Programming Categories Permissions
            ['name' => 'programming-categories-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.programming_categories')])],
            ['name' => 'programming-categories-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.programming_categories')])],
            ['name' => 'programming-categories-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.programming_categories')])],
            ['name' => 'programming-categories-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.programming_categories')])],
            ['name' => 'programming-categories-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.programming_categories')])],
            ['name' => 'programming-categories-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.programming_categories')])],

            // Programming Systems Permissions
            ['name' => 'programming-systems-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.programming_systems')])],
            ['name' => 'programming-systems-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.programming_systems')])],
            ['name' => 'programming-systems-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.programming_systems')])],
            ['name' => 'programming-systems-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.programming_systems')])],
            ['name' => 'programming-systems-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.programming_systems')])],
            ['name' => 'programming-systems-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.programming_systems')])],

            // Project Steps Permissions
            ['name' => 'project-steps-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.project_steps')])],
            ['name' => 'project-steps-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.project_steps')])],
            ['name' => 'project-steps-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.project_steps')])],
            ['name' => 'project-steps-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.project_steps')])],
            ['name' => 'project-steps-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.project_steps')])],
            ['name' => 'project-steps-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.project_steps')])],

            // Hosting Features Permissions
            ['name' => 'hosting-features-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.hosting_features')])],
            ['name' => 'hosting-features-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.hosting_features')])],
            ['name' => 'hosting-features-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.hosting_features')])],
            ['name' => 'hosting-features-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.hosting_features')])],
            ['name' => 'hosting-features-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.hosting_features')])],
            ['name' => 'hosting-features-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.hosting_features')])],

            // Dashboards And Apps Permissions
            ['name' => 'dashboards-and-systems-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.dashboards_and_systems')])],
            ['name' => 'dashboards-and-systems-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.dashboards_and_systems')])],
            ['name' => 'dashboards-and-systems-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.dashboards_and_systems')])],
            ['name' => 'dashboards-and-systems-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.dashboards_and_systems')])],
            ['name' => 'dashboards-and-systems-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.dashboards_and_systems')])],
            ['name' => 'dashboards-and-systems-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.dashboards_and_systems')])],

            // FAQs Permissions
            ['name' => 'faqs-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.faqs')])],
            ['name' => 'faqs-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.faqs')])],
            ['name' => 'faqs-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.faqs')])],
            ['name' => 'faqs-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.faqs')])],
            ['name' => 'faqs-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.faqs')])],
            ['name' => 'faqs-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.faqs')])],

            // Tickets Permissions
            ['name' => 'tickets-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.tickets')])],
            ['name' => 'tickets-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.tickets')])],
            ['name' => 'tickets-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.tickets')])],
            ['name' => 'tickets-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.tickets')])],
            ['name' => 'tickets-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.tickets')])],
            ['name' => 'tickets-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.tickets')])],

            // Hosting Packages Permissions
            ['name' => 'hosting-packages-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.hosting_packages')])],
            ['name' => 'hosting-packages-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.hosting_packages')])],
            ['name' => 'hosting-packages-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.hosting_packages')])],
            ['name' => 'hosting-packages-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.hosting_packages')])],
            ['name' => 'hosting-packages-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.hosting_packages')])],
            ['name' => 'hosting-packages-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.hosting_packages')])],

            // Pest Domains Permissions
            ['name' => 'pest-domains-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.pest_domains')])],
            ['name' => 'pest-domains-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.pest_domains')])],
            ['name' => 'pest-domains-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.pest_domains')])],
            ['name' => 'pest-domains-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.pest_domains')])],
            ['name' => 'pest-domains-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.pest_domains')])],
            ['name' => 'pest-domains-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.pest_domains')])],

            // Official Domains Permissions
            ['name' => 'official-domains-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.official_domains')])],
            ['name' => 'official-domains-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.official_domains')])],
            ['name' => 'official-domains-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.official_domains')])],
            ['name' => 'official-domains-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.official_domains')])],
            ['name' => 'official-domains-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.official_domains')])],
            ['name' => 'official-domains-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.official_domains')])],

            // Why Us Permissions
            ['name' => 'why-us-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.why_us')])],
            ['name' => 'why-us-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.why_us')])],
            ['name' => 'why-us-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.why_us')])],
            ['name' => 'why-us-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.why_us')])],
            ['name' => 'why-us-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.why_us')])],
            ['name' => 'why-us-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.why_us')])],

            // Platform Management Permissions
            ['name' => 'platform-management-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.platform_management')])],
            ['name' => 'platform-management-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.platform_management')])],
            ['name' => 'platform-management-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.platform_management')])],
            ['name' => 'platform-management-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.platform_management')])],
            ['name' => 'platform-management-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.platform_management')])],
            ['name' => 'platform-management-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.platform_management')])],

            // Work Us Step Permissions
            ['name' => 'work-us-step-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.work_us_step')])],
            ['name' => 'work-us-step-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.work_us_step')])],
            ['name' => 'work-us-step-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.work_us_step')])],
            ['name' => 'work-us-step-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.work_us_step')])],
            ['name' => 'work-us-step-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.work_us_step')])],
            ['name' => 'work-us-step-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.work_us_step')])],

            // Marketing Packages Permissions
            ['name' => 'marketing-packages-create', 'guard_name' => 'web', 'description' => __('main.create_types', ['types' => __('main.marketing_packages')])],
            ['name' => 'marketing-packages-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.marketing_packages')])],
            ['name' => 'marketing-packages-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.marketing_packages')])],
            ['name' => 'marketing-packages-delete', 'guard_name' => 'web', 'description' => __('main.delete_types', ['types' => __('main.marketing_packages')])],
            ['name' => 'marketing-packages-restore', 'guard_name' => 'web', 'description' => __('main.restore_types', ['types' => __('main.marketing_packages')])],
            ['name' => 'marketing-packages-force-delete', 'guard_name' => 'web', 'description' => __('main.force_delete_types', ['types' => __('main.marketing_packages')])],

            // Dashboard Permissions
            ['name' => 'dashboard-access', 'guard_name' => 'web', 'description' => __('main.access_types', ['types' => __('main.dashboard')])],
            ['name' => 'dashboard-manage', 'guard_name' => 'web', 'description' => __('main.manage_types', ['types' => __('main.dashboard')])],
            ['name' => 'dashboard-switchAccount', 'guard_name' => 'web', 'description' => __('main.switch_account_types', ['types' => __('main.dashboard')])],

            // Settings Permissions
            ['name' => 'settings-read', 'guard_name' => 'web', 'description' => __('main.view_types', ['types' => __('main.settings')])],
            ['name' => 'settings-update', 'guard_name' => 'web', 'description' => __('main.edit_types', ['types' => __('main.settings')])],
            ['name' => 'settings-inlinePadding', 'guard_name' => 'web', 'description' => __('main.edit_inline_padding_types', ['types' => __('main.settings')])],
            ['name' => 'settings-website', 'guard_name' => 'web', 'description' => __('main.edit_website_types', ['types' => __('main.settings')])],
            ['name' => 'settings-backupManagement', 'guard_name' => 'web', 'description' => __('main.manage_backup_types', ['types' => __('main.settings')])],
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
        $adminRole->syncPermissions(Permission::where(function ($q) {
            $q->where('name', 'not like', '%-restore')->where('name', 'not like', '%-force-delete');
        })->get());

        // Assign content manager permissions
        $contentManagerPermissions = Permission::whereIn('name', [
            // 'content-create',
            // 'content-read',
            // 'content-update',
            'articles-create',
            'articles-read',
            'articles-update',
            'services-create',
            'services-read',
            'services-update',
            'projects-create',
            'projects-read',
            'projects-update',
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
            'programming-categories-create',
            'programming-categories-read',
            'programming-categories-update',
            'programming-systems-create',
            'programming-systems-read',
            'programming-systems-update',
            'project-steps-create',
            'project-steps-read',
            'project-steps-update',
            'faqs-read',
            'faqs-update',
            'dashboard-access',
            'dashboard-switchAccount',
            'settings-read',
            'settings-update',
            'settings-inlinePadding',
            'settings-website',
            'settings-backupManagement'
        ])->get();
        $contentManagerRole->syncPermissions($contentManagerPermissions);

        // Assign Support permissions
        $supportPermissions = Permission::whereIn('name', [
            // 'content-read',
            'dashboard-access',

            'tickets-create',
            'tickets-read',
            'tickets-update',
        ])->get();
        $supportRole->syncPermissions($supportPermissions);
    }
}
