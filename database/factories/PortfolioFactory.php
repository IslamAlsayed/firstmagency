<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PortfolioFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'slug'        => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'title'       => $title,
            'description' => $this->faker->paragraph(),
            'image'       => null,
            'order'       => $this->faker->numberBetween(1, 100),
            'is_active'   => true,
            'created_by'  => null,
            'updated_by'  => null,
            'tags'        => ['web', 'design'],
        ];
    }
}
