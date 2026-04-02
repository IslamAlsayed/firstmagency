<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => $this->faker->name(),
            'country'    => $this->faker->country(),
            'rate'       => $this->faker->numberBetween(3, 5),
            'comment'    => $this->faker->paragraph(),
            'photo'      => null,
            'audio'      => null,
            'status'     => 'approved',
            'created_by' => null,
            'updated_by' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }
}
