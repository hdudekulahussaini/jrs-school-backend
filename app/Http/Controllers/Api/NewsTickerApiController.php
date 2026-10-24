<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsTicker;
use App\Http\Requests\NewsTickerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class NewsTickerApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/news-ticker",
     *     operationId="getActiveTickers",
     *     tags={"News Ticker (Frontend)"},
     *     summary="Get active marquee ticker announcements for React site",
     *     description="Returns all active announcements sorted by sort_order for the homepage top red marquee banner.",
     *     @OA\Response(
     *         response=200,
     *         description="List of active news tickers",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="count", type="integer", example=2),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Admissions Open for Academic Year 2026–2027"),
     *                     @OA\Property(property="badge_text", type="string", example="NEWS"),
     *                     @OA\Property(property="link_url", type="string", nullable=true, example="https://jrs-school.vercel.app/admissions"),
     *                     @OA\Property(property="sort_order", type="integer", example=1),
     *                     @OA\Property(property="is_active", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * Public endpoint for React frontend ticker: GET /api/news-ticker
     */
    public function getActiveTickers(): JsonResponse
    {

        $tickers = NewsTicker::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $tickers->count(),
            'data' => $tickers
        ], 200);
    }

    /**
     * List all tickers (CRUD): GET /api/news-tickers
     */
    public function index(Request $request): JsonResponse
    {
        $query = NewsTicker::query();

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        $tickers = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $tickers->count(),
            'data' => $tickers
        ], 200);
    }

    /**
     * Store a new ticker: POST /api/news-tickers
     */
    public function store(NewsTickerRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }
        if (!isset($validated['badge_text']) || empty($validated['badge_text'])) {
            $validated['badge_text'] = 'NEWS';
        }

        $ticker = NewsTicker::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'News ticker item created successfully',
            'data' => $ticker
        ], 201);
    }

    /**
     * Display a specific ticker: GET /api/news-tickers/{id}
     */
    public function show($id): JsonResponse
    {
        $ticker = NewsTicker::find($id);

        if (!$ticker) {
            return response()->json([
                'success' => false,
                'message' => 'News ticker item not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $ticker
        ], 200);
    }

    /**
     * Update ticker: PUT /api/news-tickers/{id}
     */
    public function update(NewsTickerRequest $request, $id): JsonResponse
    {
        $ticker = NewsTicker::find($id);

        if (!$ticker) {
            return response()->json([
                'success' => false,
                'message' => 'News ticker item not found'
            ], 404);
        }

        $validated = $request->validated();
        $ticker->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'News ticker updated successfully',
            'data' => $ticker
        ], 200);
    }

    /**
     * Toggle active state: PATCH /api/news-tickers/{id}/toggle
     */
    public function toggle($id): JsonResponse
    {
        $ticker = NewsTicker::find($id);

        if (!$ticker) {
            return response()->json([
                'success' => false,
                'message' => 'News ticker item not found'
            ], 404);
        }

        $ticker->is_active = !$ticker->is_active;
        $ticker->save();

        return response()->json([
            'success' => true,
            'message' => 'Ticker status toggled to ' . ($ticker->is_active ? 'active' : 'inactive'),
            'is_active' => $ticker->is_active,
            'data' => $ticker
        ], 200);
    }

    /**
     * Remove ticker: DELETE /api/news-tickers/{id}
     */
    public function destroy($id): JsonResponse
    {
        $ticker = NewsTicker::find($id);

        if (!$ticker) {
            return response()->json([
                'success' => false,
                'message' => 'News ticker item not found'
            ], 404);
        }

        $ticker->delete();

        return response()->json([
            'success' => true,
            'message' => 'News ticker item deleted successfully'
        ], 200);
    }
}
