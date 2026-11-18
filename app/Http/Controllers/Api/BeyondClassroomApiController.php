<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BeyondClassroom;
use App\Models\BeyondClassroomCta;
use Illuminate\Http\JsonResponse;

class BeyondClassroomApiController extends Controller
{
    /**
     * Public endpoint for frontend: GET /api/beyond-classrooms
     * Returns only the fields configured in the Admin Dashboard.
     */
    public function getActiveActivities(): JsonResponse
    {
        $activities = BeyondClassroom::select([
            'id',
            'title',
            'category',
            'icon',
            'image_path',
            'sort_order',
            'is_active',
            'created_at',
            'updated_at',
        ])
        ->where('is_active', true)
        ->orderBy('sort_order', 'asc')
        ->orderBy('id', 'asc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Active Beyond Classroom activities fetched successfully',
            'count' => $activities->count(),
            'total' => $activities->count(),
            'data' => $activities
        ], 200);
    }

    /**
     * Dedicated endpoint for Beyond Classroom CTA Banner: GET /api/beyond-classroom-cta
     * Returns only the fields configured in the Admin Dashboard.
     */
    public function getCta(): JsonResponse
    {
        $cta = BeyondClassroomCta::select([
            'id',
            'badge',
            'title',
            'highlight_text',
            'description',
            'image_path',
            'is_active',
            'created_at',
            'updated_at',
        ])
        ->where('is_active', true)
        ->first();

        if (!$cta) {
            return response()->json([
                'success' => false,
                'message' => 'No active Beyond Classroom CTA found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Beyond Classroom CTA retrieved successfully',
            'data' => $cta
        ], 200);
    }
}
