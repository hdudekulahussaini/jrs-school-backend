<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicJourney;
use Illuminate\Http\JsonResponse;

class AcademicJourneyApiController extends Controller
{
    /**
     * Get all active academic journeys for frontend Academics page.
     */
    public function index(): JsonResponse
    {
        $journeys = AcademicJourney::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Active academic journeys fetched successfully',
            'count' => $journeys->count(),
            'total' => $journeys->count(),
            'data' => $journeys,
        ]);
    }

    /**
     * Get a specific academic journey by ID.
     */
    public function show($id): JsonResponse
    {
        $journey = AcademicJourney::find($id);

        if (!$journey) {
            return response()->json([
                'success' => false,
                'message' => 'Academic journey not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $journey,
        ]);
    }
}
