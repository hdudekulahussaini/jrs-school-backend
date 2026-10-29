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
        Schema::table('academic_programs', function (Blueprint $table) {
            if (Schema::hasColumn('academic_programs', 'button_text')) {
                $table->dropColumn('button_text');
            }
            if (Schema::hasColumn('academic_programs', 'button_url')) {
                $table->dropColumn('button_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_programs', function (Blueprint $table) {
            if (!Schema::hasColumn('academic_programs', 'button_text')) {
                $table->string('button_text')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('academic_programs', 'button_url')) {
                $table->string('button_url')->nullable()->after('button_text');
            }
        });
    }
};
