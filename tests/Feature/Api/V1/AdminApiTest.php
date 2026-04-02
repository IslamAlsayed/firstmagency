<?php

namespace Tests\Feature\Api\V1;

use App\Models\Article;
use App\Models\Review;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->admin()->create();
        Sanctum::actingAs($admin);
        return $admin;
    }

    // ── Auth Guards ───────────────────────────────────────────────────────────

    public function test_unauthenticated_gets_401_json(): void
    {
        $this->getJson('/api/v1/admin/tickets')
            ->assertStatus(401)
            ->assertJson(['success' => false, 'message' => 'Unauthenticated.']);
    }

    public function test_non_admin_user_gets_403_json(): void
    {
        Sanctum::actingAs(User::factory()->regularUser()->create());

        $this->getJson('/api/v1/admin/tickets')
            ->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    // ── Tickets ───────────────────────────────────────────────────────────────

    public function test_admin_can_list_tickets(): void
    {
        $this->actingAsAdmin();
        Ticket::factory()->count(3)->create();

        $this->getJson('/api/v1/admin/tickets')
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'meta']);
    }

    public function test_admin_can_filter_tickets_by_status(): void
    {
        $this->actingAsAdmin();
        Ticket::factory()->create(['status' => 'open']);
        Ticket::factory()->create(['status' => 'closed']);

        $response = $this->getJson('/api/v1/admin/tickets?status=open');
        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_admin_can_view_single_ticket(): void
    {
        $this->actingAsAdmin();
        $ticket = Ticket::factory()->create();

        $this->getJson("/api/v1/admin/tickets/{$ticket->id}")
            ->assertStatus(200)
            ->assertJsonPath('data.uuid', (string) $ticket->uuid);
    }

    public function test_admin_can_update_ticket_status(): void
    {
        $this->actingAsAdmin();
        $ticket = Ticket::factory()->create(['status' => 'open']);

        $this->putJson("/api/v1/admin/tickets/{$ticket->id}", ['status' => 'closed'])
            ->assertStatus(200);

        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'status' => 'closed']);
    }

    public function test_admin_can_soft_delete_ticket(): void
    {
        $this->actingAsAdmin();
        $ticket = Ticket::factory()->create();

        $this->deleteJson("/api/v1/admin/tickets/{$ticket->id}")
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertSoftDeleted('tickets', ['id' => $ticket->id]);
    }

    public function test_admin_can_restore_deleted_ticket(): void
    {
        $this->actingAsAdmin();
        $ticket = Ticket::factory()->create();
        $ticket->delete();

        $this->patchJson("/api/v1/admin/tickets/{$ticket->id}/restore")
            ->assertStatus(200);

        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'deleted_at' => null]);
    }

    public function test_admin_can_send_support_reply(): void
    {
        Mail::fake();

        $this->actingAsAdmin();
        $ticket = Ticket::factory()->create(['email' => 'customer@example.com']);

        $this->postJson("/api/v1/admin/tickets/{$ticket->id}/reply", [
            'message' => 'We have resolved your issue. Please check.',
        ])->assertStatus(201)
            ->assertJsonPath('data.sender_type', 'support');

        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id'   => $ticket->id,
            'sender_type' => 'support',
        ]);
    }

    public function test_admin_can_view_deleted_tickets(): void
    {
        $this->actingAsAdmin();
        $ticket = Ticket::factory()->create();
        $ticket->delete();

        $this->getJson('/api/v1/admin/tickets/deleted')
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'meta']);
    }

    // ── Users ─────────────────────────────────────────────────────────────────

    public function test_admin_can_list_users(): void
    {
        $this->actingAsAdmin();

        $this->getJson('/api/v1/admin/users')
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'meta']);
    }

    public function test_admin_can_create_user(): void
    {
        $this->actingAsAdmin();

        $this->postJson('/api/v1/admin/users', [
            'name'     => 'New Support Agent',
            'email'    => 'support@example.com',
            'password' => 'Password1!',
            'role'     => 'support',
        ])->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => 'support@example.com']);
    }

    public function test_admin_cannot_create_user_with_duplicate_email(): void
    {
        $this->actingAsAdmin();
        $existing = User::factory()->create(['email' => 'taken@example.com']);

        $this->postJson('/api/v1/admin/users', [
            'name'     => 'Another User',
            'email'    => 'taken@example.com',
            'password' => 'Password1!',
            'role'     => 'user',
        ])->assertStatus(422);
    }

    public function test_admin_can_delete_user(): void
    {
        $this->actingAsAdmin();
        $user = User::factory()->create();

        $this->deleteJson("/api/v1/admin/users/{$user->id}")
            ->assertStatus(200);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    // ── Articles ─────────────────────────────────────────────────────────────

    public function test_admin_can_list_all_articles(): void
    {
        $this->actingAsAdmin();
        Article::factory()->count(2)->create();

        $this->getJson('/api/v1/admin/articles')
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'meta']);
    }

    public function test_admin_can_delete_article(): void
    {
        $this->actingAsAdmin();
        $article = Article::factory()->create();

        $this->deleteJson("/api/v1/admin/articles/{$article->id}")
            ->assertStatus(200);

        $this->assertSoftDeleted('articles', ['id' => $article->id]);
    }

    // ── Reviews ──────────────────────────────────────────────────────────────

    public function test_admin_can_approve_review(): void
    {
        $this->actingAsAdmin();
        $review = Review::factory()->create(['status' => 'pending']);

        $this->putJson("/api/v1/admin/reviews/{$review->id}", ['status' => 'approved'])
            ->assertStatus(200);

        $this->assertDatabaseHas('reviews', ['id' => $review->id, 'status' => 'approved']);
    }

    public function test_admin_can_delete_review(): void
    {
        $this->actingAsAdmin();
        $review = Review::factory()->create();

        $this->deleteJson("/api/v1/admin/reviews/{$review->id}")
            ->assertStatus(200);

        $this->assertSoftDeleted('reviews', ['id' => $review->id]);
    }
}
