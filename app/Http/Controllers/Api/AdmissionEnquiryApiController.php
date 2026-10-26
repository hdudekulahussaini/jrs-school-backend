<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdmissionEnquiryRequest;
use App\Models\AdmissionEnquiry;
use App\Models\AdmissionHero;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdmissionEnquiryApiController extends Controller
{
    /**
     * Submit an Admission Enquiry from the public website form.
     * POST /api/admission-enquiries
     */
    public function store(AdmissionEnquiryRequest $request): JsonResponse
    {
        $enquiry = AdmissionEnquiry::create([
            'academic_year'  => $request->input('academic_year', '2026-2027'),
            'branch'         => $request->input('branch', 'JRS INTERNATIONAL SCHOOL'),
            'admission_type' => $request->input('admission_type', 'DAY SCHOLAR'),
            'grade'          => $request->input('grade'),
            'country_code'   => $request->input('country_code', '+91'),
            'parent_mobile'  => $request->input('parent_mobile'),
            'student_dob'    => $request->input('student_dob'),
            'status'         => 'pending',
            'notes'          => $request->input('notes'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your admission enquiry has been submitted successfully. Our admissions counsellor will contact you shortly.',
            'data'    => $enquiry,
        ], 201);
    }

    /**
     * Get configured enquiry form options (academic years, branches, admission types, grades, country codes).
     * GET /api/admission-enquiries/options
     */
    public function options(): JsonResponse
    {
        $hero = AdmissionHero::first();

        $defaultYears = ['2026-2027', '2027-2028'];
        $defaultTypes = ['DAY SCHOLAR', 'DAY BOARDING', 'RESIDENTIAL'];

        return response()->json([
            'success' => true,
            'data'    => [
                'academic_years'  => !empty($hero?->enquiry_academic_years) ? array_values($hero->enquiry_academic_years) : $defaultYears,
                'admission_types' => !empty($hero?->enquiry_admission_types) ? array_values($hero->enquiry_admission_types) : $defaultTypes,
            ],
        ], 200);
    }
}
