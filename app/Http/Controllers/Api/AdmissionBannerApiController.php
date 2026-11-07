<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdmissionBanner;
use Illuminate\Http\JsonResponse;

class AdmissionBannerApiController extends Controller
{
    /**
     * Public GET endpoint returning the active Admission Banner content.
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
                'image_url' => $banner->image_full_url,
                'updated_at' => $banner->updated_at,
            ],
        ], 200);
    }
}
