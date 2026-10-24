<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolEvent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SchoolEventApiController extends Controller
{
    /**
     * Public endpoint for frontend: GET /api/events and /api/latest-events
     */
    public function getActiveEvents(): JsonResponse
    {
        $events = SchoolEvent::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('event_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $events->count(),
            'data' => $events
        ], 200);
    }

    /**
     * REST endpoint: GET /api/events (with optional filters)
     */
    public function index(Request $request): JsonResponse
    {
        $query = SchoolEvent::query();

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        $events = $query->orderBy('sort_order', 'asc')
            ->orderBy('event_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $events->count(),
            'data' => $events
        ], 200);
    }

    /**
     * REST endpoint: GET /api/events/{id}
     */
    public function show($id): JsonResponse
    {
        $event = SchoolEvent::find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $event
        ], 200);
    }
}
