<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdmissionEnquiryRequest;
use App\Mail\AdmissionEnquiryAdminNotification;
use App\Models\AdmissionEnquiry;
use App\Models\AdmissionHero;
use App\Models\ContactSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            'parent_mobile'  => $request->input('parent_mobile'),
            'student_dob'    => $request->input('student_dob'),
            'status'         => 'pending',
            'notes'          => $request->input('notes'),
        ]);

        // Safely dispatch admin notification email without breaking the enquiry submission
        try {
            $recipient = config('mail.admission_notification_email')
                ?: env('ADMISSION_NOTIFICATION_EMAIL')
                ?: ContactSetting::first()?->email
                ?: 'hdudekulahussaini@gmail.com';

            if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                Mail::to($recipient)->queue(new AdmissionEnquiryAdminNotification($enquiry));
            }
        } catch (\Throwable $e) {
            Log::error('Admission enquiry notification email failed: ' . $e->getMessage(), [
                'enquiry_id' => $enquiry->id,
                'exception'  => $e,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your admission enquiry has been submitted successfully. Our admissions counsellor will contact you shortly.',
            'data'    => $enquiry,
        ], 201);
    }

    /**
     * Get configured enquiry form options (academic years and admission types).
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
