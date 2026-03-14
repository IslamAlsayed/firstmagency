<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hosting_packages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category')->index(); // hosting, reseller, vps, servers
            $table->json('translations'); // ar and en translations {title, description}
            $table->decimal('monthly_price', 8, 2)->default(0);
            $table->decimal('yearly_price', 8, 2)->default(0);
            $table->json('features')->nullable(); // Array of features with title and label
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('hosting_packages');
    }
};
