<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $removedColumns = [
        'is_active',
        'badge_text',
        'cbse_affiliation_text',
        'school_name',
        'school_location',
        'academic_year_badge',
        'title_prefix',
        'academic_year_highlight',
        'description',
        'features',
        'phone_number',
        'primary_button_url',
        'primary_button_text',
        'secondary_button_text',
    ];

    public function up(): void
    {
        if (!Schema::hasTable('admission_popups')) {
            return;
        }

        $columnsToDrop = array_values(array_filter(
            $this->removedColumns,
            fn (string $column): bool => Schema::hasColumn('admission_popups', $column)
        ));

        if ($columnsToDrop !== []) {
            Schema::table('admission_popups', function (Blueprint $table) use ($columnsToDrop): void {
                $table->dropColumn($columnsToDrop);
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('admission_popups')) {
            return;
        }

        Schema::table('admission_popups', function (Blueprint $table): void {
            $table->boolean('is_active')->default(true);
            $table->string('badge_text')->nullable();
            $table->string('cbse_affiliation_text')->nullable();
            $table->string('school_name')->nullable();
            $table->string('school_location')->nullable();
            $table->string('academic_year_badge')->nullable();
            $table->string('title_prefix')->nullable();
            $table->string('academic_year_highlight')->nullable();
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('primary_button_url')->nullable();
            $table->string('primary_button_text')->nullable();
            $table->string('secondary_button_text')->nullable();
        });
    }
};
