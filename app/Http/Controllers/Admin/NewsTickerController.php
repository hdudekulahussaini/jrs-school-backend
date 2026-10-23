<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsTicker;

class NewsTickerController extends Controller
{
    public function index()
    {
        $tickers = NewsTicker::orderBy('sort_order')->get();
        return view('admin.tickers.index', compact('tickers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'is_highlighted' => 'boolean',
            'sort_order' => 'integer',
        ]);

        NewsTicker::create([
            'title' => $request->title,
            'link_url' => $request->link_url,
            'is_highlighted' => $request->has('is_highlighted'),
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'News ticker announcement added successfully.');
    }

    public function update(Request $request, $id)
    {
        $ticker = NewsTicker::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        $ticker->update([
            'title' => $request->title,
            'link_url' => $request->link_url,
            'is_highlighted' => $request->has('is_highlighted'),
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'News ticker announcement updated.');
    }

    public function toggle($id)
    {
        $ticker = NewsTicker::findOrFail($id);
        $ticker->update(['is_active' => !$ticker->is_active]);

        return back()->with('success', 'Ticker visibility toggled.');
    }

    public function destroy($id)
    {
        $ticker = NewsTicker::findOrFail($id);
        $ticker->delete();

        return back()->with('success', 'News ticker item deleted.');
    }
}
