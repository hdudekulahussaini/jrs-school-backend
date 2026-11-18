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
        Schema::table('hero_sliders', function (Blueprint $table) {
            if (Schema::hasColumn('hero_sliders', 'experience_badge_image')) {
                $table->dropColumn('experience_badge_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('hero_sliders', 'experience_badge_image')) {
                $table->string('experience_badge_image')->nullable()->after('background_images');
            }
        });
    }
};

