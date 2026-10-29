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
        Schema::table('facilities', function (Blueprint $table) {
            if (!Schema::hasColumn('facilities', 'overview_description')) {
                $table->text('overview_description')->nullable()->after('description');
            }
            if (!Schema::hasColumn('facilities', 'highlights')) {
                $table->json('highlights')->nullable()->after('overview_description');
            }
            if (!Schema::hasColumn('facilities', 'gallery_images')) {
                $table->json('gallery_images')->nullable()->after('highlights');
            }

            // Drop removed fields if present
            $columnsToDrop = [];
            foreach (['destination_url', 'overview_title', 'gallery_url'] as $col) {
                if (Schema::hasColumn('facilities', $col)) {
                    $columnsToDrop[] = $col;
                }
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
        Schema::table('facilities', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach (['overview_description', 'highlights', 'gallery_images'] as $col) {
                if (Schema::hasColumn('facilities', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
