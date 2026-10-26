<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Campus Tour & Life At JRS section.
     */
    public function up(): void
    {
        if (!Schema::hasTable('campus_lives')) {
            Schema::create('campus_lives', function (Blueprint $table) {
                $table->id();
                $table->string('title')->comment('Card title e.g. Eco-Friendly Campus');
                $table->string('subtitle')->nullable()->comment('Optional short badge or description');
                $table->string('icon')->nullable()->default('leaf')->comment('Icon identifier: leaf, atom, book, trophy, etc.');
                $table->string('image_path')->nullable()->comment('Uploaded image or external URL');
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
        Schema::dropIfExists('campus_lives');
    }
};
