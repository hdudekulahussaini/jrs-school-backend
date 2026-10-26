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
        Schema::create('news_media', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Main headline (Telugu or English)
            $table->string('english_title')->nullable(); // English translation/quote/subtitle
            $table->string('newspaper_name'); // e.g., 'మన తెలంగాణ (Mana Telangana)'
            $table->string('location')->nullable(); // e.g., 'Ghatkesar', 'Ranga Reddy', 'Medchal'
            $table->date('published_date'); // Date of publication
            $table->text('description')->nullable(); // Excerpt / snippet text
            $table->string('image_path'); // Newspaper clipping photo
            $table->string('article_url')->nullable(); // Optional external link or full view link
            $table->boolean('is_featured')->default(false); // Featured in "Our Achievements In The News"
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
        Schema::dropIfExists('news_media');
    }
};
