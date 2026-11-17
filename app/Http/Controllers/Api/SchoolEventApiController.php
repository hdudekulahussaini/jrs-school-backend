<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolEvent;
use Illuminate\Http\JsonResponse;

class SchoolEventApiController extends Controller
{
    /**
     * Public endpoint for frontend: GET /api/events
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
}
