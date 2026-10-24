<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Http\Requests\AboutSectionRequest;
use Illuminate\Http\Request;
class AboutSectionController extends Controller
{
    /**
     * [READ - Index] Display the current About Section with live visual preview.
     */
    public function index()
    {
        $about = AboutSection::where('is_active', true)->first() ?? AboutSection::first();
        $allSections = AboutSection::orderBy('id', 'desc')->get();

        return view('admin.about.index', compact('about', 'allSections'));
    }

    /**
     * [CREATE - Form] Form to create new About Section content.
     */
    public function create()
    {
        return view('admin.about.create');
    }

    /**
     * [CREATE - Store] Save newly created About content.
     */
    public function store(AboutSectionRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        $uploadPath = public_path('uploads/about');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($request->hasFile('image_1_file')) {
            $file1 = $request->file('image_1_file');
            $name1 = 'students_' . time() . '.' . $file1->getClientOriginalExtension();
            $file1->move($uploadPath, $name1);
            $validated['image_1_url'] = url('uploads/about/' . $name1);
        }

        if ($request->hasFile('image_2_file')) {
            $file2 = $request->file('image_2_file');
            $name2 = 'campus_' . time() . '.' . $file2->getClientOriginalExtension();
            $file2->move($uploadPath, $name2);
            $validated['image_2_url'] = url('uploads/about/' . $name2);
        }

        unset($validated['image_1_file'], $validated['image_2_file']);

        // If marked active, make others inactive
        if ($validated['is_active']) {
            AboutSection::where('is_active', true)->update(['is_active' => false]);
        }

        AboutSection::create($validated);

        return redirect()->route('admin.about.index')
            ->with('success', 'About JRS section content saved successfully.');
    }

    /**
     * [READ - Show] View details.
     */
    public function show($id)
    {
        $about = AboutSection::findOrFail($id);
        return view('admin.about.show', compact('about'));
    }

    /**
     * [UPDATE - Form] Edit About content.
     */
    public function edit($id)
    {
        $about = AboutSection::findOrFail($id);
        return view('admin.about.edit', compact('about'));
    }

    /**
     * [UPDATE - Save] Update About content.
     */
    public function update(AboutSectionRequest $request, $id)
    {
        $about = AboutSection::findOrFail($id);
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        $uploadPath = public_path('uploads/about');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($request->hasFile('image_1_file')) {
            $file1 = $request->file('image_1_file');
            $name1 = 'students_' . time() . '.' . $file1->getClientOriginalExtension();
            $file1->move($uploadPath, $name1);
            $validated['image_1_url'] = url('uploads/about/' . $name1);
        }

        if ($request->hasFile('image_2_file')) {
            $file2 = $request->file('image_2_file');
            $name2 = 'campus_' . time() . '.' . $file2->getClientOriginalExtension();
            $file2->move($uploadPath, $name2);
            $validated['image_2_url'] = url('uploads/about/' . $name2);
        }

        unset($validated['image_1_file'], $validated['image_2_file']);

        if ($validated['is_active']) {
            AboutSection::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $about->update($validated);

        return redirect()->route('admin.about.index')
            ->with('success', 'About JRS section content updated successfully.');
    }

    /**
     * [DELETE - Destroy] Delete About content.
     */
    public function destroy($id)
    {
        $about = AboutSection::findOrFail($id);
        $about->delete();

        return redirect()->route('admin.about.index')
            ->with('success', 'About section entry deleted.');
    }
}
