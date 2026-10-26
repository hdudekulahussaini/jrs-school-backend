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
        Schema::table('admission_heroes', function (Blueprint $table) {
            if (!Schema::hasColumn('admission_heroes', 'enquiry_academic_years')) {
                $table->json('enquiry_academic_years')->nullable()->after('trust_badges');
            }
            if (!Schema::hasColumn('admission_heroes', 'enquiry_admission_types')) {
                $table->json('enquiry_admission_types')->nullable()->after('enquiry_academic_years');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_heroes', function (Blueprint $table) {
            $columns = [
                'enquiry_academic_years',
                'enquiry_admission_types',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('admission_heroes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
