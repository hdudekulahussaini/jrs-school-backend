<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionStep extends Model
{
    use HasFactory;

    protected $table = 'admission_steps';

    protected $fillable = [
        'step_number',
        'title',
        'description',
        'icon',
    ];

    protected $casts = [
        'step_number' => 'integer',
    ];

    /**
     * Compute badge number string (e.g. 1 -> "01", 2 -> "02").
     */
    public function getBadgeNumberAttribute(): string
    {
        return str_pad((string)($this->step_number ?? 1), 2, '0', STR_PAD_LEFT);
    }

    /**
     * Compute alternating accent color (odd: navy, even: red).
     */
    public function getAccentColorAttribute(): string
    {
        return ($this->step_number % 2 === 1) ? 'navy' : 'red';
    }
}
