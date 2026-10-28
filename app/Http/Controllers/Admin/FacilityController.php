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
        $validated['theme_color'] = $request->input('theme_color', 'navy');

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

        Facility::create($validated);

        flash()->success('Facility card created successfully.', 'Facility Created');

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Facility card created successfully.');
    }

    /**
     * [READ - Show] Display facility details.
     */
    public function show($id)
    {
        $facility = Facility::findOrFail($id);
        return view('admin.facilities.show', compact('facility'));
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
        $validated['theme_color'] = $request->input('theme_color', 'navy');

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
