<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_tickers', function (Blueprint $table) {
            $table->text('pdf_url')->nullable();
            $table->text('title')->change();
        });

        DB::table('news_tickers')
            ->select(['id', 'title', 'link_url'])
            ->orderBy('id')
            ->chunkById(100, function ($tickers): void {
                foreach ($tickers as $ticker) {
                    if (!$ticker->link_url) {
                        continue;
                    }

                    $path = parse_url($ticker->link_url, PHP_URL_PATH);
                    if (is_string($path) && preg_match('/\.pdf$/i', $path)) {
                        DB::table('news_tickers')
                            ->where('id', $ticker->id)
                            ->update(['pdf_url' => $ticker->link_url]);

                        continue;
                    }

                    DB::table('news_tickers')
                        ->where('id', $ticker->id)
                        ->update([
                            'title' => rtrim($ticker->title) . ' (Previously linked: ' . $ticker->link_url . ')',
                        ]);
                }
            });

        Schema::table('news_tickers', function (Blueprint $table) {
            $table->dropColumn(['badge_text', 'link_url', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::table('news_tickers', function (Blueprint $table) {
            $table->string('badge_text')->default('NEWS');
            $table->text('link_url')->nullable();
            $table->integer('sort_order')->default(0);
        });

        DB::table('news_tickers')
            ->whereNotNull('pdf_url')
            ->update(['link_url' => DB::raw('pdf_url')]);

        Schema::table('news_tickers', function (Blueprint $table) {
            $table->dropColumn('pdf_url');
        });
    }
};
