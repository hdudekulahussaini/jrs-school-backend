<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BeyondClassroom;
use App\Models\BeyondClassroomCta;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BeyondClassroomApiController extends Controller
{
    /**
     * Public endpoint for frontend: GET /api/beyond-classrooms and /api/beyond
     */
    public function getActiveActivities(): JsonResponse
    {
        $activities = BeyondClassroom::where('is_active', true)
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
     * Dedicated endpoint for Beyond Classroom Page: GET /api/beyond-classroom-page
     */
    public function getPageData(): JsonResponse
    {
        $activities = BeyondClassroom::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $cta = BeyondClassroomCta::where('is_active', true)->first();

        return response()->json([
            'success' => true,
            'message' => 'Beyond Classroom page data fetched successfully',
            'page' => [
                'title' => 'Beyond Classroom',
                'badge' => 'Holistic Student Development',
                'description' => 'Beyond academics, JRS International School nurtures every student’s potential through a rich spectrum of co-curricular pursuits including arts, performing arts, sports, science projects, and leadership clubs.'
            ],
            'count' => $activities->count(),
            'total' => $activities->count(),
            'cta' => $cta,
            'data' => $activities
        ], 200);
    }

    /**
     * Dedicated endpoint for Beyond Classroom CTA Banner: GET /api/beyond-classroom-cta
     */
    public function getCta(): JsonResponse
    {
        $cta = BeyondClassroomCta::where('is_active', true)->first();

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

    /**
     * REST endpoint: GET /api/beyond-classrooms (with optional filters)
     */
    public function index(Request $request): JsonResponse
    {
        $query = BeyondClassroom::query();

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('category')) {
            $query->where('category', 'like', "%{$request->category}%");
        }

        $activities = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $activities->count(),
            'total' => $activities->count(),
            'data' => $activities
        ], 200);
    }

    /**
     * REST endpoint: GET /api/beyond-classrooms/{id}
     */
    public function show($id): JsonResponse
    {
        $activity = is_numeric($id) 
            ? BeyondClassroom::find($id) 
            : BeyondClassroom::where('title', 'like', str_replace('-', ' ', $id))->first();

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
