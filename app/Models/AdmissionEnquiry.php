<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionEnquiry extends Model
{
    use HasFactory;

    protected $table = 'admission_enquiries';

    protected $fillable = [
        'academic_year',
        'branch',
        'admission_type',
        'grade',
        'country_code',
        'parent_mobile',
        'student_dob',
        'status',
        'notes',
    ];

    protected $casts = [
        'student_dob' => 'date',
    ];
}
