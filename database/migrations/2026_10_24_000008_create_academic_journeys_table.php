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
        Schema::create('academic_journeys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('age_group')->nullable(); // e.g. "Early Years", "Age 2.5 to 3.5 years"
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->default('baby'); // lucide icon identifier: baby, users, sparkles, heart
            $table->text('icon_svg')->nullable();
            $table->string('image_path')->nullable();
            $table->string('link_url')->nullable(); // e.g. /academics/pre-primary-programme
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
        Schema::dropIfExists('academic_journeys');
    }
};
