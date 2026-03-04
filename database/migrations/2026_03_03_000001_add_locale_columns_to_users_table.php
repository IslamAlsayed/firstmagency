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
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'website_locale')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('website_locale')->default('ar')->after('updated_by');
                $table->string('dashboard_locale')->default('ar')->after('website_locale');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['website_locale', 'dashboard_locale']);
            });
        }
    }
};
