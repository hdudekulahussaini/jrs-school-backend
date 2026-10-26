<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Educational Society Managing Committee members.
     */
    public function up(): void
    {
        if (!Schema::hasTable('educational_society_members')) {
            Schema::create('educational_society_members', function (Blueprint $table) {
                $table->id();
                $table->string('name')->comment('Member full name');
                $table->string('designation')->default('EXE-MEMBER')->comment('PRESIDENT, VICE-PRESIDENT, GENERAL SECRETARY, etc.');
                $table->string('address')->nullable()->comment('Residential address / locality');
                $table->string('phone')->nullable()->comment('Contact phone number');
                $table->string('image_path')->nullable()->comment('Portrait photo or avatar path');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_society_members');
    }
};
