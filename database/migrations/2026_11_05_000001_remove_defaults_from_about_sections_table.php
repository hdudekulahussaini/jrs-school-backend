<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            $table->string('tagline')->nullable()->default(null)->change();
            $table->string('title')->nullable()->default(null)->change();
            $table->string('title_highlight')->nullable()->default(null)->change();
            $table->string('video_title')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            $table->string('tagline')->nullable(false)->change();
            $table->string('title')->nullable(false)->change();
            $table->string('title_highlight')->nullable()->change();
            $table->string('video_title')->nullable()->change();
        });
    }
};
