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
        if (!Schema::hasTable('facilities')) {
            Schema::create('facilities', function (Blueprint $table) {
                $table->id();
                $table->string('title')->comment('Facility name e.g. Smart Classrooms');
                $table->text('description')->nullable()->comment('Short description e.g. Modern and interactive learning spaces');
                $table->string('image_path')->nullable()->comment('Uploaded facility image or URL');
                $table->string('icon')->nullable()->default('school')->comment('Lucide/SVG Icon identifier (e.g. monitor, flask, book, trophy, bus)');
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
        Schema::dropIfExists('facilities');
    }
};
