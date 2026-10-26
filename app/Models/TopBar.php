<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopBar extends Model
{
    use HasFactory;

    protected $table = 'top_bars';

    protected $fillable = [
        'phone',
        'phone_href',
        'email',
        'email_href',
        'cbse_affiliation_text',
        'cbse_affiliation_code',
        'mandatory_disclosure_title',
        'mandatory_disclosure_url',
        'mandatory_disclosure_file',
        'prospectus_title',
        'prospectus_url',
        'prospectus_file',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'mandatory_disclosure_link',
        'prospectus_link',
    ];

    /**
     * Resolved download/open link for Mandatory Disclosure (file or external URL).
     */
    public function getMandatoryDisclosureLinkAttribute(): ?string
    {
        if (!empty($this->mandatory_disclosure_file)) {
            return asset(ltrim($this->mandatory_disclosure_file, '/'));
        }

        return $this->mandatory_disclosure_url ?: '#';
    }

    /**
     * Resolved download/open link for School Prospectus (file or external URL).
     */
    public function getProspectusLinkAttribute(): ?string
    {
        if (!empty($this->prospectus_file)) {
            return asset(ltrim($this->prospectus_file, '/'));
        }

        return $this->prospectus_url ?: '#';
    }

    /**
     * Validation rules for Top Bar settings.
     */
    public static function validationRules(): array
    {
        return [
            'phone' => 'required|string|max:50',
            'phone_href' => 'nullable|string|max:100',
            'email' => 'required|email|max:100',
            'email_href' => 'nullable|string|max:100',
            'cbse_affiliation_text' => 'required|string|max:150',
            'cbse_affiliation_code' => 'nullable|string|max:100',
            'mandatory_disclosure_title' => 'required|string|max:100',
            'mandatory_disclosure_url' => 'nullable|url|max:255',
            'mandatory_disclosure_file_upload' => 'nullable|file|mimes:pdf,doc,docx,zip|max:20480',
            'prospectus_title' => 'required|string|max:100',
            'prospectus_url' => 'nullable|url|max:255',
            'prospectus_file_upload' => 'nullable|file|mimes:pdf,doc,docx,zip|max:20480',
            'is_active' => 'nullable|boolean',
        ];
    }
}
