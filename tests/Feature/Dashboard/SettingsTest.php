<?php

namespace Tests\Feature\Dashboard;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $this->admin = User::factory()->admin()->create();
        $this->admin->assignRole($role);

        Setting::first();
    }

    public function test_admin_can_view_settings_index(): void
    {
        $this->actingAs($this->admin)
            ->get('/dashboard/settings')
            ->assertStatus(200);
    }

    public function test_admin_can_view_website_settings(): void
    {
        $this->actingAs($this->admin)
            ->get('/dashboard/settings/website')
            ->assertStatus(200);
    }

    public function test_admin_can_update_general_settings(): void
    {
        $this->actingAs($this->admin)
            ->put('/dashboard/updateGeneral', [
                'site_name' => 'Updated Agency',
                'site_email' => 'info@agency.com',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('settings', [
            'site_name' => 'Updated Agency',
            'site_email' => 'info@agency.com',
        ]);
    }

    public function test_admin_can_update_dashboard_colors(): void
    {
        $this->actingAs($this->admin)
            ->put('/dashboard/updateColors', [
                'colors' => ['primary' => '#112233'],
            ])
            ->assertRedirect();

        $this->assertEquals('#112233', Setting::first()->colors['primary'] ?? null);
    }

    public function test_admin_can_toggle_debug_mode(): void
    {
        $initial = (bool) Setting::first()->debug_mode;

        $this->actingAs($this->admin)
            ->post('/dashboard/toggleDebugMode')
            ->assertRedirect();

        $this->assertNotSame($initial, (bool) Setting::first()->debug_mode);
    }

    public function test_admin_can_view_inline_padding_settings(): void
    {
        $this->actingAs($this->admin)
            ->get('/dashboard/settings/inline-padding')
            ->assertStatus(200);
    }

    public function test_admin_can_update_inline_padding(): void
    {
        $this->actingAs($this->admin)
            ->put('/dashboard/settings/inline-padding', [
                'sections_padding' => ['home_hero_section' => 150],
            ])
            ->assertRedirect();

        $this->assertEquals(150, Setting::first()->sections_padding['home_hero_section'] ?? null);
    }

    public function test_admin_can_reset_inline_padding(): void
    {
        Setting::first()->update(['sections_padding' => ['home_hero_section' => 999]]);

        $this->actingAs($this->admin)
            ->post('/dashboard/settings/inline-padding/reset')
            ->assertRedirect();

        $this->assertEquals(config('inline_padding.defaults', []), Setting::first()->sections_padding ?? []);
    }

    public function test_admin_can_add_own_ip_to_debug(): void
    {
        $this->actingAs($this->admin)
            ->post('/dashboard/addMyIpToDebug', [], ['REMOTE_ADDR' => '127.0.0.1'])
            ->assertRedirect();

        $ips = json_decode(Setting::first()->debug_ips ?? '[]', true) ?: [];
        $this->assertContains('127.0.0.1', $ips);
    }
}
