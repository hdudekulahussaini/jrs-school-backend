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
     * Returns slides (heading, buttons, and experience badge synchronized across each rotating background photo)
     * and the parent hero object.
     */
    public function getActiveSliders(): JsonResponse
    {
        $hero = HeroSlider::first();

        if (!$hero) {
            return response()->json([
                'success' => true,
                'count' => 0,
                'data' => [],
                'hero' => null,
            ], 200);
        }

        $changed = false;
        if ($hero->title === 'Empowering' || empty($hero->title)) {
            $hero->title = 'Empowering Minds, Shaping Future Leaders';
            $changed = true;
        }
        if ($hero->primary_button_text === 'Admissions 2026-27' || empty($hero->primary_button_text)) {
            $hero->primary_button_text = 'Admissions 2027-28';
            $changed = true;
        }
        if (empty($hero->experience_badge_image)) {
            $hero->experience_badge_image = 'images/experience-badge-38.svg';
            $changed = true;
        }
        if ($changed) {
            $hero->save();
        }

        $slides = $hero->slides;

        return response()->json([
            'success' => true,
            'count' => count($slides),
            'data' => $slides,
            'hero' => [
                'id' => $hero->id,
                'title' => $hero->title,
                'primary_button_text' => $hero->primary_button_text,
                'secondary_button_text' => $hero->secondary_button_text,
                'secondary_button_url' => $hero->secondary_button_url,
                'experience_badge_image' => $hero->experience_badge_image,
                'experience_badge_image_url' => $hero->experience_badge_image_url,
                'background_images' => $hero->background_images ?? [],
                'background_images_full_urls' => $hero->background_images_full_urls,
            ],
        ], 200);
    }

    /**
     * List all slides (REST): GET /api/sliders
     */
    public function index(Request $request): JsonResponse
    {
        return $this->getActiveSliders();
    }

    /**
     * Store new hero slider or update existing: POST /api/sliders
     */
    public function store(HeroSliderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $uploadDir = public_path('uploads/hero_sliders');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        // Handle Experience Badge Upload
        if ($request->hasFile('experience_badge_image')) {
            $badgeFile = $request->file('experience_badge_image');
            $badgeName = 'badge_' . time() . '_' . Str::random(6) . '.' . $badgeFile->getClientOriginalExtension();
            $badgeFile->move($uploadDir, $badgeName);
            $validated['experience_badge_image'] = 'uploads/hero_sliders/' . $badgeName;
        }

        // Handle Background Images
        $currentImages = [];
        if ($request->has('existing_images') && is_array($request->input('existing_images'))) {
            $currentImages = array_values(array_filter($request->input('existing_images')));
        }

        if ($request->hasFile('background_images')) {
            foreach ($request->file('background_images') as $file) {
                if ($file && $file->isValid()) {
                    $filename = 'hero_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadDir, $filename);
                    $currentImages[] = 'uploads/hero_sliders/' . $filename;
                }
            }
        } elseif ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $filename = 'hero_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadDir, $filename);
                    $currentImages[] = 'uploads/hero_sliders/' . $filename;
                }
            }
        }

        if (!empty($validated['image_url'])) {
            $currentImages[] = $validated['image_url'];
        }

        $currentImages = array_values(array_unique(array_filter($currentImages)));
        $validated['background_images'] = $currentImages;
        $validated['image_path'] = $currentImages[0] ?? null;

        $hero = HeroSlider::first();
        if ($hero) {
            $hero->update($validated);
        } else {
            $hero = HeroSlider::create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Hero slider saved successfully',
            'data' => $hero->slides,
            'hero' => $hero,
        ], 201);
    }

    /**
     * Display a specific slider: GET /api/sliders/{id}
     */
    public function show($id): JsonResponse
    {
        $hero = is_numeric($id) ? HeroSlider::find($id) : null;
        if (!$hero) {
            $hero = HeroSlider::first();
        }

        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Hero slider slide not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $hero,
            'slides' => $hero->slides,
        ], 200);
    }

    /**
     * Update slider: PUT/POST /api/sliders/{id}
     */
    public function update(HeroSliderRequest $request, $id): JsonResponse
    {
        return $this->store($request);
    }

    /**
     * Remove slider: DELETE /api/sliders/{id}
     */
    public function destroy($id): JsonResponse
    {
        $hero = HeroSlider::find($id) ?? HeroSlider::first();

        if (!$hero) {
            return response()->json([
                'success' => false,
                'message' => 'Hero slider slide not found'
            ], 404);
        }

        if (is_array($hero->background_images)) {
            foreach ($hero->background_images as $path) {
                $this->deletePhysicalImage($path);
            }
        }
        $this->deletePhysicalImage($hero->experience_badge_image);
        $this->deletePhysicalImage($hero->image_path);
        $hero->delete();

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
