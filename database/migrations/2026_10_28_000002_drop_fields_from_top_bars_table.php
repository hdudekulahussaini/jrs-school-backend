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
            $columns = [
                'phone_2_href',
                'phone_href',
                'email_href',
                'cbse_affiliation_code',
                'bse_affiliation_code',
                'mandatory_disclosure_url',
                'mandatory_disclosure_file',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('top_bars', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('top_bars', function (Blueprint $table) {
            if (!Schema::hasColumn('top_bars', 'phone_href')) {
                $table->string('phone_href')->nullable();
            }
            if (!Schema::hasColumn('top_bars', 'phone_2_href')) {
                $table->string('phone_2_href')->nullable();
            }
            if (!Schema::hasColumn('top_bars', 'email_href')) {
                $table->string('email_href')->nullable();
            }
            if (!Schema::hasColumn('top_bars', 'cbse_affiliation_code')) {
                $table->string('cbse_affiliation_code')->nullable();
            }
            if (!Schema::hasColumn('top_bars', 'mandatory_disclosure_url')) {
                $table->string('mandatory_disclosure_url')->nullable();
            }
            if (!Schema::hasColumn('top_bars', 'mandatory_disclosure_file')) {
                $table->string('mandatory_disclosure_file')->nullable();
            }
        });
    }
};
