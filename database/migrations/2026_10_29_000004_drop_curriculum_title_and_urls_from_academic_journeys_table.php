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
        Schema::table('academic_journeys', function (Blueprint $table) {
            $columnsToDrop = [];

            if (Schema::hasColumn('academic_journeys', 'curriculum_title')) {
                $columnsToDrop[] = 'curriculum_title';
            }
            if (Schema::hasColumn('academic_journeys', 'apply_url')) {
                $columnsToDrop[] = 'apply_url';
            }
            if (Schema::hasColumn('academic_journeys', 'view_all_url')) {
                $columnsToDrop[] = 'view_all_url';
            }
            if (Schema::hasColumn('academic_journeys', 'campus_tag')) {
                $columnsToDrop[] = 'campus_tag';
            }
            if (Schema::hasColumn('academic_journeys', 'feature_tag')) {
                $columnsToDrop[] = 'feature_tag';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_journeys', function (Blueprint $table) {
            if (!Schema::hasColumn('academic_journeys', 'curriculum_title')) {
                $table->string('curriculum_title')->nullable();
            }
            if (!Schema::hasColumn('academic_journeys', 'apply_url')) {
                $table->string('apply_url')->nullable();
            }
            if (!Schema::hasColumn('academic_journeys', 'view_all_url')) {
                $table->string('view_all_url')->nullable();
            }
        });
    }
};
