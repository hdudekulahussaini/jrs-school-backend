<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdmissionBanner;
use Illuminate\Http\JsonResponse;

class AdmissionBannerApiController extends Controller
{
    /**
     * Public GET endpoint: /api/admission-banner
     * Returns the active Admission Banner for the frontend.
     */
    public function index(): JsonResponse
    {
        $banner = AdmissionBanner::where('is_active', true)->first() ?? AdmissionBanner::first();

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'No active Admission Banner section found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $banner->id,
                'title' => $banner->title,
                'title_highlight' => $banner->title_highlight,
                'description' => $banner->description,
                'image_path' => $banner->image_path,
                'image_url' => $banner->image_full_url,
                'is_active' => (bool)$banner->is_active,
                'updated_at' => $banner->updated_at,
            ],
        ], 200);
    }
}
