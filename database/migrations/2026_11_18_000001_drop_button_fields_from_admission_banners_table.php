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
        if (Schema::hasTable('admission_banners')) {
            Schema::table('admission_banners', function (Blueprint $table) {
                $columns = [];
                foreach (['primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link'] as $col) {
                    if (Schema::hasColumn('admission_banners', $col)) {
                        $columns[] = $col;
                    }
                }
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('admission_banners')) {
            Schema::table('admission_banners', function (Blueprint $table) {
                if (!Schema::hasColumn('admission_banners', 'primary_button_text')) {
                    $table->string('primary_button_text')->nullable()->default('Enquire for Admission')->after('description');
                }
                if (!Schema::hasColumn('admission_banners', 'primary_button_link')) {
                    $table->string('primary_button_link')->nullable()->after('primary_button_text');
                }
                if (!Schema::hasColumn('admission_banners', 'secondary_button_text')) {
                    $table->string('secondary_button_text')->nullable()->default('Take a Campus Tour')->after('primary_button_link');
                }
                if (!Schema::hasColumn('admission_banners', 'secondary_button_link')) {
                    $table->string('secondary_button_link')->nullable()->default('/campus-tour')->after('secondary_button_text');
                }
            });
        }
    }
};
