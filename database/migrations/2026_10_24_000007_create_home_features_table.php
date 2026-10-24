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
        Schema::create('home_features', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Feature title e.g. CBSE Curriculum, Holistic Development');
            $table->text('description')->nullable()->comment('Short subtitle/description under the title');
            $table->string('icon')->nullable()->default('graduation-cap')->comment('Lucide icon name e.g. graduation-cap, sparkles, award, shield-check, building');
            $table->string('color')->nullable()->default('#e31e24')->comment('Icon background badge color hex code e.g. #e31e24, #059669');
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
        Schema::dropIfExists('home_features');
    }
};
