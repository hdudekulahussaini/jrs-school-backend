<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use App\Http\Requests\HeroSliderRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HeroSliderApiController extends Controller
{
    /**
     * Public endpoint for React frontend: GET /api/hero-sliders or /api/hero-slider
     */
    public function getActiveSliders(): JsonResponse
    {
        $sliders = HeroSlider::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $sliders->count(),
            'data' => $sliders
        ], 200);
    }

    /**
     * List all sliders (REST): GET /api/sliders
     */
    public function index(Request $request): JsonResponse
    {
        $query = HeroSlider::query();

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        $sliders = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $sliders->count(),
            'data' => $sliders
        ], 200);
    }

    /**
     * Store new slider: POST /api/sliders
     */
    public function store(HeroSliderRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/hero_sliders');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'slider_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/hero_sliders/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        $slider = HeroSlider::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hero slider created successfully',
            'data' => $slider
        ], 201);
    }

    /**
     * Display a specific slider: GET /api/sliders/{id}
     */
    public function show($id): JsonResponse
    {
        $slider = HeroSlider::find($id);

        if (!$slider) {
            return response()->json([
                'success' => false,
                'message' => 'Hero slider slide not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $slider
        ], 200);
    }

    /**
     * Update slider: PUT/POST /api/sliders/{id}
     */
    public function update(HeroSliderRequest $request, $id): JsonResponse
    {
        $slider = HeroSlider::find($id);

        if (!$slider) {
            return response()->json([
                'success' => false,
                'message' => 'Hero slider slide not found'
            ], 404);
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->deletePhysicalImage($slider->image_path);
            $file = $request->file('image');
            $uploadDir = public_path('uploads/hero_sliders');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'slider_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/hero_sliders/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        $slider->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hero slider updated successfully',
            'data' => $slider
        ], 200);
    }

    /**
     * Toggle active state: PATCH /api/sliders/{id}/toggle
     */
    public function toggle($id): JsonResponse
    {
        $slider = HeroSlider::find($id);

        if (!$slider) {
            return response()->json([
                'success' => false,
                'message' => 'Hero slider slide not found'
            ], 404);
        }

        $slider->is_active = !$slider->is_active;
        $slider->save();

        return response()->json([
            'success' => true,
            'message' => 'Slide status toggled to ' . ($slider->is_active ? 'active' : 'inactive'),
            'is_active' => $slider->is_active,
            'data' => $slider
        ], 200);
    }

    /**
     * Remove slider: DELETE /api/sliders/{id}
     */
    public function destroy($id): JsonResponse
    {
        $slider = HeroSlider::find($id);

        if (!$slider) {
            return response()->json([
                'success' => false,
                'message' => 'Hero slider slide not found'
            ], 404);
        }

        $this->deletePhysicalImage($slider->image_path);
        $slider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hero slider slide deleted successfully'
        ], 200);
    }

    private function deletePhysicalImage(?string $path): void
    {
        if (!empty($path) && !str_starts_with($path, 'http://') && !str_starts_with($path, 'https://')) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }
}
