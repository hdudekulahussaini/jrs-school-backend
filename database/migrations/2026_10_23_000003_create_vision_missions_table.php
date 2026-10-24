<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Vision & Mission section.
     */
    public function up(): void
    {
        Schema::create('vision_missions', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('vision'); // vision, mission, etc.
            $table->string('eyebrow'); // e.g. OUR VISION, OUR MISSION
            $table->string('title');
            $table->text('description');
            $table->string('image_path')->nullable(); // Uploaded image path
            $table->string('icon')->nullable()->default('eye'); // eye, rocket, target, book, etc.
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
        Schema::dropIfExists('vision_missions');
    }
};
