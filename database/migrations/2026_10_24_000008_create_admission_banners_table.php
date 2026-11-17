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
        Schema::create('admission_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Give Your Child A Strong Foundation');
            $table->string('title_highlight')->nullable()->default('For Tomorrow');
            $table->text('description')->nullable();
            $table->string('primary_button_text')->nullable()->default('Enquire for Admission');
            $table->string('primary_button_link')->nullable();
            $table->string('secondary_button_text')->nullable()->default('Take a Campus Tour');
            $table->string('secondary_button_link')->nullable()->default('/campus-tour');
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_banners');
    }
};
