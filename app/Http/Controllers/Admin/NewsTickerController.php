<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsTicker;
use App\Http\Requests\NewsTickerRequest;
use Illuminate\Http\Request;

class NewsTickerController extends Controller
{
    /**
     * [READ - Index] Listing of all news tickers.
     */
    public function index(Request $request)
    {
        $query = NewsTicker::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('pdf_url', 'like', '%' . $search . '%');
            });
        }

        $tickers = $query->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tickers.index', compact('tickers'));
    }

    /**
     * [CREATE - Form] Show the form for creating a new news ticker.
     */
    public function create()
    {
        return view('admin.tickers.create');
    }

    /**
     * [CREATE - Store] Save a newly created ticker in storage.
     */
    public function store(NewsTickerRequest $request)
    {
        $validated = $request->validated();

        NewsTicker::create($validated);

        flash()->success('News ticker announcement created successfully.', 'Ticker Created');

        return redirect()->route('admin.tickers.index')
            ->with('success', 'News ticker announcement created successfully.');
    }

    /**
     * [READ - Show] Redirect to edit form (show page removed).
     */
    public function show($id)
    {
        return redirect()->route('admin.tickers.edit', $id);
    }

    /**
     * [UPDATE - Form] Show the form for editing the specified ticker.
     */
    public function edit($id)
    {
        $ticker = NewsTicker::findOrFail($id);
        return view('admin.tickers.edit', compact('ticker'));
    }

    /**
     * [UPDATE - Save] Update the specified ticker in storage.
     */
    public function update(NewsTickerRequest $request, $id)
    {
        $ticker = NewsTicker::findOrFail($id);
        $validated = $request->validated();

        $ticker->update($validated);

        flash()->success('News ticker announcement updated successfully.', 'Ticker Updated');

        return redirect()->route('admin.tickers.index')
            ->with('success', 'News ticker announcement updated successfully.');
    }

    /**
     * [DELETE - Destroy] Remove the specified ticker from storage.
     */
    public function destroy($id)
    {
        $ticker = NewsTicker::findOrFail($id);
        $ticker->delete();

        flash()->info('News ticker announcement deleted successfully.', 'Ticker Removed');

        return redirect()->route('admin.tickers.index')
            ->with('success', 'News ticker announcement deleted successfully.');
    }
}
