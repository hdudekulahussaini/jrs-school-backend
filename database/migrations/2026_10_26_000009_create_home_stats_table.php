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
        Schema::create('home_stats', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Metric label e.g. Year of Establishment, Happy Students, Experienced Faculty');
            $table->string('value')->comment('Metric value e.g. 2021, 1000+, 50+, 100+');
            $table->string('icon')->default('graduation-cap')->comment('Lucide/SVG icon name e.g. graduation-cap, users, award, trophy');
            $table->string('color')->nullable()->default('#eab308')->comment('Icon accent color hex code');
            $table->text('description')->nullable()->comment('Optional short caption');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_stats');
    }
};
