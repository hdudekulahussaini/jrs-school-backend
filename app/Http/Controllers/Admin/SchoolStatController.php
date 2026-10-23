<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolStat;

class SchoolStatController extends Controller
{
    public function index()
    {
        $stats = SchoolStat::orderBy('sort_order')->get();
        return view('admin.stats.index', compact('stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:100',
            'value' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer',
        ]);

        SchoolStat::create([
            'label' => $request->label,
            'value' => $request->value,
            'icon' => $request->icon ?? 'sparkles',
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Stat counter created.');
    }

    public function update(Request $request, $id)
    {
        $stat = SchoolStat::findOrFail($id);

        $request->validate([
            'label' => 'required|string|max:100',
            'value' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer',
        ]);

        $stat->update([
            'label' => $request->label,
            'value' => $request->value,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Stat counter updated.');
    }

    public function destroy($id)
    {
        $stat = SchoolStat::findOrFail($id);
        $stat->delete();

        return back()->with('success', 'Stat counter removed.');
    }
}
