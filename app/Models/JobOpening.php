<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpening extends Model
{
    use HasFactory;

    protected $table = 'job_openings';

    protected $fillable = [
        'title',
        'department',
        'job_type',
        'experience',
        'qualification',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function validationRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:100',
            'job_type' => 'nullable|string|max:50',
            'experience' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ];
    }
}
