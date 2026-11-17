<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeFeature;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HomeFeatureApiController extends Controller
{
    /**
     * Public endpoint for frontend: GET /api/features
     */
    public function getActiveFeatures(): JsonResponse
    {
        $features = HomeFeature::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $features->count(),
            'data' => $features
        ], 200);
    }
}
