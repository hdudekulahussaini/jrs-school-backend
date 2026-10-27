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
        Schema::create('breadcrumb_banner_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('breadcrumb_banner_id')->constrained('breadcrumb_banners')->onDelete('cascade');
            $table->string('icon')->nullable()->default('sparkles');
            $table->string('value');
            $table->string('label');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breadcrumb_banner_stats');
    }
};
