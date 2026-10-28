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
        if (Schema::hasTable('top_bars') && Schema::hasColumn('top_bars', 'mandatory_disclosure_title')) {
            Schema::table('top_bars', function (Blueprint $table) {
                $table->dropColumn('mandatory_disclosure_title');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('top_bars') && !Schema::hasColumn('top_bars', 'mandatory_disclosure_title')) {
            Schema::table('top_bars', function (Blueprint $table) {
                $table->string('mandatory_disclosure_title')->nullable()->default('Mandatory Disclosure');
            });
        }
    }
};
