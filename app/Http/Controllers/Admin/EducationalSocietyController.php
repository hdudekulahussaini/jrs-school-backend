<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationalSocietyMember;
use App\Http\Requests\EducationalSocietyMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EducationalSocietyController extends Controller
{
    /**
     * [READ - Index] Listing of Educational Society Managing Committee members.
     */
    public function index(Request $request)
    {
        $query = EducationalSocietyMember::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('designation', 'like', "%{$term}%")
                  ->orWhere('address', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%");
            });
        }

        if ($request->filled('designation')) {
            $query->where('designation', $request->designation);
        }

        $members = $query->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalCount = EducationalSocietyMember::count();
        $designations = EducationalSocietyMember::select('designation')->distinct()->pluck('designation');

        return view('admin.educational-society.index', compact('members', 'totalCount', 'designations'));
    }

    /**
     * [CREATE - Form] Display form to create a new committee member.
     */
    public function create()
    {
        return view('admin.educational-society.create');
    }

    /**
     * [CREATE - Store] Persist a new committee member.
     */
    public function store(EducationalSocietyMemberRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/educational-society');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'society_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/educational-society/' . $filename;
        }

        EducationalSocietyMember::create($validated);

        return redirect()->route('admin.educational-society.index')
            ->with('success', 'Committee member added successfully.');
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $member = EducationalSocietyMember::findOrFail($id);
        return view('admin.educational-society.edit', compact('member'));
    }

    /**
     * [UPDATE - Save] Update committee member.
     */
    public function update(EducationalSocietyMemberRequest $request, $id)
    {
        $member = EducationalSocietyMember::findOrFail($id);
        $validated = $request->validated();

        // Handle image removal
        if ($request->boolean('remove_image')) {
            if ($member->image_path && !str_starts_with($member->image_path, 'http') && File::exists(public_path($member->image_path))) {
                File::delete(public_path($member->image_path));
            }
            $validated['image_path'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            if ($member->image_path && !str_starts_with($member->image_path, 'http') && File::exists(public_path($member->image_path))) {
                File::delete(public_path($member->image_path));
            }

            $file = $request->file('image');
            $uploadDir = public_path('uploads/educational-society');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'society_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/educational-society/' . $filename;
        }

        $member->update($validated);

        return redirect()->route('admin.educational-society.index')
            ->with('success', 'Committee member updated successfully.');
    }

    /**
     * [DELETE - Destroy] Remove committee member.
     */
    public function destroy($id)
    {
        $member = EducationalSocietyMember::findOrFail($id);

        if ($member->image_path && !str_starts_with($member->image_path, 'http') && File::exists(public_path($member->image_path))) {
            File::delete(public_path($member->image_path));
        }

        $member->delete();

        return redirect()->route('admin.educational-society.index')
            ->with('success', 'Committee member deleted successfully.');
    }
}
