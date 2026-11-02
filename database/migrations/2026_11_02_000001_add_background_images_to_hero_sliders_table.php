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
            if (!Schema::hasColumn('hero_sliders', 'background_images')) {
                $table->json('background_images')->nullable()->after('image_path')->comment('JSON array of background photo paths/URLs for the slider');
            }
            if (!Schema::hasColumn('hero_sliders', 'experience_badge_image')) {
                $table->string('experience_badge_image')->nullable()->after('background_images')->comment('Path or URL for the Experience Badge (e.g. 38 Years Experience)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('hero_sliders', 'background_images')) {
                $columnsToDrop[] = 'background_images';
            }
            if (Schema::hasColumn('hero_sliders', 'experience_badge_image')) {
                $columnsToDrop[] = 'experience_badge_image';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
