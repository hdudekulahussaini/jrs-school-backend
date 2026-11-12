<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Remove is_active from career_sections — table enforces max 1 record at application level.
     */
    public function up(): void
    {
        Schema::table('career_sections', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('career_sections', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('apply_phone');
        });
    }
};
