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
            if (!Schema::hasColumn('contact_settings', 'facebook_url')) {
                $table->string('facebook_url')->nullable()->after('map_link');
            }
            if (!Schema::hasColumn('contact_settings', 'instagram_url')) {
                $table->string('instagram_url')->nullable()->after('facebook_url');
            }
            if (!Schema::hasColumn('contact_settings', 'twitter_url')) {
                $table->string('twitter_url')->nullable()->after('instagram_url');
            }
            if (!Schema::hasColumn('contact_settings', 'youtube_url')) {
                $table->string('youtube_url')->nullable()->after('twitter_url');
            }
            if (!Schema::hasColumn('contact_settings', 'linkedin_url')) {
                $table->string('linkedin_url')->nullable()->after('youtube_url');
            }
            if (!Schema::hasColumn('contact_settings', 'social_links')) {
                $table->json('social_links')->nullable()->after('linkedin_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            $columns = [
                'facebook_url',
                'instagram_url',
                'twitter_url',
                'youtube_url',
                'linkedin_url',
                'social_links',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('contact_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
