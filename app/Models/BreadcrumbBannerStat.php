<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreadcrumbBannerStat extends Model
{
    use HasFactory;

    protected $table = 'breadcrumb_banner_stats';

    protected $fillable = [
        'breadcrumb_banner_id',
        'icon',
        'value',
        'label',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Relationship back to parent Breadcrumb Banner
     */
    public function banner(): BelongsTo
    {
        return $this->belongsTo(BreadcrumbBanner::class, 'breadcrumb_banner_id');
    }
}
