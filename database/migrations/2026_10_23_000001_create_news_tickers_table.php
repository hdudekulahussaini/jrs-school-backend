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
        if (!Schema::hasTable('news_tickers')) {
            Schema::create('news_tickers', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('badge_text')->default('NEWS');
                $table->string('link_url')->nullable();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            Schema::table('news_tickers', function (Blueprint $table) {
                if (!Schema::hasColumn('news_tickers', 'badge_text')) {
                    $table->string('badge_text')->default('NEWS')->after('title');
                }
                if (!Schema::hasColumn('news_tickers', 'link_url')) {
                    $table->string('link_url')->nullable()->after('badge_text');
                }
                if (!Schema::hasColumn('news_tickers', 'sort_order')) {
                    $table->integer('sort_order')->default(0)->after('link_url');
                }
                if (!Schema::hasColumn('news_tickers', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('sort_order');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_tickers');
    }
};
