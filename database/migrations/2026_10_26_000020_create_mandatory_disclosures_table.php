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
        Schema::create('mandatory_disclosures', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['general_info', 'document'])->default('general_info');
            $table->string('s_no')->nullable(); // e.g. "1", "2"
            $table->string('title'); // Information title or Document title
            $table->text('value')->nullable(); // Details text (for general_info)
            $table->string('button_label')->nullable(); // Button text (for document, e.g. "NOC Certificate")
            $table->string('file_path')->nullable(); // Uploaded PDF file path
            $table->string('file_url')->nullable(); // External link URL
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
        Schema::dropIfExists('mandatory_disclosures');
    }
};
