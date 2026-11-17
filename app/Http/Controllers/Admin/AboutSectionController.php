<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Http\Requests\AboutSectionRequest;
use Illuminate\Http\Request;
class AboutSectionController extends Controller
{
    /**
     * [READ - Index] Display all About Section configurations in a tabular list.
     */
    public function index(Request $request)
    {
        $query = AboutSection::query();

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%")
                  ->orWhere('title_highlight', 'like', "%{$search}%")
                  ->orWhere('description_p1', 'like', "%{$search}%")
                  ->orWhere('video_title', 'like', "%{$search}%");
            });
        }

        $allSections = $query->orderBy('is_active', 'desc')->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $totalCount = AboutSection::count();
        $activeCount = AboutSection::where('is_active', true)->count();
        $inactiveCount = AboutSection::where('is_active', false)->count();
        $about = AboutSection::where('is_active', true)->first() ?? AboutSection::first();

        return view('admin.about.index', compact('about', 'allSections', 'totalCount', 'activeCount', 'inactiveCount'));
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

        flash()->success('About JRS section content saved successfully.', 'About Saved');

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

        flash()->success('About JRS section content updated successfully.', 'About Updated');

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

        flash()->info('About section entry deleted.', 'About Removed');

        return redirect()->route('admin.about.index')
            ->with('success', 'About section entry deleted.');
    }

    /**
     * [UPDATE - Toggle] Toggle active status (making active section live on homepage).
     */
    public function toggle($id)
    {
        $section = AboutSection::findOrFail($id);
        $section->is_active = !$section->is_active;

        if ($section->is_active) {
            // Only one active section allowed for homepage
            AboutSection::where('id', '!=', $id)->update(['is_active' => false]);
            $section->save();
            flash()->success('About section set as Live on homepage.', 'Section Activated');
        } else {
            $section->save();
            flash()->warning('About section set as Inactive.', 'Section Deactivated');
        }

        return redirect()->back()
            ->with('success', 'About section status updated.');
    }
}
