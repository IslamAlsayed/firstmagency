<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserManagementTest extends TestCase
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

    public function test_superadmin_can_list_users(): void
    {
        $this->actingAs($this->superAdmin)
            ->get('/dashboard/users')
            ->assertStatus(200);
    }

    public function test_superadmin_can_view_create_user_form(): void
    {
        $this->actingAs($this->superAdmin)
            ->get('/dashboard/users/create')
            ->assertStatus(200);
    }

    public function test_superadmin_can_create_user(): void
    {
        $this->actingAs($this->superAdmin)
            ->post('/dashboard/users', [
                'name' => 'New User',
                'email' => 'newuser@example.com',
                'password' => 'Password1!',
                'password_confirmation' => 'Password1!',
                'role' => 'user',
            ])->assertRedirect(route('dashboard.users.index'));

        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    public function test_create_user_fails_without_name(): void
    {
        $this->actingAs($this->superAdmin)
            ->post('/dashboard/users', [
                'name' => '',
                'email' => 'noname@example.com',
                'password' => 'Password1!',
                'password_confirmation' => 'Password1!',
                'role' => 'user',
            ])->assertSessionHasErrors('name');
    }

    public function test_create_user_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->actingAs($this->superAdmin)
            ->post('/dashboard/users', [
                'name' => 'Another User',
                'email' => 'taken@example.com',
                'password' => 'Password1!',
                'password_confirmation' => 'Password1!',
                'role' => 'user',
            ])->assertSessionHasErrors('email');
    }

    public function test_create_user_fails_with_weak_password(): void
    {
        $this->actingAs($this->superAdmin)
            ->post('/dashboard/users', [
                'name' => 'Weak Password User',
                'email' => 'weak@example.com',
                'password' => '12345',
                'password_confirmation' => '12345',
                'role' => 'user',
            ])->assertSessionHasErrors('password');
    }

    public function test_superadmin_can_view_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->superAdmin)
            ->get("/dashboard/users/{$user->id}")
            ->assertStatus(200);
    }

    public function test_superadmin_can_edit_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->superAdmin)
            ->get("/dashboard/users/{$user->id}/edit")
            ->assertStatus(200);
    }

    public function test_superadmin_can_update_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->superAdmin)
            ->put("/dashboard/users/{$user->id}", [
                'name' => 'Updated Name',
                'email' => $user->email,
                'role' => 'admin',
            ])->assertRedirect(route('dashboard.users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'role' => 'admin',
        ]);
    }

    public function test_superadmin_can_delete_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->superAdmin)
            ->delete("/dashboard/users/{$user->id}")
            ->assertRedirect(route('dashboard.users.index'));

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_superadmin_can_view_user_permissions_form(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->superAdmin)
            ->get("/dashboard/users/{$user->id}/permissions")
            ->assertStatus(200);
    }

    public function test_superadmin_can_update_user_permissions(): void
    {
        $user = User::factory()->create();
        $permission = Permission::firstOrCreate(['name' => 'users-read', 'guard_name' => 'web']);

        $this->actingAs($this->superAdmin)
            ->put("/dashboard/users/{$user->id}/permissions", [
                'permissions' => [$permission->name],
            ])
            ->assertRedirect(route('dashboard.users.editPermissions', $user->id));

        $user->refresh();
        $this->assertTrue($user->hasPermissionTo('users-read'));
    }

    public function test_user_can_view_own_permissions(): void
    {
        $this->actingAs($this->superAdmin)
            ->get('/dashboard/my-permissions')
            ->assertStatus(200);
    }

    public function test_account_switch_works_for_superadmin(): void
    {
        $target = User::factory()->create();

        $this->actingAs($this->superAdmin)
            ->post('/dashboard/account/switch', [
                'user_id' => $target->id,
            ])
            ->assertRedirect();

        $this->assertAuthenticatedAs($target);
    }
}
