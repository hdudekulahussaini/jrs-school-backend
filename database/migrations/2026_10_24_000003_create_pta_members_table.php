<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Parent Teacher Association (PTA) committee members.
     */
    public function up(): void
    {
        if (!Schema::hasTable('pta_members')) {
            Schema::create('pta_members', function (Blueprint $table) {
                $table->id();
                $table->string('name')->comment('Member full name');
                $table->string('designation')->default('MEMBER')->comment('CHAIRMAN, MEMBER, SECRETARY, etc.');
                $table->string('address')->nullable()->comment('Residential location / city');
                $table->string('phone')->nullable()->comment('Contact phone number');
                $table->string('image_path')->nullable()->comment('Uploaded photo or avatar path');
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
        Schema::dropIfExists('pta_members');
    }
};
