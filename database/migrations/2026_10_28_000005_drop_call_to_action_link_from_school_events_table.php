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
        Schema::table('school_events', function (Blueprint $table) {
            if (Schema::hasColumn('school_events', 'link_text')) {
                $table->dropColumn('link_text');
            }
            if (Schema::hasColumn('school_events', 'link_url')) {
                $table->dropColumn('link_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_events', function (Blueprint $table) {
            if (!Schema::hasColumn('school_events', 'link_url')) {
                $table->string('link_url')->nullable()->default('/gallery')->after('image_path')->comment('Target link for explore event');
            }
            if (!Schema::hasColumn('school_events', 'link_text')) {
                $table->string('link_text')->nullable()->default('Explore event')->after('link_url')->comment('Call to action label');
            }
        });
    }
};
