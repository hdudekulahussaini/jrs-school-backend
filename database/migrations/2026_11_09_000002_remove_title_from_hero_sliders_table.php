<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('hero_sliders') && Schema::hasColumn('hero_sliders', 'title')) {
            Schema::table('hero_sliders', function (Blueprint $table): void {
                $table->dropColumn('title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('hero_sliders') && !Schema::hasColumn('hero_sliders', 'title')) {
            Schema::table('hero_sliders', function (Blueprint $table): void {
                $table->string('title')->nullable();
            });
        }
    }
};
