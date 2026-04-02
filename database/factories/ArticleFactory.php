<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        return [
            'slug'        => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'thumbnail'   => null,
            'category_id' => null,
            'visitors'    => 0,
            'view_count'  => 0,
            'likes_count' => 0,
            'comments_count' => 0,
            'status'      => 'published',
            'is_active'   => true,
            'related_articles' => null,
            'created_by'  => null,
            'updated_by'  => null,
            'published_at' => now(),
            'translations' => [
                'en' => ['title' => $title, 'content' => $this->faker->paragraphs(2, true)],
                'ar' => ['title' => $title, 'content' => $this->faker->paragraphs(2, true)],
            ],
        ];
    }
}
