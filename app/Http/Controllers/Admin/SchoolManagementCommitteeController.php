<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolManagementMember;
use App\Http\Requests\SchoolManagementMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SchoolManagementCommitteeController extends Controller
{
    /**
     * [READ - Index] Listing of School Management Committee (SMC) members.
     */
    public function index(Request $request)
    {
        $query = SchoolManagementMember::query();

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

        $totalCount = SchoolManagementMember::count();
        $designations = SchoolManagementMember::select('designation')->distinct()->pluck('designation');

        return view('admin.school-management-committee.index', compact('members', 'totalCount', 'designations'));
    }

    /**
     * [CREATE - Form] Display form to create a new committee member.
     */
    public function create()
    {
        return view('admin.school-management-committee.create');
    }

    /**
     * [CREATE - Store] Persist a new committee member.
     */
    public function store(SchoolManagementMemberRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/school-management');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'smc_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/school-management/' . $filename;
        }

        SchoolManagementMember::create($validated);

        flash()->success('School Management Committee member added successfully.', 'Member Added');

        return redirect()->route('admin.school-management-committee.index')
            ->with('success', 'School Management Committee member added successfully.');
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $member = SchoolManagementMember::findOrFail($id);
        return view('admin.school-management-committee.edit', compact('member'));
    }

    /**
     * [UPDATE - Save] Update committee member.
     */
    public function update(SchoolManagementMemberRequest $request, $id)
    {
        $member = SchoolManagementMember::findOrFail($id);
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
            $uploadDir = public_path('uploads/school-management');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'smc_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/school-management/' . $filename;
        }

        $member->update($validated);

        flash()->success('Committee member updated successfully.', 'Member Updated');

        return redirect()->route('admin.school-management-committee.index')
            ->with('success', 'Committee member updated successfully.');
    }

    /**
     * [DELETE - Destroy] Remove committee member.
     */
    public function destroy($id)
    {
        $member = SchoolManagementMember::findOrFail($id);

        if ($member->image_path && !str_starts_with($member->image_path, 'http') && File::exists(public_path($member->image_path))) {
            File::delete(public_path($member->image_path));
        }

        $member->delete();

        flash()->info('Committee member deleted successfully.', 'Member Removed');

        return redirect()->route('admin.school-management-committee.index')
            ->with('success', 'Committee member deleted successfully.');
    }
}
