<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdmissionHero;
use Illuminate\Http\JsonResponse;

class AdmissionHeroApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/admission-hero or /api/admission-open
     */
    public function index(): JsonResponse
    {
        $hero = AdmissionHero::first();

        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Admission hero details not configured yet.',
            ], 404);
        }

        $defaultYears = ['2026-2027', '2027-2028'];
        $defaultTypes = ['DAY SCHOLAR', 'DAY BOARDING', 'RESIDENTIAL'];

        $enquiryForm = [
            'academic_years'  => !empty($hero->enquiry_academic_years) ? array_values($hero->enquiry_academic_years) : $defaultYears,
            'admission_types' => !empty($hero->enquiry_admission_types) ? array_values($hero->enquiry_admission_types) : $defaultTypes,
        ];

        return response()->json([
            'success' => true,
            'data'    => [
                'id'            => $hero->id,
                'location_tag'  => $hero->location_tag,
                'title'         => $hero->title,
                'academic_year' => $hero->academic_year,
                'description'   => $hero->description,
                'phone'         => $hero->phone,
                'email'         => $hero->email,
                'features'      => is_array($hero->features) ? array_values($hero->features) : [],
                'trust_badges'  => is_array($hero->trust_badges) ? array_values($hero->trust_badges) : [],
                'enquiry_form'  => $enquiryForm,
            ],
        ], 200);
    }
}
