<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsTicker;
use App\Http\Requests\NewsTickerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class NewsTickerController extends Controller
{
    /**
     * Ensure table and columns exist.
     */
    protected function ensureTableExists(): void
    {
        if (!Schema::hasTable('news_tickers')) {
            Schema::create('news_tickers', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('badge_text')->default('NEWS');
                $table->string('link_url')->nullable();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            Schema::table('news_tickers', function (\Illuminate\Database\Schema\Blueprint $table) {
                if (!Schema::hasColumn('news_tickers', 'badge_text')) {
                    $table->string('badge_text')->default('NEWS')->after('title');
                }
                if (!Schema::hasColumn('news_tickers', 'link_url')) {
                    $table->string('link_url')->nullable()->after('badge_text');
                }
                if (!Schema::hasColumn('news_tickers', 'sort_order')) {
                    $table->integer('sort_order')->default(0)->after('link_url');
                }
                if (!Schema::hasColumn('news_tickers', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('sort_order');
                }
            });
        }
    }

    /**
     * [READ - Index] Listing of all news tickers.
     */
    public function index(Request $request)
    {
        $this->ensureTableExists();

        $query = NewsTicker::query();

        // Optional search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('badge_text', 'like', '%' . $request->search . '%');
        }

        $tickers = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tickers.index', compact('tickers'));
    }

    /**
     * [CREATE - Form] Show the form for creating a new news ticker.
     */
    public function create()
    {
        $this->ensureTableExists();
        $nextOrder = (NewsTicker::max('sort_order') ?? 0) + 1;
        return view('admin.tickers.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Save a newly created ticker in storage.
     */
    public function store(NewsTickerRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        if (empty($validated['badge_text'])) {
            $validated['badge_text'] = 'NEWS';
        }
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = 0;
        }

        $ticker = NewsTicker::create($validated);

        flash()->success('News ticker announcement created successfully.');

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
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        if (empty($validated['badge_text'])) {
            $validated['badge_text'] = 'NEWS';
        }

        $ticker->update($validated);

        flash()->success('News ticker announcement updated successfully.');

        return redirect()->route('admin.tickers.index')
            ->with('success', 'News ticker announcement updated successfully.');
    }

    /**
     * [UPDATE - Quick Toggle] Toggle active status.
     */
    public function toggle($id)
    {
        $ticker = NewsTicker::findOrFail($id);
        $ticker->is_active = !$ticker->is_active;
        $ticker->save();

        if ($ticker->is_active) {
            flash()->success('Ticker status changed to Active.');
        } else {
            flash()->success('Ticker status changed to Disabled.');
        }

        return redirect()->back()
            ->with('success', 'Ticker status changed to ' . ($ticker->is_active ? 'Active' : 'Disabled') . '.');
    }

    /**
     * [DELETE - Destroy] Remove the specified ticker from storage.
     */
    public function destroy($id)
    {
        $ticker = NewsTicker::findOrFail($id);
        $ticker->delete();

        flash()->success('News ticker announcement deleted successfully.');

        return redirect()->route('admin.tickers.index')
            ->with('success', 'News ticker announcement deleted successfully.');
    }
}
