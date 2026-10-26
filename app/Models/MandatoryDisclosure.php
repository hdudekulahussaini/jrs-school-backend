<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MandatoryDisclosure extends Model
{
    use HasFactory;

    protected $table = 'mandatory_disclosures';

    protected $fillable = [
        'category',
        's_no',
        'title',
        'value',
        'button_label',
        'file_path',
        'file_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'download_link',
    ];

    /**
     * Resolved download or viewing link.
     */
    public function getDownloadLinkAttribute(): ?string
    {
        if (!empty($this->file_path)) {
            return asset(ltrim($this->file_path, '/'));
        }

        return $this->file_url ?: null;
    }

    /**
     * Validation rules for store & update.
     */
    public static function validationRules(): array
    {
        return [
            'category' => 'required|in:general_info,document',
            's_no' => 'nullable|string|max:50',
            'title' => 'required|string|max:255',
            'value' => 'nullable|string',
            'button_label' => 'nullable|string|max:100',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,zip,jpeg,png,webp|max:20480',
            'file_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ];
    }
}
