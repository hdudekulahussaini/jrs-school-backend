<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CampusLife;
use Illuminate\Http\JsonResponse;

class CampusLifeApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/campus-tour",
     *     summary="Get active Campus Tour & Life cards",
     *     description="Returns active campus cards and section details. Cards include their title, icon, full image URL, sort order, and active state.",
     *     tags={"Campus Tour & Life (Frontend)"},
     *     @OA\Response(
     *         response=200,
     *         description="Campus tour cards retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="section", type="object"),
     *             @OA\Property(property="count", type="integer", example=1),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Eco-Friendly Campus"),
     *                     @OA\Property(property="icon", type="string", nullable=true, example="bi bi-tree-fill"),
     *                     @OA\Property(property="image_url", type="string", nullable=true, example="https://example.test/campus.jpg"),
     *                     @OA\Property(property="sort_order", type="integer", example=1),
     *                     @OA\Property(property="is_active", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Get(
     *     path="/campus-life",
     *     summary="Alias endpoint for /campus-tour",
     *     tags={"Campus Tour & Life (Frontend)"},
     *     @OA\Response(
     *         response=200,
     *         description="Campus tour cards retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="section", type="object"),
     *             @OA\Property(property="count", type="integer", example=1),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Eco-Friendly Campus"),
     *                     @OA\Property(property="icon", type="string", nullable=true, example="bi bi-tree-fill"),
     *                     @OA\Property(property="image_url", type="string", nullable=true, example="https://example.test/campus.jpg"),
     *                     @OA\Property(property="sort_order", type="integer", example=1),
     *                     @OA\Property(property="is_active", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    /**
     * Get active Campus Tour & Life cards for frontend.
     */
    public function index(): JsonResponse
    {
        $cards = CampusLife::where('is_active', true)
            ->select([
                'id',
                'title',
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
            'message' => 'Active campus tour cards fetched successfully',
            'count' => $cards->count(),
            'total' => $cards->count(),
            'data' => $cards,
        ], 200);
    }
}
