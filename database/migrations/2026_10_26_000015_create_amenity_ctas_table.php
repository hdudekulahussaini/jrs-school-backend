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
        Schema::create('amenity_ctas', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->default('JOIN THE JRS JOURNEY');
            $table->string('title')->default('We Invite Everyone To Join Us On Our Journey Towards Excellence.');
            $table->string('highlight_text')->nullable()->default('Excellence.');
            $table->text('description')->nullable();
            $table->string('primary_button_text')->default('Book a Campus Tour &rarr;');
            $table->string('primary_button_url')->default('/campus-tour');
            $table->string('secondary_button_text')->nullable()->default('Contact School');
            $table->string('secondary_button_url')->nullable()->default('/contact');
            $table->string('image_path')->nullable()->default('/images/amenities/cta-banner.png');
            $table->string('bg_color')->default('#031c3f');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenity_ctas');
    }
};
