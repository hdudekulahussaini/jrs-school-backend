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
    public function index(): JsonResponse
    {
        $items = CampusLife::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $data = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'icon' => $item->icon,
                'image_url' => $item->image_full_url,
                'sort_order' => $item->sort_order,
                'is_active' => (bool)$item->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'section' => [
                'eyebrow' => 'CAMPUS TOUR & LIFE AT JRS',
                'title' => 'Experience The Spirit Of JRS International School',
                'title_highlight' => 'JRS International School',
                'description' => 'Explore our state-of-the-art campus, modern facilities, and vibrant learning spaces where every student discovers their unique passions and potential.',
                'cta_primary' => [
                    'text' => 'Book a Campus Visit',
                    'url' => 'https://jrs-school.vercel.app/#tour',
                ],
                'cta_secondary' => [
                    'text' => 'Admissions 2026-27',
                    'url' => 'https://jrs-school.vercel.app/admissions',
                ],
            ],
            'count' => $data->count(),
            'data' => $data,
        ], 200);
    }
}
