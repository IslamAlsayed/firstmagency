<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $this->user = User::factory()->admin()->create();
        $this->user->assignRole($role);
    }

    public function test_user_can_view_own_profile(): void
    {
        $this->actingAs($this->user)
            ->get('/dashboard/profile')
            ->assertStatus(200);
    }

    public function test_user_can_view_edit_form(): void
    {
        $this->actingAs($this->user)
            ->get('/dashboard/profile/edit')
            ->assertStatus(200);
    }

    public function test_user_can_update_profile(): void
    {
        $this->actingAs($this->user)
            ->put('/dashboard/profile', [
                'name' => 'Updated Name',
                'email' => $this->user->email,
                'website_locale' => 'ar',
                'dashboard_locale' => 'en',
            ])
            ->assertRedirect(route('dashboard.profile.show'));

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Updated Name',
            'website_locale' => 'ar',
            'dashboard_locale' => 'en',
        ]);
    }

    public function test_profile_update_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'used@example.com']);

        $this->actingAs($this->user)
            ->put('/dashboard/profile', [
                'name' => 'Test',
                'email' => 'used@example.com',
            ])
            ->assertSessionHasErrors('email');
    }

    public function test_profile_update_fails_with_invalid_locale(): void
    {
        $this->actingAs($this->user)
            ->put('/dashboard/profile', [
                'name' => 'Test',
                'email' => $this->user->email,
                'website_locale' => 'xx',
            ])
            ->assertSessionHasErrors('website_locale');
    }

    public function test_user_can_upload_profile_photo(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg', 200, 200);

        $this->actingAs($this->user)
            ->post('/dashboard/profile/photo', ['photo' => $file])
            ->assertRedirect();

        $this->assertNotNull($this->user->fresh()->photo);
    }

    public function test_photo_upload_fails_with_non_image(): void
    {
        $file = UploadedFile::fake()->create('doc.pdf', 50, 'application/pdf');

        $this->actingAs($this->user)
            ->post('/dashboard/profile/photo', ['photo' => $file])
            ->assertSessionHasErrors('photo');
    }

    public function test_photo_upload_fails_if_too_large(): void
    {
        $file = UploadedFile::fake()->image('big.jpg')->size(6000);

        $this->actingAs($this->user)
            ->post('/dashboard/profile/photo', ['photo' => $file])
            ->assertSessionHasErrors('photo');
    }

    public function test_user_can_delete_profile_photo(): void
    {
        $this->user->update(['photo' => 'uploads/users/' . $this->user->id . '/old.jpg']);

        $this->actingAs($this->user)
            ->delete('/dashboard/profile/photo')
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'photo' => null,
        ]);
    }

    public function test_user_can_view_activity_log(): void
    {
        $this->actingAs($this->user)
            ->get('/dashboard/profile/activity')
            ->assertStatus(200);
    }

    public function test_user_can_change_password(): void
    {
        $this->actingAs($this->user)
            ->post('/dashboard/profile/change-password', [
                'current_password' => 'password',
                'password' => 'NewPassword1!',
                'password_confirmation' => 'NewPassword1!',
            ])
            ->assertRedirect();

        $this->assertTrue(Hash::check('NewPassword1!', $this->user->fresh()->password));
    }

    public function test_change_password_fails_with_wrong_current_password(): void
    {
        $this->actingAs($this->user)
            ->post('/dashboard/profile/change-password', [
                'current_password' => 'wrong-password',
                'password' => 'NewPassword1!',
                'password_confirmation' => 'NewPassword1!',
            ])
            ->assertSessionHasErrors('current_password');
    }

    public function test_change_password_fails_with_mismatch_confirmation(): void
    {
        $this->actingAs($this->user)
            ->post('/dashboard/profile/change-password', [
                'current_password' => 'password',
                'password' => 'NewPassword1!',
                'password_confirmation' => 'Mismatch123!',
            ])
            ->assertSessionHasErrors('password');
    }
}
