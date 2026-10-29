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
            if (Schema::hasColumn('academic_journeys', 'slug')) {
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('academic_journeys', 'link_url')) {
                $table->dropColumn('link_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_journeys', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('age_group');
            $table->string('link_url')->nullable()->after('image_path');
        });
    }
};
