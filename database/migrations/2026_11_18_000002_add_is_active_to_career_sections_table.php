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
        if (Schema::hasTable('career_sections')) {
            Schema::table('career_sections', function (Blueprint $table) {
                if (!Schema::hasColumn('career_sections', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('apply_phone');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('career_sections')) {
            Schema::table('career_sections', function (Blueprint $table) {
                if (Schema::hasColumn('career_sections', 'is_active')) {
                    $table->dropColumn('is_active');
                }
            });
        }
    }
};

