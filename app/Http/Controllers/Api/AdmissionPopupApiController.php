<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdmissionPopup;
use Illuminate\Http\JsonResponse;

class AdmissionPopupApiController extends Controller
{
    public function getPopup(): JsonResponse
    {
        $popup = AdmissionPopup::whereNotNull('image_path')->first();

        if (!$popup || !$popup->image_full_url) {
            return response()->json([
                'success' => false,
                'message' => 'No admission popup image is configured.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'image_url' => $popup->image_full_url,
            ],
        ], 200);
    }
}
