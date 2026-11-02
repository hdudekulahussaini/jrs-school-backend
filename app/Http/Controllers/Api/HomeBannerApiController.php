<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\JsonResponse;

class HomeBannerApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/home-banner",
     *     summary="Get Home Page Banner Image",
     *     description="Returns the promotional banner image for the home page (e.g. IIT | JEE | NEET / Olympiad banner).",
     *     tags={"Home Page"},
     *     @OA\Response(
     *         response=200,
     *         description="Home banner image details",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 nullable=true,
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="image_path", type="string", example="uploads/home_banners/home_banner_iit_jee_neet.png"),
     *                 @OA\Property(property="image_full_url", type="string", example="http://127.0.0.1:8000/uploads/home_banners/home_banner_iit_jee_neet.png"),
     *                 @OA\Property(property="updated_at", type="string", example="2026-11-02T12:00:00.000000Z")
     *             )
     *         )
     *     )
     * )
     */
    public function getBanner(): JsonResponse
    {
        HomeBanner::ensureTableExists();

        $banner = HomeBanner::first();

        return response()->json([
            'success' => true,
            'data' => $banner ? [
                'id' => $banner->id,
                'image_path' => $banner->image_path,
                'image_full_url' => $banner->image_full_url,
                'updated_at' => $banner->updated_at,
            ] : null,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/home-banners",
     *     summary="List Home Page Banners",
     *     tags={"Home Page"},
     *     @OA\Response(
     *         response=200,
     *         description="List of home page banners",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        HomeBanner::ensureTableExists();

        $banner = HomeBanner::first();

        return response()->json([
            'success' => true,
            'data' => $banner ? [
                [
                    'id' => $banner->id,
                    'image_path' => $banner->image_path,
                    'image_full_url' => $banner->image_full_url,
                    'updated_at' => $banner->updated_at,
                ]
            ] : [],
        ], 200);
    }
}
