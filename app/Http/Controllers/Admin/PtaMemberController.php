<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PtaMember;
use App\Http\Requests\PtaMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PtaMemberController extends Controller
{
    /**
     * [READ - Index] Listing of PTA committee members.
     */
    public function index(Request $request)
    {
        $query = PtaMember::query();

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

        $members = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalCount = PtaMember::count();

        return view('admin.pta-members.index', compact('members', 'totalCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new member.
     */
    public function create()
    {
        $nextOrder = (PtaMember::max('sort_order') ?? 0) + 1;
        return view('admin.pta-members.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Persist a new member.
     */
    public function store(PtaMemberRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = true;
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/pta');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'pta_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/pta/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        PtaMember::create($validated);

        flash()->success('PTA Member added successfully.', 'Member Added');

        return redirect()->route('admin.pta-members.index')
            ->with('success', 'PTA Member added successfully.');
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $member = PtaMember::findOrFail($id);
        return view('admin.pta-members.edit', compact('member'));
    }

    /**
     * [UPDATE - Save] Update member.
     */
    public function update(PtaMemberRequest $request, $id)
    {
        $member = PtaMember::findOrFail($id);
        $validated = $request->validated();
        $validated['is_active'] = true;
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            if ($member->image_path && !str_starts_with($member->image_path, 'http') && File::exists(public_path($member->image_path))) {
                File::delete(public_path($member->image_path));
            }

            $file = $request->file('image');
            $uploadDir = public_path('uploads/pta');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'pta_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/pta/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        $member->update($validated);

        flash()->success('PTA Member updated successfully.', 'Member Updated');

        return redirect()->route('admin.pta-members.index')
            ->with('success', 'PTA Member updated successfully.');
    }

    /**
     * [DELETE - Destroy] Remove member.
     */
    public function destroy($id)
    {
        $member = PtaMember::findOrFail($id);

        if ($member->image_path && !str_starts_with($member->image_path, 'http') && File::exists(public_path($member->image_path))) {
            File::delete(public_path($member->image_path));
        }

        $member->delete();

        flash()->info('PTA Member deleted successfully.', 'Member Removed');

        return redirect()->route('admin.pta-members.index')
            ->with('success', 'PTA Member deleted successfully.');
    }
}
