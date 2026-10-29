<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdmissionPopup;
use Illuminate\Http\JsonResponse;

class AdmissionPopupApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admission-popup",
     *     summary="Get Admission Promotional Popup modal configuration",
     *     description="Returns popup modal active status, background image, badges, affiliation text, academic year highlight, description, green checklist features, and call action buttons for the frontend modal dialog.",
     *     tags={"Admissions (Frontend)"},
     *     @OA\Response(
     *         response=200,
     *         description="Admission popup modal configuration retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="image_url", type="string", example="http://127.0.0.1:8000/uploads/admission-popup/popup.jpg"),
     *                 @OA\Property(property="badge_text", type="string", example="ADMISSIONS OPEN"),
     *                 @OA\Property(property="cbse_affiliation_text", type="string", example="CBSE AFFILIATION: 3630478 • SCHOOL CODE: 56725"),
     *                 @OA\Property(property="school_name", type="string", example="JRS International School"),
     *                 @OA\Property(property="school_location", type="string", example="Narapally, Near Uppal, Hyderabad"),
     *                 @OA\Property(property="academic_year_badge", type="string", example="Academic Year 2027 – 2028"),
     *                 @OA\Property(property="title_prefix", type="string", example="Admissions Open For"),
     *                 @OA\Property(property="academic_year_highlight", type="string", example="2027 – 2028"),
     *                 @OA\Property(property="description", type="string", example="Enrolling students from Nursery to Grade XII..."),
     *                 @OA\Property(property="features", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="phone_number", type="string", example="+91 92814 09674"),
     *                 @OA\Property(
     *                     property="primary_button",
     *                     type="object",
     *                     @OA\Property(property="text", type="string", example="Enquire / Apply Online")
     *                 ),
     *                 @OA\Property(
     *                     property="secondary_button",
     *                     type="object",
     *                     @OA\Property(property="text", type="string", example="Call: +91 92814 09674"),
     *                     @OA\Property(property="phone", type="string", example="+91 92814 09674")
     *                 ),
     *                 @OA\Property(property="updated_at", type="string", example="2026-10-29T16:40:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Admission popup not configured"
     *     )
     * )
     *
     * Public GET endpoint: /api/admission-popup (Alias: /api/popup)
     * Returns the Admission Popup modal configuration for the frontend.
     */
    public function getPopup(): JsonResponse
    {
        $popup = AdmissionPopup::first();

        if (!$popup) {
            return response()->json([
                'success' => false,
                'message' => 'Admission popup not configured.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id'                      => $popup->id,
                'is_active'               => (bool) $popup->is_active,
                'image_url'               => $popup->image_full_url,
                'badge_text'              => $popup->badge_text,
                'cbse_affiliation_text'   => $popup->cbse_affiliation_text,
                'school_name'             => $popup->school_name,
                'school_location'         => $popup->school_location,
                'academic_year_badge'     => $popup->academic_year_badge,
                'title_prefix'            => $popup->title_prefix,
                'academic_year_highlight' => $popup->academic_year_highlight,
                'description'             => $popup->description,
                'features'                => $popup->features ?? [],
                'phone_number'            => $popup->phone_number,
                'primary_button'          => [
                    'text' => 'Enquire / Apply Online',
                ],
                'secondary_button'        => [
                    'text'  => 'Call: ' . $popup->phone_number,
                    'phone' => $popup->phone_number,
                ],
                'updated_at'              => $popup->updated_at,
            ],
        ], 200);
    }
}
