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
        Schema::create('beyond_classroom_ctas', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable()->comment('Small pill tag above headline e.g. Admissions Open');
            $table->string('title')->comment('Primary headline e.g. Give Your Child A Strong Foundation');
            $table->string('highlight_text')->nullable()->comment('Highlighted accent phrase in headline e.g. For Tomorrow');
            $table->text('description')->nullable()->comment('Subheading paragraph text');
            $table->string('primary_button_text')->default('Enquire for Admission');
            $table->string('primary_button_url')->default('/admissions');
            $table->string('secondary_button_text')->nullable()->default('Take a Campus Tour');
            $table->string('secondary_button_url')->nullable()->default('/campus-tour');
            $table->string('image_path')->nullable()->comment('Banner photograph / artwork path');
            $table->string('bg_color')->nullable()->default('#031c3f')->comment('Navy / brand dark background hex code');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beyond_classroom_ctas');
    }
};
