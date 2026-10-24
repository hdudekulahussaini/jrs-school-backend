<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class AboutApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/about",
     *     operationId="getAboutSection",
     *     tags={"About JRS (Frontend)"},
     *     summary="Get active About JRS School section content",
     *     description="Returns the active About section including tagline, headline, descriptions, badges, image URLs, and campus video tour link.",
     *     @OA\Response(
     *         response=200,
     *         description="Active About section retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="tagline", type="string", example="NURTURING FUTURE LEADERS SINCE 2010"),
     *                 @OA\Property(property="title", type="string", example="Welcome to JRS International School"),
     *                 @OA\Property(property="title_highlight", type="string", nullable=true, example="Where Excellence Meets Character"),
     *                 @OA\Property(property="description_p1", type="string", example="JRS International School is committed to delivering world-class holistic education..."),
     *                 @OA\Property(property="description_p2", type="string", nullable=true, example="Our campus features modern smart classrooms..."),
     *                 @OA\Property(property="button_text", type="string", nullable=true, example="Discover Campus Life"),
     *                 @OA\Property(property="button_link", type="string", nullable=true, example="https://jrs-school.vercel.app/about"),
     *                 @OA\Property(property="image_1_url", type="string", nullable=true, example="http://127.0.0.1:8000/uploads/about/campus_1.jpg"),
     *                 @OA\Property(property="image_2_url", type="string", nullable=true, example="http://127.0.0.1:8000/uploads/about/students_1.jpg"),
     *                 @OA\Property(property="video_title", type="string", nullable=true, example="Campus Tour & Life at JRS"),
     *                 @OA\Property(property="video_url", type="string", nullable=true, example="https://www.youtube.com/watch?v=dQw4w9WgXcQ"),
     *                 @OA\Property(property="is_active", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No active About section found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No active About section content found"),
     *             @OA\Property(property="data", type="null", example=null)
     *         )
     *     )
     * )
     *
     * Public GET endpoint for React frontend: GET /api/about
     */
    public function getAbout(): JsonResponse
    {

        $about = AboutSection::where('is_active', true)->first() ?? AboutSection::latest()->first();

        if (!$about) {
            return response()->json([
                'success' => false,
                'message' => 'No active About section content found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $about
        ], 200);
    }
}
