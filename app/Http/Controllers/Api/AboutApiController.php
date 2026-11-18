<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\JsonResponse;

class AboutApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/about
     */
    public function getAbout(): JsonResponse
    {
        $about = AboutSection::where('is_active', true)
            ->select([
                'id',
                'tagline',
                'title',
                'title_highlight',
                'description_p1',
                'description_p2',
                'image_1_url',
                'image_2_url',
                'video_title',
                'video_url',
                'is_active',
                'created_at',
                'updated_at',
            ])
            ->first();

        if (!$about) {
            return response()->json([
                'success' => false,
                'message' => 'No active About section content found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $about
        ], 200);
    }
}
