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
            ->select([
                'id',
                'title',
                'age_group',
                'lead_text',
                'description',
                'highlights',
                'icon',
                'image_path',
                'sort_order',
                'is_active',
                'created_at',
                'updated_at',
            ])
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
}
