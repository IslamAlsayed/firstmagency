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
        if (Schema::hasTable('pest_domains')) {
            return;
        }
        Schema::create('pest_domains', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('translations')->nullable();
            $table->string('image')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('website')->nullable();
            $table->integer('order')->default(0);
            // $table->enum('status', ['draft', 'published'])->default('published');
            $table->string('status')->default('published'); // 'draft', 'published'
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pest_domains');
    }
};
