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
        Schema::table('admission_enquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('admission_enquiries', 'country_code')) {
                $table->string('country_code', 10)->default('+91')->nullable()->after('grade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_enquiries', function (Blueprint $table) {
            if (Schema::hasColumn('admission_enquiries', 'country_code')) {
                $table->dropColumn('country_code');
            }
        });
    }
};

