<?php

namespace Tests\Feature\Api\V1;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TicketRating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_create_ticket_via_api(): void
    {
        Mail::fake();

        $this->postJson('/api/v1/tickets', [
            'name'    => 'Ahmed Ali',
            'email'   => 'ahmed@example.com',
            'subject' => 'Help with hosting',
            'message' => 'I need help setting up my hosting account.',
        ])->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['uuid', 'token', 'subject', 'status'],
            ]);

        $this->assertDatabaseHas('tickets', ['email' => 'ahmed@example.com']);
    }

    public function test_ticket_creation_fails_without_required_fields(): void
    {
        $this->postJson('/api/v1/tickets', [
            'name' => 'Ahmed',
        ])->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_no_verification_field_required_in_api(): void
    {
        Mail::fake();

        // must succeed without "verification" field (unlike web)
        $this->postJson('/api/v1/tickets', [
            'name'    => 'Test User',
            'email'   => 'test@example.com',
            'subject' => 'Test ticket',
            'message' => 'Testing the API endpoint.',
        ])->assertStatus(201);
    }

    public function test_guest_can_view_ticket_with_valid_token(): void
    {
        $ticket = Ticket::factory()->create();

        $this->getJson("/api/v1/tickets/{$ticket->uuid}?token={$ticket->token}")
            ->assertStatus(200)
            ->assertJsonPath('data.uuid', (string) $ticket->uuid);
    }

    public function test_wrong_token_returns_403(): void
    {
        $ticket = Ticket::factory()->create();

        $this->getJson("/api/v1/tickets/{$ticket->uuid}?token=invalid-token-here")
            ->assertStatus(403)
            ->assertJson(['success' => false, 'message' => 'Invalid token.']);
    }

    public function test_nonexistent_ticket_returns_404(): void
    {
        $this->getJson('/api/v1/tickets/000000000?token=anything')
            ->assertStatus(404);
    }

    public function test_customer_can_send_message(): void
    {
        $ticket = Ticket::factory()->create();

        $this->postJson("/api/v1/tickets/{$ticket->uuid}/messages", [
            'token'      => $ticket->token,
            'your_reply' => 'This is my follow-up message.',
        ])->assertStatus(201)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id'   => $ticket->id,
            'sender_type' => 'customer',
        ]);
    }

    public function test_message_requires_valid_token(): void
    {
        $ticket = Ticket::factory()->create();

        $this->postJson("/api/v1/tickets/{$ticket->uuid}/messages", [
            'token'      => 'wrong-token',
            'your_reply' => 'This is my message.',
        ])->assertStatus(403);
    }

    public function test_customer_can_update_own_message(): void
    {
        $ticket  = Ticket::factory()->create();
        $message = TicketMessage::factory()->create([
            'ticket_id'   => $ticket->id,
            'sender_type' => 'customer',
        ]);

        $this->putJson("/api/v1/tickets/messages/{$message->id}", [
            'token'      => $ticket->token,
            'your_reply' => 'Updated message content here.',
        ])->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('ticket_messages', [
            'id'      => $message->id,
            'message' => 'Updated message content here.',
        ]);
    }

    public function test_customer_can_delete_own_message(): void
    {
        $ticket  = Ticket::factory()->create();
        $message = TicketMessage::factory()->create([
            'ticket_id'   => $ticket->id,
            'sender_type' => 'customer',
        ]);

        $this->deleteJson("/api/v1/tickets/messages/{$message->id}", [
            'token' => $ticket->token,
        ])->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('ticket_messages', ['id' => $message->id]);
    }

    public function test_rating_can_be_submitted(): void
    {
        $ticket = Ticket::factory()->create();

        $this->postJson("/api/v1/tickets/rating/{$ticket->id}/{$ticket->token}", [
            'rating'  => 5,
            'comment' => 'Excellent support!',
        ])->assertStatus(201);

        $this->assertDatabaseHas('ticket_ratings', [
            'ticket_id' => $ticket->id,
            'rating'    => 5,
        ]);
    }

    public function test_duplicate_rating_returns_409(): void
    {
        $ticket = Ticket::factory()->create();
        TicketRating::factory()->create(['ticket_id' => $ticket->id]);

        $this->postJson("/api/v1/tickets/rating/{$ticket->id}/{$ticket->token}", [
            'rating' => 3,
        ])->assertStatus(409)->assertJsonPath('success', false);
    }

    public function test_rating_page_returns_ticket_info(): void
    {
        $ticket = Ticket::factory()->create();

        $this->getJson("/api/v1/tickets/rating/{$ticket->id}/{$ticket->token}")
            ->assertStatus(200)
            ->assertJsonPath('data.ticket.id', $ticket->id);
    }

    public function test_already_rated_returns_409_on_show(): void
    {
        $ticket = Ticket::factory()->create();
        TicketRating::factory()->create(['ticket_id' => $ticket->id]);

        $this->getJson("/api/v1/tickets/rating/{$ticket->id}/{$ticket->token}")
            ->assertStatus(409);
    }
}
