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
        Schema::table('amenity_ctas', function (Blueprint $table) {
            $table->dropColumn([
                'primary_button_text',
                'primary_button_url',
                'secondary_button_text',
                'secondary_button_url',
                'image_path',
                'bg_color',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amenity_ctas', function (Blueprint $table) {
            $table->string('primary_button_text')->default('Book a Campus Tour &rarr;');
            $table->string('primary_button_url')->default('/campus-tour');
            $table->string('secondary_button_text')->nullable()->default('Contact School');
            $table->string('secondary_button_url')->nullable()->default('/contact');
            $table->string('image_path')->nullable()->default('/images/amenities/cta-banner.png');
            $table->string('bg_color')->default('#031c3f');
        });
    }
};
