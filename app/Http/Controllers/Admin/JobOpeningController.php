<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOpening;
use Illuminate\Http\Request;

class JobOpeningController extends Controller
{
    public function index(Request $request)
    {
        $query = JobOpening::query();

        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('department', 'like', "%{$s}%")
                  ->orWhere('qualification', 'like', "%{$s}%");
            });
        }

        $openings = $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->paginate(10);
        $totalCount = JobOpening::count();
        $activeCount = JobOpening::where('is_active', true)->count();
        $inactiveCount = JobOpening::where('is_active', false)->count();

        return view('admin.careers.openings.index', compact('openings', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    public function create()
    {
        $nextOrder = (JobOpening::max('sort_order') ?? 0) + 1;
        return view('admin.careers.openings.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(JobOpening::validationRules());
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        JobOpening::create($validated);

        return redirect()->route('admin.job-openings.index')
            ->with('success', 'Job opening posted successfully.');
    }

    public function show($id)
    {
        $opening = JobOpening::findOrFail($id);
        return view('admin.careers.openings.show', compact('opening'));
    }

    public function edit($id)
    {
        $opening = JobOpening::findOrFail($id);
        return view('admin.careers.openings.edit', compact('opening'));
    }

    public function update(Request $request, $id)
    {
        $opening = JobOpening::findOrFail($id);
        $validated = $request->validate(JobOpening::validationRules());
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : false;

        $opening->update($validated);

        return redirect()->route('admin.job-openings.index')
            ->with('success', 'Job opening updated successfully.');
    }

    public function destroy($id)
    {
        $opening = JobOpening::findOrFail($id);
        $opening->delete();

        return redirect()->route('admin.job-openings.index')
            ->with('success', 'Job opening deleted.');
    }

    public function toggle($id)
    {
        $opening = JobOpening::findOrFail($id);
        $opening->is_active = !$opening->is_active;
        $opening->save();

        return response()->json([
            'success' => true,
            'is_active' => $opening->is_active,
            'message' => 'Status toggled successfully'
        ]);
    }
}
