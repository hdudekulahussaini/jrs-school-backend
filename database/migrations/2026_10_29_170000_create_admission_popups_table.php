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
        if (!Schema::hasTable('admission_popups')) {
            Schema::create('admission_popups', function (Blueprint $table) {
                $table->id();
                $table->boolean('is_active')->default(true);
                $table->string('image_path')->nullable();
                $table->string('badge_text')->default('ADMISSIONS OPEN');
                $table->string('cbse_affiliation_text')->default('CBSE AFFILIATION: 3630478 • SCHOOL CODE: 56725');
                $table->string('school_name')->default('JRS International School');
                $table->string('school_location')->default('Narapally, Near Uppal, Hyderabad');
                $table->string('academic_year_badge')->default('Academic Year 2027 – 2028');
                $table->string('title_prefix')->default('Admissions Open For');
                $table->string('academic_year_highlight')->default('2027 – 2028');
                $table->text('description')->nullable();
                $table->json('features')->nullable();
                $table->string('phone_number')->default('+91 92814 09674');
                $table->timestamps();
            });
        } else {
            $columnsToDrop = [];
            foreach (['primary_button_url', 'primary_button_text', 'secondary_button_text'] as $col) {
                if (Schema::hasColumn('admission_popups', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            if (!empty($columnsToDrop)) {
                Schema::table('admission_popups', function (Blueprint $table) use ($columnsToDrop) {
                    $table->dropColumn($columnsToDrop);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_popups');
    }
};
