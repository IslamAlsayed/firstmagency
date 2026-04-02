<?php

namespace Tests\Feature\Dashboard;

use App\Mail\TicketCopyMail;
use App\Mail\TicketRepliedMail;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TicketDashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'tickets-restore', 'guard_name' => 'web']);
        $role->givePermissionTo('tickets-restore');

        $this->admin = User::factory()->superAdmin()->create();
        $this->admin->assignRole($role);
    }

    private function ticketPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Customer Name',
            'email' => 'customer@example.com',
            'phone' => '0500000000',
            'subject' => 'Issue with service',
            'message' => 'Full detailed description of the issue.',
            'verification' => 10,
            'priority' => 'high',
            'status' => 'open',
        ], $overrides);
    }

    public function test_admin_can_list_tickets(): void
    {
        $this->actingAs($this->admin)
            ->get('/dashboard/tickets')
            ->assertStatus(200);
    }

    public function test_admin_can_view_ticket_create_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/dashboard/tickets/create')
            ->assertStatus(200);
    }

    public function test_admin_can_store_ticket(): void
    {
        Mail::fake();

        $this->actingAs($this->admin)
            ->withSession(['ticket_verification' => 10])
            ->post('/dashboard/tickets', $this->ticketPayload())
            ->assertRedirect(route('dashboard.tickets.index'));

        $this->assertDatabaseHas('tickets', ['email' => 'customer@example.com']);
    }

    public function test_store_ticket_fails_without_subject(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['ticket_verification' => 10])
            ->post('/dashboard/tickets', $this->ticketPayload(['subject' => '']))
            ->assertSessionHasErrors('subject');
    }

    public function test_admin_can_view_ticket(): void
    {
        $ticket = Ticket::factory()->create();

        $this->actingAs($this->admin)
            ->get("/dashboard/tickets/{$ticket->id}")
            ->assertStatus(200);
    }

    public function test_admin_can_view_ticket_edit_form(): void
    {
        $ticket = Ticket::factory()->create();

        $this->actingAs($this->admin)
            ->get("/dashboard/tickets/{$ticket->id}/edit")
            ->assertStatus(200);
    }

    public function test_admin_can_update_ticket_status(): void
    {
        $ticket = Ticket::factory()->create(['status' => 'open']);

        $this->actingAs($this->admin)
            ->put("/dashboard/tickets/{$ticket->id}", [
                'status' => 'closed',
            ])->assertRedirect(route('dashboard.tickets.index'));

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'status' => 'closed',
        ]);
    }

    public function test_admin_can_update_ticket_priority(): void
    {
        $ticket = Ticket::factory()->create(['priority' => 'low']);

        $this->actingAs($this->admin)
            ->put("/dashboard/tickets/{$ticket->id}", [
                'priority' => 'high',
            ])->assertRedirect(route('dashboard.tickets.index'));

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'priority' => 'high',
        ]);
    }

    public function test_admin_can_delete_ticket(): void
    {
        $ticket = Ticket::factory()->create();

        $this->actingAs($this->admin)
            ->delete("/dashboard/tickets/{$ticket->id}")
            ->assertRedirect();

        $this->assertSoftDeleted('tickets', ['id' => $ticket->id]);
    }

    public function test_admin_can_view_support_reply_page(): void
    {
        $ticket = Ticket::factory()->create();

        $this->actingAs($this->admin)
            ->get("/dashboard/tickets/{$ticket->id}/support-reply")
            ->assertStatus(200);
    }

    public function test_admin_can_post_support_reply(): void
    {
        Mail::fake();
        $ticket = Ticket::factory()->create(['email' => 'customer@example.com']);

        $this->actingAs($this->admin)
            ->post("/dashboard/tickets/{$ticket->id}/support-reply", [
                'your_reply' => 'We have resolved your issue. Please let us know.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id' => $ticket->id,
            'sender_type' => 'support',
        ]);

        Mail::assertSent(TicketRepliedMail::class);
    }

    public function test_support_reply_fails_without_message(): void
    {
        $ticket = Ticket::factory()->create();

        $this->actingAs($this->admin)
            ->post("/dashboard/tickets/{$ticket->id}/support-reply", [
                'your_reply' => '',
            ])
            ->assertSessionHasErrors('your_reply');
    }

    public function test_send_copy_sends_mail(): void
    {
        Mail::fake();
        $ticket = Ticket::factory()->create(['email' => 'customer@example.com']);

        $this->actingAs($this->admin)
            ->get("/dashboard/tickets/{$ticket->id}/send-copy")
            ->assertRedirect();

        Mail::assertSent(TicketCopyMail::class);
    }

    public function test_admin_can_view_deleted_tickets(): void
    {
        $ticket = Ticket::factory()->create();
        $ticket->delete();

        $this->actingAs($this->admin)
            ->get('/dashboard/tickets/deleted/list')
            ->assertStatus(200);
    }

    public function test_admin_can_restore_deleted_ticket(): void
    {
        $ticket = Ticket::factory()->create();
        $ticket->delete();

        $this->actingAs($this->admin)
            ->patch("/dashboard/tickets/{$ticket->id}/restore")
            ->assertRedirect(route('dashboard.tickets.deleted'));

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'deleted_at' => null,
        ]);
    }

    public function test_department_can_be_changed_on_ticket(): void
    {
        $ticket = Ticket::factory()->create(['department_id' => null]);
        $department = Department::factory()->create();

        $this->actingAs($this->admin)
            ->patch("/dashboard/departments/{$department->id}/tickets/{$ticket->id}")
            ->assertRedirect();

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'department_id' => $department->id,
        ]);
    }
}
