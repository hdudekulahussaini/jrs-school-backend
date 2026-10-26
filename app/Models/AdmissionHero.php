<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionHero extends Model
{
    use HasFactory;

    protected $table = 'admission_heroes';

    protected $fillable = [
        'location_tag',
        'title',
        'academic_year',
        'description',
        'phone',
        'email',
        'features',
        'trust_badges',
        'enquiry_academic_years',
        'enquiry_admission_types',
    ];

    protected $casts = [
        'features'                => 'array',
        'trust_badges'            => 'array',
        'enquiry_academic_years'  => 'array',
        'enquiry_admission_types' => 'array',
    ];
}
