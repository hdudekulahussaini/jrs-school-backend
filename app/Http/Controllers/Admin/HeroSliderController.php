<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use App\Http\Requests\HeroSliderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HeroSliderController extends Controller
{
    /**
     * [READ - Index] Hero Sliders Table List.
     */
    public function index(Request $request)
    {
        $query = HeroSlider::query();

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('primary_button_text', 'like', "%{$search}%")
                  ->orWhere('secondary_button_text', 'like', "%{$search}%");
            });
        }

        $totalCount = HeroSlider::count();
        $sliders = $query->latest('id')->paginate(10)->withQueryString();

        return view('admin.sliders.index', compact('sliders', 'totalCount'));
    }

    /**
     * [CREATE - Form] Display create form (allowed only when 0 sliders exist).
     */
    public function create()
    {
        if (HeroSlider::count() >= 1) {
            $existing = HeroSlider::first();
            flash()->warning('Maximum limit reached: Only 1 Hero Slider is allowed. You can edit the existing one or delete it first.', 'Limit Reached');
            return redirect()->route('admin.sliders.edit', $existing->id);
        }

        $slider = new HeroSlider([
            'title' => 'Empowering Minds, Shaping Future Leaders',
            'primary_button_text' => 'Admissions 2027-28',
            'secondary_button_text' => 'Take a Virtual Tour',
            'secondary_button_url' => 'https://jrs-school.vercel.app/#tour',
            'experience_badge_image' => 'images/experience-badge-38.svg',
            'is_active' => true,
        ]);

        return view('admin.sliders.create', compact('slider'));
    }

    /**
     * [CREATE - Store] Persist new hero slider record (allowed only when 0 exist).
     */
    public function store(HeroSliderRequest $request)
    {
        if (HeroSlider::count() >= 1) {
            flash()->error('Only 1 Hero Slider configuration is allowed. Please edit or delete the existing one.', 'Action Not Allowed');
            return redirect()->route('admin.sliders.index');
        }
        $validated = $request->validated();
        $validated['is_active'] = true;

        $uploadDir = public_path('uploads/hero_sliders');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        // Handle Experience Badge Upload
        if ($request->hasFile('experience_badge_image')) {
            $file = $request->file('experience_badge_image');
            $filename = 'badge_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['experience_badge_image'] = 'uploads/hero_sliders/' . $filename;
        } else {
            $validated['experience_badge_image'] = 'images/experience-badge-38.svg';
        }

        // Handle Background Images
        $currentImages = [];
        $filesToProcess = [];
        if ($request->hasFile('background_images')) {
            $filesToProcess = $request->file('background_images');
        } elseif ($request->hasFile('images')) {
            $filesToProcess = $request->file('images');
        }

        foreach ($filesToProcess as $file) {
            if ($file && $file->isValid()) {
                $filename = 'hero_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $filename);
                $currentImages[] = 'uploads/hero_sliders/' . $filename;
            }
        }

        if (empty($currentImages)) {
            $currentImages = [
                'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1920&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1920&auto=format&fit=crop',
            ];
        }

        $validated['background_images'] = array_values(array_unique(array_filter($currentImages)));
        $validated['image_path'] = $validated['background_images'][0] ?? null;

        unset(
            $validated['badge_title'],
            $validated['highlight_text'],
            $validated['description'],
            $validated['contact_phone'],
            $validated['sort_order'],
            $validated['image'],
            $validated['primary_button_url'],
            $validated['experience_badge_image_url']
        );

        $slider = HeroSlider::create($validated);

        flash()->success('Hero slider created successfully.', 'Hero Slider Created');

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Hero slider created successfully.');
    }

    /**
     * [READ - Show] Redirect to edit.
     */
    public function show($id)
    {
        $sliderId = $id instanceof HeroSlider ? $id->id : $id;
        return redirect()->route('admin.sliders.edit', $sliderId);
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $slider = $id instanceof HeroSlider ? $id : HeroSlider::findOrFail($id);

        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * [UPDATE - Save] Update the hero slider.
     */
    public function update(HeroSliderRequest $request, $id)
    {
        $slider = $id instanceof HeroSlider ? $id : HeroSlider::findOrFail($id);

        $validated = $request->validated();
        $validated['is_active'] = true;

        $uploadDir = public_path('uploads/hero_sliders');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        // Handle Experience Badge Upload or Removal
        if ($request->has('remove_badge') && $request->boolean('remove_badge')) {
            $this->deletePhysicalImage($slider->experience_badge_image);
            $validated['experience_badge_image'] = null;
        } elseif ($request->hasFile('experience_badge_image')) {
            $this->deletePhysicalImage($slider->experience_badge_image);
            $file = $request->file('experience_badge_image');
            $filename = 'badge_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['experience_badge_image'] = 'uploads/hero_sliders/' . $filename;
        }

        // Handle Background Images
        $currentImages = [];
        if ($request->has('existing_images') && is_array($request->input('existing_images'))) {
            $currentImages = array_values(array_filter($request->input('existing_images')));
        } elseif (is_array($slider->background_images)) {
            $currentImages = $slider->background_images;
        }

        $filesToProcess = [];
        if ($request->hasFile('background_images')) {
            $filesToProcess = $request->file('background_images');
        } elseif ($request->hasFile('images')) {
            $filesToProcess = $request->file('images');
        }

        foreach ($filesToProcess as $file) {
            if ($file && $file->isValid()) {
                $filename = 'hero_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $filename);
                $currentImages[] = 'uploads/hero_sliders/' . $filename;
            }
        }

        if (!empty($validated['image_url'])) {
            $currentImages[] = $validated['image_url'];
        }

        $currentImages = array_values(array_unique(array_filter($currentImages)));
        $validated['background_images'] = $currentImages;
        $validated['image_path'] = $currentImages[0] ?? null;

        unset(
            $validated['badge_title'],
            $validated['highlight_text'],
            $validated['description'],
            $validated['contact_phone'],
            $validated['sort_order'],
            $validated['image'],
            $validated['primary_button_url'],
            $validated['experience_badge_image_url']
        );

        $slider->fill($validated);
        $slider->save();

        flash()->success('Hero slider updated successfully.', 'Hero Slider Saved');

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Hero slider updated successfully.');
    }

    /**
     * [AJAX / POST] Remove a specific background photo from the slider.
     */
    public function removeImage(Request $request)
    {
        $sliderId = $request->input('slider_id');
        $slider = $sliderId ? HeroSlider::find($sliderId) : HeroSlider::first();

        if ($slider && $request->filled('image')) {
            $imageToRemove = $request->input('image');
            $images = $slider->background_images ?? [];
            $filtered = [];

            foreach ($images as $img) {
                if ($img === $imageToRemove) {
                    $this->deletePhysicalImage($img);
                } else {
                    $filtered[] = $img;
                }
            }

            $slider->background_images = array_values($filtered);
            $slider->image_path = $filtered[0] ?? null;
            $slider->save();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Background photo removed successfully.'
                ]);
            }

            flash()->success('Background photo removed successfully.');
            return redirect()->back();
        }

        return redirect()->back();
    }

    /**
     * [DELETE - Destroy] Clear images and delete hero slider record.
     */
    public function destroy($id)
    {
        $slider = $id instanceof HeroSlider ? $id : HeroSlider::findOrFail($id);

        if (is_array($slider->background_images)) {
            foreach ($slider->background_images as $path) {
                $this->deletePhysicalImage($path);
            }
        }
        $this->deletePhysicalImage($slider->experience_badge_image);
        $this->deletePhysicalImage($slider->image_path);
        $slider->delete();

        flash()->info('Hero slider deleted successfully.', 'Hero Slider Deleted');

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Hero slider deleted successfully.');
    }

    /**
     * Helper to safely remove uploaded image file from disk.
     */
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
