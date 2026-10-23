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
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->default('NURTURING BRIGHT MINDS • BUILDING A BETTER TOMORROW');
            $table->string('title_line1')->default('Empowering');
            $table->string('title_line2')->default('Future Leaders');
            $table->text('description');
            $table->string('cta_primary_text')->default('Admissions 2026-27');
            $table->string('cta_primary_link')->default('/admissions');
            $table->string('cta_secondary_text')->nullable()->default('Take a Virtual Tour');
            $table->string('cta_secondary_link')->nullable()->default('#tour');
            $table->string('image_url')->default('/images/hero image.png');
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
        Schema::dropIfExists('hero_slides');
    }
};
