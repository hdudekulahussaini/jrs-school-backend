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
     *     description="Returns popup modal active status and image URL for the frontend modal dialog.",
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
     *                 @OA\Property(property="image_path", type="string", nullable=true, example="uploads/admission-popup/popup.jpg")
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
                'id'         => $popup->id,
                'is_active'  => (bool) $popup->is_active,
                'image_path' => $popup->image_path,
            ],
        ], 200);
    }
}
