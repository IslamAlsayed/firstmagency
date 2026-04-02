<?php

namespace Database\Factories;

use App\Models\FAQ;
use Illuminate\Database\Eloquent\Factories\Factory;

class FAQFactory extends Factory
{
    protected $model = FAQ::class;

    public function definition(): array
    {
        $categories = array_keys(FAQ::CATEGORIES);

        return [
            'question'    => $this->faker->sentence(6) . '?',
            'question_ar' => $this->faker->sentence(6) . '؟',
            'answer'      => $this->faker->paragraph(),
            'answer_ar'   => $this->faker->paragraph(),
            'category'    => $this->faker->randomElement($categories),
            'order'       => $this->faker->numberBetween(1, 100),
            'is_active'   => true,
            'created_by'  => null,
            'updated_by'  => null,
        ];
    }
}
