<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class SwaggerApiController extends Controller
{
    /**
     * Return OpenAPI 3.0 specification as JSON for Swagger UI and external clients.
     */
    public function json(): JsonResponse
    {
        $path = public_path('swagger.json');
        if (!File::exists($path)) {
            $path = storage_path('api-docs/api-docs.json');
        }

        if (File::exists($path)) {
            $json = json_decode(File::get($path), true);
            return response()->json($json, 200, [
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'OpenAPI Swagger specification file not found.'
        ], 404);
    }
}
