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
        if (!Schema::hasTable('hero_sliders')) {
            Schema::create('hero_sliders', function (Blueprint $table) {
                $table->id();
                $table->string('badge_title')->nullable()->comment('E.g. NURTURING BRIGHT MINDS - BUILDING A BETTER TOMORROW');
                $table->string('title')->comment('Main title line 1 (e.g. Empowering)');
                $table->string('highlight_text')->nullable()->comment('Highlighted title line 2 in gold (e.g. Future Leaders)');
                $table->text('description')->nullable()->comment('Slide paragraph/subtext');
                $table->string('primary_button_text')->nullable()->default('Admissions 2026-27');
                $table->string('primary_button_url')->nullable()->default('#admissions');
                $table->string('secondary_button_text')->nullable()->default('Take a Virtual Tour');
                $table->string('secondary_button_url')->nullable()->default('#virtual-tour');
                $table->string('image_path')->nullable()->comment('Uploaded slide background image path or URL');
                $table->string('contact_phone')->nullable()->comment('Optional telephone/contact prompt e.g. +91 9157404321');
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sliders');
    }
};
