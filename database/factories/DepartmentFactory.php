<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'name' => 'support-' . $this->faker->unique()->numberBetween(1, 9999),
            'name_ar' => $this->faker->word(),
            'icon' => 'fas fa-headset',
            'bg_color' => '#ffffff',
            'border_color' => '#dddddd',
            'border_main_color' => '#333333',
            'badge_color' => '#f5f5f5',
            'user_id' => User::factory(),
        ];
    }
}
