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
        Schema::table('academic_journeys', function (Blueprint $table) {
            if (!Schema::hasColumn('academic_journeys', 'lead_text')) {
                $table->text('lead_text')->nullable()->after('title');
            }
            if (!Schema::hasColumn('academic_journeys', 'highlights')) {
                $table->json('highlights')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_journeys', function (Blueprint $table) {
            $table->dropColumn([
                'lead_text',
                'highlights',
            ]);
        });
    }
};
