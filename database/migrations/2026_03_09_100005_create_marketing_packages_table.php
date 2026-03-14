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
        if (Schema::hasTable('marketing_packages')) {
            return;
        }
        Schema::create('marketing_packages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('translations')->nullable();
            $table->json('features')->nullable();
            $table->string('image')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->string('status')->default('published'); // 'published', 'draft'
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_packages');
    }
};
