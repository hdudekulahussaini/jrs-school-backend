<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('campus_lives') && Schema::hasColumn('campus_lives', 'subtitle')) {
            Schema::table('campus_lives', function (Blueprint $table): void {
                $table->dropColumn('subtitle');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('campus_lives') && !Schema::hasColumn('campus_lives', 'subtitle')) {
            Schema::table('campus_lives', function (Blueprint $table): void {
                $table->string('subtitle')->nullable();
            });
        }
    }
};
