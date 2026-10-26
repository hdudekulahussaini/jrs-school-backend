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
        Schema::create('career_sections', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->default('TEACHING AT JRS')->comment('Top small red pill badge');
            $table->string('title')->default('Grow. Teach. Inspire. Make A Difference.')->comment('Full headline text');
            $table->string('highlight_1')->nullable()->default('Inspire.')->comment('First red highlighted word/phrase');
            $table->string('highlight_2')->nullable()->default('Difference.')->comment('Second red highlighted word/phrase');
            $table->text('description')->comment('Teaching at JRS description paragraph');
            $table->string('image_path')->nullable()->comment('School campus / teachers image');
            $table->string('apply_email')->nullable()->default('careers@jrsschool.com')->comment('Email where candidates send resumes');
            $table->string('apply_phone')->nullable()->default('+91 98765 43210');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_sections');
    }
};
