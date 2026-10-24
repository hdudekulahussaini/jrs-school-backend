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
        Schema::create('school_events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Event title e.g. Republic Day Celebrations, Annual Day');
            $table->date('event_date')->nullable()->comment('Calendar date of the event');
            $table->string('badge_day', 10)->nullable()->comment('Display day number e.g. 26');
            $table->string('badge_month', 10)->nullable()->comment('Display month uppercase e.g. JAN, FEB');
            $table->text('description')->nullable()->comment('Short summary of the event proceedings');
            $table->string('image_path')->nullable()->comment('Uploaded photo or public image asset URL');
            $table->string('link_url')->nullable()->default('/gallery')->comment('Target link for explore event');
            $table->string('link_text')->nullable()->default('Explore event')->comment('Call to action label');
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
        Schema::dropIfExists('school_events');
    }
};
