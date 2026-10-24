<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Why Choose JRS section.
     */
    public function up(): void
    {
        if (!Schema::hasTable('why_choose_features')) {
            Schema::create('why_choose_features', function (Blueprint $table) {
                $table->id();
                $table->string('type')->default('card')->comment('card for top feature cards, badge for bottom pills');
                $table->string('title')->comment('Feature title or badge label');
                $table->text('description')->nullable()->comment('Short explanation for feature cards');
                $table->string('icon')->nullable()->default('trophy')->comment('Icon identifier');
                $table->string('icon_color')->nullable()->default('red')->comment('Theme color: red, blue, amber, purple, emerald');
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('why_choose_features');
    }
};
