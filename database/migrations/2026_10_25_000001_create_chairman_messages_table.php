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
        Schema::create('chairman_messages', function (Blueprint $table) {
            $table->id();

            // Section 1: Chairman's Address & Leadership Profile
            $table->string('section_badge')->default("CHAIRMAN'S ADDRESS");
            $table->string('title')->default('Empowering Young Minds For A Changing World');
            $table->string('profile_badge')->default('FOUNDING LEADERSHIP');
            $table->string('name')->default('Chairman Of JRS');
            $table->string('sub_title')->default('JRS International School • Hyderabad');
            $table->text('quote')->nullable();
            $table->string('image_path')->nullable();
            $table->text('paragraph')->nullable();
            $table->string('signoff_note')->default('WITH WARM WISHES & COMMITMENT,');
            $table->string('signoff_name')->default('Chairman');
            $table->string('signoff_sub')->default('JRS International School, Hyderabad');

            // Section 2: Strategic Commitment Banner
            $table->string('commitment_badge')->default('OUR STRATEGIC COMMITMENT');
            $table->string('commitment_title')->default('Building An Empowered Generation For Tomorrow');
            $table->text('commitment_description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chairman_messages');
    }
};
