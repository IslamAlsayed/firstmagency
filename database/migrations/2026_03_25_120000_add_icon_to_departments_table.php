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
        if (!Schema::hasTable('departments')) {
            return;
        }

        Schema::table('departments', function (Blueprint $table) {
            if (!Schema::hasColumn('departments', 'icon')) {
                $table->string('icon')->default('fas fa-building')->after('name_ar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('departments') || !Schema::hasColumn('departments', 'icon')) {
            return;
        }

        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
