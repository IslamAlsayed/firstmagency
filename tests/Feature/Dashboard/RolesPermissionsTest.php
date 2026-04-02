<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolesPermissionsTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $role = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);

        $this->superAdmin = User::factory()->superAdmin()->create();
        $this->superAdmin->assignRole($role);
    }

    public function test_admin_can_list_roles(): void
    {
        $this->actingAs($this->superAdmin)
            ->get('/dashboard/roles')
            ->assertStatus(200);
    }

    public function test_admin_can_create_role(): void
    {
        $name = 'content-editor-' . now()->timestamp;

        $this->actingAs($this->superAdmin)
            ->post('/dashboard/roles', [
                'name' => $name,
            ])
            ->assertRedirect(route('dashboard.roles.index'));

        $this->assertDatabaseHas('roles', ['name' => $name]);
    }

    public function test_admin_can_update_role(): void
    {
        $role = Role::create(['name' => 'role-to-update', 'guard_name' => 'web']);

        $this->actingAs($this->superAdmin)
            ->put("/dashboard/roles/{$role->id}", [
                'name' => 'role-updated',
            ])
            ->assertRedirect(route('dashboard.roles.index'));

        $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => 'role-updated']);
    }

    public function test_admin_can_delete_role(): void
    {
        $role = Role::create(['name' => 'role-to-delete', 'guard_name' => 'web']);

        $this->actingAs($this->superAdmin)
            ->delete("/dashboard/roles/{$role->id}")
            ->assertRedirect(route('dashboard.roles.index'));

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    public function test_admin_can_list_permissions(): void
    {
        $this->actingAs($this->superAdmin)
            ->get('/dashboard/permissions')
            ->assertStatus(200);
    }

    public function test_admin_can_create_permission(): void
    {
        $name = 'articles-delete-' . now()->timestamp;

        $this->actingAs($this->superAdmin)
            ->post('/dashboard/permissions', [
                'name' => $name,
                'description' => 'Test permission',
            ])
            ->assertRedirect(route('dashboard.permissions.index'));

        $this->assertDatabaseHas('permissions', ['name' => $name]);
    }

    public function test_admin_can_delete_permission(): void
    {
        $permission = Permission::create(['name' => 'perm-to-delete', 'guard_name' => 'web']);

        $this->actingAs($this->superAdmin)
            ->delete("/dashboard/permissions/{$permission->id}")
            ->assertRedirect(route('dashboard.permissions.index'));

        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }
}
