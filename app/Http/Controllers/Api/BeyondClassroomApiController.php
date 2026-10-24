<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BeyondClassroom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BeyondClassroomApiController extends Controller
{
    /**
     * Public endpoint for frontend: GET /api/beyond-classrooms
     */
    public function getActiveActivities(): JsonResponse
    {
        $activities = BeyondClassroom::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $activities->count(),
            'data' => $activities
        ], 200);
    }

    /**
     * REST endpoint: GET /api/beyond-classrooms (with optional filters)
     */
    public function index(Request $request): JsonResponse
    {
        $query = BeyondClassroom::query();

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        $activities = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $activities->count(),
            'data' => $activities
        ], 200);
    }

    /**
     * REST endpoint: GET /api/beyond-classrooms/{id}
     */
    public function show($id): JsonResponse
    {
        $activity = BeyondClassroom::find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Beyond Classroom activity not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $activity
        ], 200);
    }
}
