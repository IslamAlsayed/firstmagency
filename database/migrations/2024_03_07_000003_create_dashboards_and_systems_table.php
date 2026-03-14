<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dashboards_and_systems', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            // $table->enum('type', ['operating-system', 'dashboard-app'])->default('operating-system'); // Type to differentiate
            $table->string('type')->default('operating-system'); // 'operating-system', 'dashboard-app'
            $table->json('translations'); // {'ar': {'title': '...'}, 'en': {'title': '...'}}
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboards_and_systems');
    }
};
