<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SchoolEvent extends Model
{
    use HasFactory;

    protected $table = 'school_events';

    protected $fillable = [
        'title',
        'event_date',
        'badge_day',
        'badge_month',
        'description',
        'image_path',
        'link_url',
        'link_text',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'event_date' => 'date:Y-m-d',
    ];

    protected $appends = [
        'image_full_url',
        'display_day',
        'display_month',
    ];

    /**
     * Compute full URL for the event image.
     */
    public function getImageFullUrlAttribute(): ?string
    {
        if (empty($this->image_path)) {
            return null;
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return url($this->image_path);
    }

    /**
     * Day number for the card badge.
     */
    public function getDisplayDayAttribute(): string
    {
        if (!empty($this->badge_day)) {
            return (string)$this->badge_day;
        }

        if ($this->event_date) {
            return Carbon::parse($this->event_date)->format('d');
        }

        return '01';
    }

    /**
     * Month uppercase for the card badge (e.g. JAN).
     */
    public function getDisplayMonthAttribute(): string
    {
        if (!empty($this->badge_month)) {
            return strtoupper($this->badge_month);
        }

        if ($this->event_date) {
            return strtoupper(Carbon::parse($this->event_date)->format('M'));
        }

        return 'JAN';
    }

    /**
     * Centralized validation rules for School Events.
     */
    public static function validationRules($id = null): array
    {
        return [
            'title' => 'required|string|max:255',
            'event_date' => 'nullable|date',
            'badge_day' => 'nullable|string|max:10',
            'badge_month' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'link_url' => 'nullable|string|max:1000',
            'link_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'image_path' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }
}
