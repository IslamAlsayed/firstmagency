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
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // SEO & Metadata
            $table->string('slug')->unique();
            $table->json('translations'); // All content in JSON (ar/en)

            // Media
            $table->string('icon')->nullable();
            $table->string('image')->nullable();

            // Ordering
            $table->unsignedInteger('order')->default(0);

            // Flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps
            $table->datetime('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};