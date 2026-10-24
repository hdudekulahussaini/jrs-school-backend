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
        Schema::create('academic_programs', function (Blueprint $table) {
            $table->id();
            $table->string('stage_badge')->nullable()->default('STAGE 01 • EARLY YEARS')->comment('Stage badge label e.g. STAGE 01 • EARLY YEARS');
            $table->string('title')->comment('Program title e.g. Pre-Primary, Primary School');
            $table->string('subtitle')->nullable()->comment('Classes/Grades covered e.g. NURSERY, LKG & UKG');
            $table->text('description')->nullable()->comment('Paragraph description of the program');
            $table->json('highlights')->nullable()->comment('Array of bullet points/curriculum features');
            $table->string('button_text')->nullable()->default('Explore More')->comment('Call to action button text');
            $table->string('button_url')->nullable()->default('/academics')->comment('Target link or route');
            $table->string('image_path')->nullable()->comment('Uploaded student/program image or public path');
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
        Schema::dropIfExists('academic_programs');
    }
};
