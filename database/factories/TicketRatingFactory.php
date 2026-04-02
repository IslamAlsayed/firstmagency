<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TicketRatingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'rating'    => $this->faker->numberBetween(1, 5),
            'comment'   => $this->faker->sentence(),
            'email'     => $this->faker->safeEmail(),
            'token'     => Str::random(32),
            'rated_at'  => now(),
        ];
    }
}
