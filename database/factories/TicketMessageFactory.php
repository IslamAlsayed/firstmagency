<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketMessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id'   => Ticket::factory(),
            'user_id'     => null,
            'message'     => $this->faker->paragraph(),
            'sender_type' => 'customer',
            'attachments' => null,
        ];
    }
}
