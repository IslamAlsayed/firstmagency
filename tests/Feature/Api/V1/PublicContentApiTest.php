<?php

namespace Tests\Feature\Api\V1;

use App\Models\Article;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\FAQ;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContentApiTest extends TestCase
{
    use RefreshDatabase;

    // ── Articles ─────────────────────────────────────────────────────────────

    public function test_articles_endpoint_returns_paginated_json(): void
    {
        Article::factory()->count(3)->create([
            'status'    => 'published',
            'is_active' => true,
            'translations' => ['ar' => ['title' => 'مقالة', 'description' => 'وصف'], 'en' => ['title' => 'Article', 'description' => 'Description']],
        ]);

        $this->getJson('/api/v1/articles')
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [['id', 'title', 'description']],
                'meta' => ['current_page', 'per_page', 'total', 'last_page'],
            ]);
    }

    public function test_nonexistent_article_returns_404_json(): void
    {
        $this->getJson('/api/v1/articles/999999')
            ->assertStatus(404)
            ->assertJson(['success' => false, 'message' => 'Article not found.']);
    }

    public function test_articles_language_param_ar(): void
    {
        Article::factory()->create([
            'status'    => 'published',
            'is_active' => true,
            'translations' => ['ar' => ['title' => 'مقالة عربية'], 'en' => ['title' => 'English Article']],
        ]);

        $response = $this->getJson('/api/v1/articles?lang=ar');
        $response->assertStatus(200);

        $title = $response->json('data.0.title');
        $this->assertEquals('مقالة عربية', $title);
    }

    public function test_articles_language_param_en(): void
    {
        Article::factory()->create([
            'status'    => 'published',
            'is_active' => true,
            'translations' => ['ar' => ['title' => 'مقالة عربية'], 'en' => ['title' => 'English Article']],
        ]);

        $response = $this->getJson('/api/v1/articles?lang=en');
        $response->assertStatus(200);

        $title = $response->json('data.0.title');
        $this->assertEquals('English Article', $title);
    }

    // ── Portfolio ─────────────────────────────────────────────────────────────

    public function test_portfolio_endpoint_returns_paginated_json(): void
    {
        Portfolio::factory()->count(2)->create(['is_active' => true]);

        $this->getJson('/api/v1/portfolio')
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'meta',
            ]);
    }

    // ── Reviews ──────────────────────────────────────────────────────────────

    public function test_reviews_endpoint_returns_approved_only(): void
    {
        Review::factory()->create(['status' => 'approved']);
        Review::factory()->create(['status' => 'pending']);
        Review::factory()->create(['status' => 'rejected']);

        $response = $this->getJson('/api/v1/reviews');
        $response->assertStatus(200);

        $this->assertCount(1, $response->json('data'));
    }

    public function test_review_submission_returns_201(): void
    {
        $this->postJson('/api/v1/reviews', [
            'name'    => 'Test User',
            'country' => 'SA',
            'rate'    => 5,
            'comment' => 'Great service, highly recommended!',
        ])->assertStatus(201)->assertJson(['success' => true]);

        $this->assertDatabaseHas('reviews', ['name' => 'Test User', 'status' => 'pending']);
    }

    public function test_review_submission_fails_with_invalid_rate(): void
    {
        $this->postJson('/api/v1/reviews', [
            'name'    => 'Test',
            'country' => 'SA',
            'rate'    => 10,
            'comment' => 'Test.',
        ])->assertStatus(422)->assertJsonPath('success', false);
    }

    // ── FAQs ─────────────────────────────────────────────────────────────────

    public function test_faqs_endpoint_returns_json(): void
    {
        FAQ::factory()->count(3)->create(['is_active' => true]);

        $this->getJson('/api/v1/faqs')
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data']);
    }

    public function test_faqs_filter_by_category(): void
    {
        FAQ::factory()->create(['is_active' => true, 'category' => 'hosting']);
        FAQ::factory()->create(['is_active' => true, 'category' => 'domains']);

        $response = $this->getJson('/api/v1/faqs?category=hosting');
        $response->assertStatus(200);

        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('hosting', $response->json('data.0.category'));
    }

    // ── Home ─────────────────────────────────────────────────────────────────

    public function test_home_endpoint_returns_200(): void
    {
        $this->getJson('/api/v1/home')
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data']);
    }
}
