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
        Schema::table('contact_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_settings', 'phone_2')) {
                $table->string('phone_2')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('contact_settings', 'phone_3')) {
                $table->string('phone_3')->nullable()->after('phone_2');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            if (Schema::hasColumn('contact_settings', 'phone_3')) {
                $table->dropColumn('phone_3');
            }
            if (Schema::hasColumn('contact_settings', 'phone_2')) {
                $table->dropColumn('phone_2');
            }
        });
    }
};

