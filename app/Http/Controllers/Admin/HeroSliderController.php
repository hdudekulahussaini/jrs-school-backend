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
     * [READ - Index] Listing of all hero slider slides.
     */
    public function index(Request $request)
    {
        $query = HeroSlider::query();

        // Search by title, highlight text, badge or description
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('highlight_text', 'like', "%{$term}%")
                  ->orWhere('badge_title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $sliders = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $totalCount = HeroSlider::count();
        $activeCount = HeroSlider::where('is_active', true)->count();
        $inactiveCount = HeroSlider::where('is_active', false)->count();

        return view('admin.sliders.index', compact('sliders', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new hero slider.
     */
    public function create()
    {
        $nextOrder = (HeroSlider::max('sort_order') ?? 0) + 1;
        return view('admin.sliders.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Persist a newly created slider slide.
     */
    public function store(HeroSliderRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['contact_phone'] = $request->input('contact_phone', null);

        // Handle Image Upload
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

        HeroSlider::create($validated);

        flash()->success('Hero slider item created successfully.', 'Slider Created');

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Hero slider item created successfully.');
    }

    /**
     * [READ - Show] Redirect to edit form since show page is decommissioned.
     */
    public function show($id)
    {
        $slider = HeroSlider::findOrFail($id);
        return redirect()->route('admin.sliders.edit', $slider->id);
    }

    /**
     * [UPDATE - Form] Show the edit form for a slider.
     */
    public function edit($id)
    {
        $slider = HeroSlider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * [UPDATE - Save] Update the hero slide.
     */
    public function update(HeroSliderRequest $request, $id)
    {
        $slider = HeroSlider::findOrFail($id);
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');
        $validated['contact_phone'] = $request->input('contact_phone', null);

        // Check if user requested to remove image
        if ($request->has('remove_image') && $request->remove_image == '1') {
            $this->deletePhysicalImage($slider->image_path);
            $validated['image_path'] = null;
        }

        // Handle Image Replacement
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

        flash()->success('Hero slider item updated successfully.', 'Slider Updated');

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Hero slider item updated successfully.');
    }

    /**
     * [UPDATE - Toggle Active Status]
     */
    public function toggle($id)
    {
        $slider = HeroSlider::findOrFail($id);
        $slider->is_active = !$slider->is_active;
        $slider->save();

        if ($slider->is_active) {
            flash()->success('Slide status changed to Active.', 'Status Updated');
        } else {
            flash()->warning('Slide status changed to Disabled.', 'Status Inactive');
        }

        return redirect()->back()
            ->with('success', 'Slide status toggled to ' . ($slider->is_active ? 'Active' : 'Disabled') . '.');
    }

    /**
     * [DELETE - Destroy] Remove the slide.
     */
    public function destroy($id)
    {
        $slider = HeroSlider::findOrFail($id);
        $this->deletePhysicalImage($slider->image_path);
        $slider->delete();

        flash()->info('Hero slider item deleted successfully.', 'Slider Removed');

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Hero slider item deleted successfully.');
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
