<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_receive_token(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => ['token', 'user' => ['id', 'name', 'email', 'role']],
            ]);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $this->postJson('/api/v1/auth/login', [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ])->assertStatus(401)->assertJson(['success' => false]);
    }

    public function test_login_returns_422_with_missing_email(): void
    {
        $this->postJson('/api/v1/auth/login', [
            'password' => 'password',
        ])->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'The given data was invalid.');
    }

    public function test_unauthenticated_me_returns_401_json(): void
    {
        $this->getJson('/api/v1/auth/me')
            ->assertStatus(401)
            ->assertJson(['success' => false, 'message' => 'Unauthenticated.']);
    }

    public function test_authenticated_user_can_get_profile(): void
    {
        $user = User::factory()->admin()->create();

        Sanctum::actingAs($user);

        $this->getJson('/api/v1/auth/me')
            ->assertStatus(200)
            ->assertJsonPath('data.email', $user->email);
    }

    public function test_user_can_logout(): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $this->postJson('/api/v1/auth/logout', [], ['Authorization' => "Bearer {$token}"])
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        // Token should be removed from the database
        [$id, $secret] = explode('|', $token, 2);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'id'    => $id,
            'token' => hash('sha256', $secret),
        ]);
    }

    public function test_logout_returns_401_without_token(): void
    {
        $this->postJson('/api/v1/auth/logout')
            ->assertStatus(401);
    }

    public function test_refresh_issues_new_token(): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->postJson(
            '/api/v1/auth/refresh',
            [],
            ['Authorization' => "Bearer {$token}"]
        );

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['token']]);

        // Old token should be removed from the database
        [$id, $secret] = explode('|', $token, 2);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'id'    => $id,
            'token' => hash('sha256', $secret),
        ]);
    }
}
