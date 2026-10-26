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
        Schema::create('job_openings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Job title e.g. Primary English Teacher, PRT/TGT Mathematics');
            $table->string('department')->nullable()->comment('Department e.g. Academics, Sports, Administration');
            $table->string('job_type')->default('Full-Time')->comment('Full-Time, Part-Time, Contract');
            $table->string('experience')->nullable()->default('2-5 Years')->comment('Required experience');
            $table->string('qualification')->nullable()->comment('Required qualification e.g. B.Ed, M.Sc, B.P.Ed');
            $table->text('description')->nullable()->comment('Job role responsibilities and requirements');
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
        Schema::dropIfExists('job_openings');
    }
};
