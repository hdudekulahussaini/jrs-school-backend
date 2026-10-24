<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampusLife;
use App\Http\Requests\CampusLifeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CampusLifeController extends Controller
{
    /**
     * [READ - Index] Listing of Campus Tour & Life cards.
     */
    public function index(Request $request)
    {
        $query = CampusLife::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('subtitle', 'like', "%{$term}%");
            });
        }

        $items = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalCount = CampusLife::count();

        return view('admin.campus-life.index', compact('items', 'totalCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new card.
     */
    public function create()
    {
        $nextOrder = (CampusLife::max('sort_order') ?? 0) + 1;
        return view('admin.campus-life.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Persist a new card.
     */
    public function store(CampusLifeRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = true;
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/campus-life');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'campus_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/campus-life/' . $filename;
        }

        CampusLife::create($validated);

        return redirect()->route('admin.campus-life.index')
            ->with('success', 'Campus Tour & Life card created successfully.');
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $item = CampusLife::findOrFail($id);
        return view('admin.campus-life.edit', compact('item'));
    }

    /**
     * [UPDATE - Save] Update card.
     */
    public function update(CampusLifeRequest $request, $id)
    {
        $item = CampusLife::findOrFail($id);
        $validated = $request->validated();
        $validated['is_active'] = true;
        $validated['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            if ($item->image_path && !str_starts_with($item->image_path, 'http') && File::exists(public_path($item->image_path))) {
                File::delete(public_path($item->image_path));
            }

            $file = $request->file('image');
            $uploadDir = public_path('uploads/campus-life');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'campus_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/campus-life/' . $filename;
        }

        $item->update($validated);

        return redirect()->route('admin.campus-life.index')
            ->with('success', 'Campus Tour & Life card updated successfully.');
    }

    /**
     * [DELETE - Destroy] Remove card.
     */
    public function destroy($id)
    {
        $item = CampusLife::findOrFail($id);

        if ($item->image_path && !str_starts_with($item->image_path, 'http') && File::exists(public_path($item->image_path))) {
            File::delete(public_path($item->image_path));
        }

        $item->delete();

        return redirect()->route('admin.campus-life.index')
            ->with('success', 'Campus Tour & Life card deleted successfully.');
    }
}
