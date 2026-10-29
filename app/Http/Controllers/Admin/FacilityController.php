<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Http\Requests\FacilityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    /**
     * [READ - Index] Listing of all school facilities.
     */
    public function index(Request $request)
    {
        $query = Facility::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $facilities = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $totalCount = Facility::count();
        $activeCount = Facility::where('is_active', true)->count();
        $inactiveCount = Facility::where('is_active', false)->count();

        return view('admin.facilities.index', compact('facilities', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new facility.
     */
    public function create()
    {
        $nextOrder = (Facility::max('sort_order') ?? 0) + 1;
        return view('admin.facilities.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Persist a new facility.
     */
    public function store(FacilityRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->has('highlights') && is_array($request->input('highlights'))) {
            $validated['highlights'] = array_values(array_filter(array_map('trim', $request->input('highlights'))));
        } else {
            $validated['highlights'] = [];
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/facilities');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'facility_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/facilities/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            $galleryDir = public_path('uploads/facilities/gallery');
            if (!File::exists($galleryDir)) {
                File::makeDirectory($galleryDir, 0755, true);
            }
            foreach ($request->file('gallery_images') as $img) {
                $gFilename = 'gallery_' . time() . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
                $img->move($galleryDir, $gFilename);
                $galleryImages[] = 'uploads/facilities/gallery/' . $gFilename;
            }
        }
        $validated['gallery_images'] = $galleryImages;

        Facility::create($validated);

        flash()->success('Facility card created successfully.', 'Facility Created');

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Facility card created successfully.');
    }

    /**
     * [READ - Show] Display facility details (redirects to edit).
     */
    public function show($id)
    {
        $facility = Facility::findOrFail($id);
        return redirect()->route('admin.facilities.edit', $facility->id);
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $facility = Facility::findOrFail($id);
        return view('admin.facilities.edit', compact('facility'));
    }

    /**
     * [UPDATE - Save] Update the facility.
     */
    public function update(FacilityRequest $request, $id)
    {
        $facility = Facility::findOrFail($id);
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');

        if ($request->has('highlights') && is_array($request->input('highlights'))) {
            $validated['highlights'] = array_values(array_filter(array_map('trim', $request->input('highlights'))));
        } else {
            $validated['highlights'] = [];
        }

        if ($request->has('remove_image') && $request->remove_image == '1') {
            $this->deletePhysicalImage($facility->image_path);
            $validated['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            $this->deletePhysicalImage($facility->image_path);
            $file = $request->file('image');
            $uploadDir = public_path('uploads/facilities');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'facility_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/facilities/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        // Manage Gallery Images
        $existing = $request->input('existing_gallery_images', []);
        if (!is_array($existing)) {
            $existing = [];
        }
        $oldGallery = is_array($facility->gallery_images) ? $facility->gallery_images : [];
        foreach ($oldGallery as $oldImg) {
            if (!in_array($oldImg, $existing)) {
                $this->deletePhysicalImage($oldImg);
            }
        }
        $galleryImages = array_values($existing);

        if ($request->hasFile('gallery_images')) {
            $galleryDir = public_path('uploads/facilities/gallery');
            if (!File::exists($galleryDir)) {
                File::makeDirectory($galleryDir, 0755, true);
            }
            foreach ($request->file('gallery_images') as $img) {
                $gFilename = 'gallery_' . time() . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
                $img->move($galleryDir, $gFilename);
                $galleryImages[] = 'uploads/facilities/gallery/' . $gFilename;
            }
        }
        $validated['gallery_images'] = $galleryImages;

        $facility->update($validated);

        flash()->success('Facility card updated successfully.', 'Facility Updated');

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Facility card updated successfully.');
    }

    /**
     * [UPDATE - Toggle] Toggle active status.
     */
    public function toggle($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->is_active = !$facility->is_active;
        $facility->save();

        if ($facility->is_active) {
            flash()->success('Facility status changed to Active.', 'Status Updated');
        } else {
            flash()->warning('Facility status changed to Disabled.', 'Status Inactive');
        }

        return redirect()->back()
            ->with('success', 'Facility status toggled to ' . ($facility->is_active ? 'Active' : 'Disabled') . '.');
    }

    /**
     * [DELETE - Destroy] Remove facility.
     */
    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $this->deletePhysicalImage($facility->image_path);

        if (is_array($facility->gallery_images)) {
            foreach ($facility->gallery_images as $gImg) {
                $this->deletePhysicalImage($gImg);
            }
        }

        $facility->delete();

        flash()->info('Facility card deleted successfully.', 'Facility Removed');

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Facility card deleted successfully.');
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
