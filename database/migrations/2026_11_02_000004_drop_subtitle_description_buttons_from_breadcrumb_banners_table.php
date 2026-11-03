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
        if (Schema::hasTable('breadcrumb_banners')) {
            $columns = [
                'subtitle',
                'description',
                'primary_button_text',
                'primary_button_url',
                'secondary_button_text',
                'secondary_button_url',
            ];

            $toDrop = [];
            foreach ($columns as $column) {
                if (Schema::hasColumn('breadcrumb_banners', $column)) {
                    $toDrop[] = $column;
                }
            }

            if (!empty($toDrop)) {
                Schema::table('breadcrumb_banners', function (Blueprint $table) use ($toDrop) {
                    $table->dropColumn($toDrop);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('breadcrumb_banners')) {
            Schema::table('breadcrumb_banners', function (Blueprint $table) {
                $table->string('subtitle')->nullable();
                $table->text('description')->nullable();
                $table->string('primary_button_text')->nullable();
                $table->string('primary_button_url')->nullable();
                $table->string('secondary_button_text')->nullable();
                $table->string('secondary_button_url')->nullable();
            });
        }
    }
};
