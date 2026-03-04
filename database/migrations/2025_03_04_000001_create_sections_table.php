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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم القسم الواحد والواقع
            $table->string('flag')->unique(); // flag فريد للتعرف على القسم من الـ padding settings
            $table->string('padding_setting_key')->nullable(); // مفتاح الـ padding في جدول settings
            $table->string('view_file')->nullable(); // الملف المرتبط بالقسم في resources/views/sections
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
