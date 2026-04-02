<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_dashboard(): void
    {
        $user = User::factory()->regularUser()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertStatus(302);
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertStatus(200);
    }

    public function test_superadmin_can_access_dashboard(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $this->actingAs($superAdmin)
            ->get('/dashboard')
            ->assertStatus(200);
    }

    public function test_guest_is_redirected_from_settings(): void
    {
        $this->get('/dashboard/settings')->assertRedirect('/login');
    }

    public function test_admin_can_access_settings(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/dashboard/settings')
            ->assertStatus(200);
    }

    public function test_regular_user_cannot_access_settings(): void
    {
        $user = User::factory()->regularUser()->create();

        $this->actingAs($user)
            ->get('/dashboard/settings')
            ->assertStatus(302);
    }

    public function test_locale_change_sets_website_locale_session(): void
    {
        $this->from('/')
            ->get('/locale/en')
            ->assertStatus(302)
            ->assertSessionHas('website_locale', 'en');
    }

    public function test_authenticated_dashboard_locale_change_sets_dashboard_locale_session(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from('/dashboard')
            ->get('/dashboard/locale/ar')
            ->assertStatus(302)
            ->assertSessionHas('dashboard_locale', 'ar');
    }
}
