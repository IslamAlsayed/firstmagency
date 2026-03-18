<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            // SEO & Metadata
            $table->string('slug')->unique();
            $table->json('translations'); // All content in JSON (ar/en)

            // Media
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();

            // Relations
            $table->unsignedBigInteger('category_id')->nullable();

            // Engagement & Analytics
            $table->unsignedInteger('visitors')->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);

            // Status & Control
            // $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('status')->default('draft');
            $table->boolean('is_active')->default(true);

            // Related Articles (JSON or text)
            $table->json('related_articles')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps
            $table->datetime('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('category_id');
            $table->index('status');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
