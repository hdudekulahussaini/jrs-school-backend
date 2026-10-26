<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CareerSectionController extends Controller
{
    /**
     * Display a listing of Career section overviews.
     */
    public function index()
    {
        $sections = CareerSection::orderBy('id', 'desc')->paginate(10);
        $activeSection = CareerSection::where('is_active', true)->first();
        $totalCount = CareerSection::count();

        return view('admin.careers.teaching.index', compact('sections', 'activeSection', 'totalCount'));
    }

    /**
     * Show the form for creating a new section.
     */
    public function create()
    {
        return view('admin.careers.teaching.create');
    }

    /**
     * Store a newly created section.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(CareerSection::validationRules());
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'career_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/careers'), $filename);
            $validated['image_path'] = '/uploads/careers/' . $filename;
        } else {
            $validated['image_path'] = '/images/careers/teaching-at-jrs.png';
        }

        unset($validated['image_file']);

        if ($validated['is_active']) {
            CareerSection::where('is_active', true)->update(['is_active' => false]);
        }

        CareerSection::create($validated);

        return redirect()->route('admin.careers-teaching.index')
            ->with('success', 'Teaching at JRS section created successfully.');
    }

    /**
     * Display the specified section.
     */
    public function show($id)
    {
        $section = CareerSection::findOrFail($id);
        return view('admin.careers.teaching.show', compact('section'));
    }

    /**
     * Show the form for editing the specified section.
     */
    public function edit($id)
    {
        $section = CareerSection::findOrFail($id);
        return view('admin.careers.teaching.edit', compact('section'));
    }

    /**
     * Update the specified section.
     */
    public function update(Request $request, $id)
    {
        $section = CareerSection::findOrFail($id);
        $validated = $request->validate(CareerSection::validationRules());
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : false;

        if ($request->hasFile('image_file')) {
            if ($section->image_path && str_starts_with($section->image_path, '/uploads/')) {
                $oldPath = public_path(ltrim($section->image_path, '/'));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('image_file');
            $filename = 'career_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/careers'), $filename);
            $validated['image_path'] = '/uploads/careers/' . $filename;
        }

        unset($validated['image_file']);

        if ($validated['is_active']) {
            CareerSection::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $section->update($validated);

        return redirect()->route('admin.careers-teaching.index')
            ->with('success', 'Teaching at JRS section updated successfully.');
    }

    /**
     * Remove the specified section.
     */
    public function destroy($id)
    {
        $section = CareerSection::findOrFail($id);

        if ($section->image_path && str_starts_with($section->image_path, '/uploads/')) {
            $oldPath = public_path(ltrim($section->image_path, '/'));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $section->delete();

        return redirect()->route('admin.careers-teaching.index')
            ->with('success', 'Teaching at JRS section deleted.');
    }

    /**
     * Toggle active status.
     */
    public function toggle($id)
    {
        $section = CareerSection::findOrFail($id);
        $newStatus = !$section->is_active;

        if ($newStatus) {
            CareerSection::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $section->is_active = $newStatus;
        $section->save();

        return response()->json([
            'success' => true,
            'is_active' => $section->is_active,
            'message' => 'Status updated successfully'
        ]);
    }
}
