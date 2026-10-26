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
        Schema::create('principal_messages', function (Blueprint $table) {
            $table->id();

            // Document Header Info
            $table->string('desk_title')->default('FROM THE DESK OF');
            $table->string('desk_subtitle')->default('The Principal, JRS International School');
            $table->string('official_address_badge')->default('OFFICIAL ADDRESS');
            $table->string('academic_year')->default('Academic Year 2026 – 2027');

            // Principal's Message Header
            $table->string('section_badge')->default("PRINCIPAL'S MESSAGE");
            $table->string('title')->default('Empowering Minds And Enriching Lives');
            $table->string('salutation')->default('Dear Parents, Students And Well-Wishers,');

            // Profile Card (Left Column)
            $table->string('card_badge')->default('PRINCIPAL');
            $table->string('profile_badge')->default('ACADEMIC LEADERSHIP');
            $table->string('name')->default('Mrs. Marlene Mannas');
            $table->string('sub_title')->default('Principal, JRS International School');
            $table->string('image_path')->nullable();

            // Message Body & Quote
            $table->text('paragraph')->nullable();
            $table->text('quote')->nullable();

            // Sign-off & Stamp
            $table->string('signoff_note')->default('WARM REGARDS,');
            $table->string('signoff_signature')->default('Marlene Mannas');
            $table->string('signoff_name')->default('Mrs. Marlene Mannas');
            $table->string('signoff_sub')->default('Principal, JRS International School');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('principal_messages');
    }
};
