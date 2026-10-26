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
        Schema::create('admission_heroes', function (Blueprint $table) {
            $table->id();
            $table->string('location_tag')->default('NARAPALLY, HYDERABAD');
            $table->string('title')->default('Admission Open For');
            $table->string('academic_year')->default('2026 – 2027');
            $table->text('description');
            $table->string('phone')->default('+91 915740 43210');
            $table->string('email')->default('info@jrsinternationalschool.com');
            $table->json('features')->nullable();
            $table->json('trust_badges')->nullable();

            // Enquiry Form Settings (Configured via Admin)
            $table->json('enquiry_academic_years')->nullable();
            $table->json('enquiry_admission_types')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_heroes');
    }
};
