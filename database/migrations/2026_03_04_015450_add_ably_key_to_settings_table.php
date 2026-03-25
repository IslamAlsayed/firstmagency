<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'ably_key')) {
                $table->string('ably_key')->default('YfoutQ.0ANKLQ:l9mrZvEjJGo07yZsKnU8XU33MkgnlX9k7JfmsQUKJe4')->nullable()->after('website_design_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'ably_key')) {
                $table->dropColumn('ably_key');
            }
        });
    }
};
