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
        Schema::table('top_bars', function (Blueprint $table) {
            if (!Schema::hasColumn('top_bars', 'phone_2')) {
                $table->string('phone_2')->nullable()->after('phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('top_bars', function (Blueprint $table) {
            if (Schema::hasColumn('top_bars', 'phone_2')) {
                $table->dropColumn('phone_2');
            }
        });
    }
};
