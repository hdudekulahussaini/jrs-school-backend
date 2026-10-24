<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeFeature;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HomeFeatureApiController extends Controller
{
    /**
     * Public endpoint for frontend: GET /api/features and /api/home-features
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

    /**
     * REST endpoint: GET /api/features (with optional filters)
     */
    public function index(Request $request): JsonResponse
    {
        $query = HomeFeature::query();

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        $features = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $features->count(),
            'data' => $features
        ], 200);
    }

    /**
     * REST endpoint: GET /api/features/{id}
     */
    public function show($id): JsonResponse
    {
        $feature = HomeFeature::find($id);

        if (!$feature) {
            return response()->json([
                'success' => false,
                'message' => 'Feature card not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $feature
        ], 200);
    }
}
