<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerOpportunity extends Model
{
    use HasFactory;

    protected $table = 'career_opportunities';

    protected $fillable = [
        'badge',
        'title',
        'highlight_title',
        'description',
        'card_badge',
        'card_title',
        'card_description',
        'email',
        'checklist_title',
        'checklist_items',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'checklist_items' => 'array',
    ];

    /**
     * Default checklist items for application requirements.
     */
    public static function defaultChecklist(): array
    {
        return [
            'Contact number',
            'Experience, subjects taught along with the curriculum followed by the school or the position & nature of work in the prior organization.',
            'Your resume should mention educational degrees and the subjects you graduated in.'
        ];
    }

    /**
     * Centralized validation rules.
     */
    public static function validationRules($id = null): array
    {
        return [
            'badge' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'highlight_title' => 'nullable|string|max:255',
            'description' => 'required|string',
            'card_badge' => 'nullable|string|max:100',
            'card_title' => 'required|string|max:255',
            'card_description' => 'nullable|string',
            'email' => 'required|email|max:255',
            'checklist_title' => 'nullable|string|max:255',
            'checklist_items' => 'nullable|array',
            'checklist_items.*' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }
}
