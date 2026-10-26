<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for School Management Committee (SMC) members.
     */
    public function up(): void
    {
        if (!Schema::hasTable('school_management_members')) {
            Schema::create('school_management_members', function (Blueprint $table) {
                $table->id();
                $table->string('name')->comment('Member full name');
                $table->string('designation')->default('MEMBER')->comment('CHAIRMAN, MEMBER, etc.');
                $table->string('address')->nullable()->comment('Locality / residential address / school');
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
        Schema::dropIfExists('school_management_members');
    }
};
