<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeStat;
use App\Http\Requests\HomeStatRequest;
use Illuminate\Http\Request;

class HomeStatController extends Controller
{
    /**
     * [READ - Index] Listing of all home stats cards.
     */
    public function index(Request $request)
    {
        $query = HomeStat::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('value', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('icon', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $stats = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalCount = HomeStat::count();
        $activeCount = HomeStat::where('is_active', true)->count();
        $inactiveCount = HomeStat::where('is_active', false)->count();

        return view('admin.stats.index', compact('stats', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new stat counter.
     */
    public function create()
    {
        $nextOrder = (HomeStat::max('sort_order') ?? 0) + 1;
        return view('admin.stats.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Persist a new stat counter card.
     */
    public function store(HomeStatRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['color'] = $request->filled('color') ? $request->input('color') : null;
        $validated['icon'] = $request->filled('icon') ? $request->input('icon') : null;
        $validated['description'] = $request->input('description', null);

        HomeStat::create($validated);

        flash()->success('Stat card created successfully.', 'Stat Created');

        return redirect()->route('admin.stats.index')
            ->with('success', 'Stat card created successfully.');
    }

    /**
     * [READ - Show] Display stat details.
     */
    public function show($id)
    {
        $stat = HomeStat::findOrFail($id);
        return redirect()->route('admin.stats.edit', $stat->id);
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $stat = HomeStat::findOrFail($id);
        return view('admin.stats.edit', compact('stat'));
    }

    /**
     * [UPDATE - Action] Save updates to an existing stat card.
     */
    public function update(HomeStatRequest $request, $id)
    {
        $stat = HomeStat::findOrFail($id);
        $validated = $request->validated();

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['color'] = $request->filled('color') ? $request->input('color') : null;
        $validated['icon'] = $request->filled('icon') ? $request->input('icon') : null;
        $validated['description'] = $request->input('description', null);

        $stat->update($validated);

        flash()->success('Stat card updated successfully.', 'Stat Updated');

        return redirect()->route('admin.stats.index')
            ->with('success', 'Stat card updated successfully.');
    }

    /**
     * [STATUS TOGGLE] Quick switch between active and inactive.
     */
    public function toggle($id)
    {
        $stat = HomeStat::findOrFail($id);
        $stat->is_active = !$stat->is_active;
        $stat->save();

        if ($stat->is_active) {
            flash()->success('Stat status changed to Active.', 'Status Updated');
        } else {
            flash()->warning('Stat status changed to Inactive.', 'Status Inactive');
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $stat->is_active,
                'message' => 'Status changed to ' . ($stat->is_active ? 'Active' : 'Inactive')
            ]);
        }

        return redirect()->back()
            ->with('success', 'Stat card status changed to ' . ($stat->is_active ? 'Active' : 'Inactive') . '.');
    }

    /**
     * [DELETE] Remove stat card.
     */
    public function destroy($id)
    {
        $stat = HomeStat::findOrFail($id);
        $stat->delete();

        flash()->info('Stat card deleted successfully.', 'Stat Removed');

        return redirect()->route('admin.stats.index')
            ->with('success', 'Stat card deleted successfully.');
    }
}
