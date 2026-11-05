<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('admission_enquiries', 'country_code')) {
            Schema::table('admission_enquiries', function (Blueprint $table) {
                $table->dropColumn('country_code');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('admission_enquiries', 'country_code')) {
            Schema::table('admission_enquiries', function (Blueprint $table) {
                $table->string('country_code', 10)->nullable();
            });
        }
    }
};
