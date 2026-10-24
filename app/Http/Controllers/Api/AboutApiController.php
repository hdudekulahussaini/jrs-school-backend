<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class AboutApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/about
     */
    public function getAbout(): JsonResponse
    {

        $about = AboutSection::where('is_active', true)->first() ?? AboutSection::latest()->first();

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
