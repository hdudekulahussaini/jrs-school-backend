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
        Schema::create('admission_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('academic_year')->default('2026-2027');
            $table->string('branch')->default('JRS INTERNATIONAL SCHOOL');
            $table->string('admission_type')->default('DAY SCHOLAR'); // DAY SCHOLAR, BOARDING, etc.
            $table->string('grade');                                 // Nursery, LKG, UKG, Grade 1 - 12
            $table->string('country_code')->default('+91')->nullable();
            $table->string('parent_mobile');                         // 10 digit mobile or +91 format
            $table->date('student_dob')->nullable();                 // Student Date of Birth
            $table->string('status')->default('pending');            // pending, contacted, admitted, closed
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_enquiries');
    }
};
