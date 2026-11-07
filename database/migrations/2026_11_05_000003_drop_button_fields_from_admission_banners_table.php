<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $buttonColumns = [
        'primary_button_text',
        'primary_button_link',
        'secondary_button_text',
        'secondary_button_link',
    ];

    public function up(): void
    {
        if (!Schema::hasTable('admission_banners')) {
            return;
        }

        $columns = array_values(array_filter(
            $this->buttonColumns,
            static fn (string $column): bool => Schema::hasColumn('admission_banners', $column)
        ));

        if ($columns !== []) {
            Schema::table('admission_banners', function (Blueprint $table) use ($columns): void {
                $table->dropColumn($columns);
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('admission_banners')) {
            return;
        }

        $columns = array_values(array_filter(
            $this->buttonColumns,
            static fn (string $column): bool => !Schema::hasColumn('admission_banners', $column)
        ));

        if ($columns !== []) {
            Schema::table('admission_banners', function (Blueprint $table) use ($columns): void {
                foreach ($columns as $column) {
                    $definition = $table->string($column)->nullable();

                    if ($column === 'primary_button_text') {
                        $definition->default('Enquire for Admission');
                    } elseif ($column === 'secondary_button_text') {
                        $definition->default('Take a Campus Tour');
                    } elseif ($column === 'secondary_button_link') {
                        $definition->default('/campus-tour');
                    }
                }
            });
        }
    }
};
