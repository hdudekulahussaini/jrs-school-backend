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
        Schema::table('mandatory_disclosures', function (Blueprint $table) {
            $table->string('category', 50)->default('general_info')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mandatory_disclosures', function (Blueprint $table) {
            $table->enum('category', ['general_info', 'document'])->default('general_info')->change();
        });
    }
};
