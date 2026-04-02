<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->name(),
            'email'       => $this->faker->safeEmail(),
            'phone'       => $this->faker->phoneNumber(),
            'subject'     => $this->faker->sentence(5),
            'department_id' => null,
            'status'      => 'open',
            'priority'    => $this->faker->randomElement(['low', 'medium', 'high']),
            'is_active'   => true,
            // uuid and token are auto-generated in Ticket::boot()
        ];
    }
}
