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
        Schema::create('top_bars', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->default('+91 915740 43210');
            $table->string('phone_2')->nullable()->default('+91 915740 43211');
            $table->string('email')->default('info@jrsinternationalschool.com');
            $table->string('cbse_affiliation_text')->default('CBSE Affiliated School');

            $table->string('mandatory_disclosure_title')->default('Mandatory Disclosure');

            $table->string('prospectus_title')->default('School Prospectus');
            $table->string('prospectus_url')->nullable();
            $table->string('prospectus_file')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_bars');
    }
};
