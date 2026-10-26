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
        Schema::create('career_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->default('CAREER OPPORTUNITIES');
            $table->string('title')->default('Who Are Passionate About Their Field –');
            $table->string('highlight_title')->default('A Great Future Awaits You At JRS');
            $table->text('description');
            
            // How To Apply card fields
            $table->string('card_badge')->default('APPLICATION PROCESS');
            $table->string('card_title')->default('How To Apply');
            $table->text('card_description')->nullable();
            $table->string('email')->default('hrjrshyd@gmail.com');
            $table->string('checklist_title')->default('Please Ensure You Mention:');
            $table->json('checklist_items')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_opportunities');
    }
};
