<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if column doesn't exist before adding it
        if (Schema::hasTable('tickets') && !Schema::hasColumn('tickets', 'department_id')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->after('subject', function ($table) {
                    $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
                });
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tickets') && Schema::hasColumn('tickets', 'department_id')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropForeignIdFor('department_id');
                $table->dropColumn('department_id');
            });
        }
    }
};
