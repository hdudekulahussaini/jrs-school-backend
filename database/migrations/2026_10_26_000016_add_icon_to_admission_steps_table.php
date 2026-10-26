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
        Schema::table('admission_steps', function (Blueprint $table) {
            if (!Schema::hasColumn('admission_steps', 'icon')) {
                $table->text('icon')->nullable()->after('description');
            }

            $columnsToDrop = [];
            foreach (['badge_number', 'image_path', 'accent_color', 'sort_order', 'is_active'] as $col) {
                if (Schema::hasColumn('admission_steps', $col)) {
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
        Schema::table('admission_steps', function (Blueprint $table) {
            if (!Schema::hasColumn('admission_steps', 'badge_number')) {
                $table->string('badge_number')->default('01');
            }
            if (!Schema::hasColumn('admission_steps', 'image_path')) {
                $table->string('image_path')->nullable();
            }
            if (!Schema::hasColumn('admission_steps', 'accent_color')) {
                $table->string('accent_color')->default('navy');
            }
            if (!Schema::hasColumn('admission_steps', 'sort_order')) {
                $table->integer('sort_order')->default(1);
            }
            if (!Schema::hasColumn('admission_steps', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }
};
