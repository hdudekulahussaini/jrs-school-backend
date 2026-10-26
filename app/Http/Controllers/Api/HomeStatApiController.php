<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeStat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HomeStatApiController extends Controller
{
    /**
     * Public endpoint for frontend: GET /api/stats and /api/home-stats
     */
    public function getActiveStats(): JsonResponse
    {
        $stats = HomeStat::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $stats->count(),
            'data' => $stats
        ], 200);
    }

    /**
     * REST endpoint: GET /api/stats (with optional filters: ?active=true/false)
     */
    public function index(Request $request): JsonResponse
    {
        $query = HomeStat::query();

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        $stats = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $stats->count(),
            'data' => $stats
        ], 200);
    }

    /**
     * REST endpoint: GET /api/stats/{id}
     */
    public function show($id): JsonResponse
    {
        $stat = HomeStat::find($id);

        if (!$stat) {
            return response()->json([
                'success' => false,
                'message' => 'Stat card not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $stat
        ], 200);
    }
}
