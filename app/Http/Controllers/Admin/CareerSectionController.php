<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CareerSectionController extends Controller
{
    /**
     * Display the Teaching at JRS section.
     */
    public function index()
    {
        $sections = CareerSection::orderBy('id', 'desc')->paginate(10);
        $totalCount = CareerSection::count();

        return view('admin.careers.teaching.index', compact('sections', 'totalCount'));
    }

    /**
     * Show the form for creating — only allowed when no record exists yet.
     */
    public function create()
    {
        if (CareerSection::count() > 0) {
            flash()->warning('Only one Teaching at JRS section is allowed. Edit the existing one.', 'Already Exists');
            return redirect()->route('admin.careers-teaching.index');
        }

        return view('admin.careers.teaching.create');
    }

    /**
     * Store a newly created section — only allowed when table is empty.
     */
    public function store(Request $request)
    {
        if (CareerSection::count() > 0) {
            flash()->warning('Only one Teaching at JRS section is allowed. Edit the existing one.', 'Already Exists');
            return redirect()->route('admin.careers-teaching.index');
        }

        $validated = $request->validate(CareerSection::validationRules());

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'career_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/careers'), $filename);
            $validated['image_path'] = '/uploads/careers/' . $filename;
        } else {
            $validated['image_path'] = '/images/careers/teaching-at-jrs.png';
        }

        unset($validated['image_file']);

        CareerSection::create($validated);

        flash()->success('Teaching at JRS section created successfully.', 'Section Created');

        return redirect()->route('admin.careers-teaching.index')
            ->with('success', 'Teaching at JRS section created successfully.');
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

        $section->update($validated);

        flash()->success('Teaching at JRS section updated successfully.', 'Section Updated');

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

        flash()->info('Teaching at JRS section deleted.', 'Section Removed');

        return redirect()->route('admin.careers-teaching.index')
            ->with('success', 'Teaching at JRS section deleted.');
    }
}
