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
        Schema::create('beyond_classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Activity title e.g. Sports, Music, Dance, Karate, Science & Activities, Skating');
            $table->string('category')->nullable()->comment('Category/Tag e.g. Fitness & Teamwork, Vocal & Instruments');
            $table->text('description')->nullable()->comment('Paragraph description of activity');
            $table->string('icon')->nullable()->default('trophy')->comment('Icon identifier e.g. trophy, music, dance, shield, flask, skating');
            $table->string('color')->nullable()->default('#15803d')->comment('Badge/Theme color hex code e.g. #15803d, #0284c7');
            $table->string('image_path')->nullable()->comment('Uploaded image path or public image asset URL');
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
        Schema::dropIfExists('beyond_classrooms');
    }
};
