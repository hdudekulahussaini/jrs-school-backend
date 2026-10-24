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
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('tagline')->default('ABOUT JRS');
            $table->string('title')->default('A Legacy Of Excellence');
            $table->string('title_highlight')->default('In Education');
            $table->text('description_p1');
            $table->text('description_p2')->nullable();
            $table->string('button_text')->default('Read more');
            $table->string('button_link')->default('/about');
            $table->string('image_1_url')->nullable();
            $table->string('image_2_url')->nullable();
            $table->string('video_title')->default('Watch a video about how we work and try for our students');
            $table->string('video_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
