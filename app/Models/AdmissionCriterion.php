<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionCriterion extends Model
{
    use HasFactory;

    protected $table = 'admission_criteria';

    protected $fillable = [
        'step_number',
        'badge_tag',
        'title',
        'description',
        'icon',
        'note',
        'points',
    ];

    protected $casts = [
        'step_number' => 'integer',
        'points'      => 'array',
    ];

    /**
     * Compute 2-digit watermark number (e.g. 1 -> "01", 2 -> "02").
     */
    public function getWatermarkNumberAttribute(): string
    {
        return str_pad((string)($this->step_number ?? 1), 2, '0', STR_PAD_LEFT);
    }
}
