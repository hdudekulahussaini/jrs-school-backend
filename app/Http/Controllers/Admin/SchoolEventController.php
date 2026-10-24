<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolEvent;
use App\Http\Requests\SchoolEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SchoolEventController extends Controller
{
    /**
     * [READ - Index] Listing of all latest events.
     */
    public function index(Request $request)
    {
        $query = SchoolEvent::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('badge_month', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $events = $query->orderBy('sort_order', 'asc')
            ->orderBy('event_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $totalCount = SchoolEvent::count();
        $activeCount = SchoolEvent::where('is_active', true)->count();
        $inactiveCount = SchoolEvent::where('is_active', false)->count();

        return view('admin.events.index', compact('events', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new event.
     */
    public function create()
    {
        $nextOrder = (SchoolEvent::max('sort_order') ?? 0) + 1;
        return view('admin.events.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Persist a new event.
     */
    public function store(SchoolEventRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['link_url'] = $request->input('link_url', '/gallery');
        $validated['link_text'] = $request->input('link_text', 'Explore event');

        // Derive badge day and month from event_date if not explicitly provided
        if (!empty($validated['event_date'])) {
            $carbonDate = Carbon::parse($validated['event_date']);
            if (empty($validated['badge_day'])) {
                $validated['badge_day'] = $carbonDate->format('d');
            }
            if (empty($validated['badge_month'])) {
                $validated['badge_month'] = strtoupper($carbonDate->format('M'));
            }
        }

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/events');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'event_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/events/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        SchoolEvent::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Latest Event created successfully.');
    }

    /**
     * [READ - Show] Display event details.
     */
    public function show($id)
    {
        $event = SchoolEvent::findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $event = SchoolEvent::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    /**
     * [UPDATE - Action] Save updates to an existing event.
     */
    public function update(SchoolEventRequest $request, $id)
    {
        $event = SchoolEvent::findOrFail($id);
        $validated = $request->validated();

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['link_url'] = $request->input('link_url', '/gallery');
        $validated['link_text'] = $request->input('link_text', 'Explore event');

        // Derive badge day and month from event_date if provided
        if (!empty($validated['event_date'])) {
            $carbonDate = Carbon::parse($validated['event_date']);
            if (empty($validated['badge_day'])) {
                $validated['badge_day'] = $carbonDate->format('d');
            }
            if (empty($validated['badge_month'])) {
                $validated['badge_month'] = strtoupper($carbonDate->format('M'));
            }
        }

        // Handle Image Replacement
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/events');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'event_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);

            // Clean up old uploaded file if local
            if ($event->image_path && str_starts_with($event->image_path, 'uploads/events/')) {
                $oldPath = public_path($event->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $validated['image_path'] = 'uploads/events/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        } elseif ($request->has('remove_image')) {
            if ($event->image_path && str_starts_with($event->image_path, 'uploads/events/')) {
                $oldPath = public_path($event->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $validated['image_path'] = null;
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Latest Event updated successfully.');
    }

    /**
     * [STATUS TOGGLE] Quick switch between active and inactive.
     */
    public function toggle($id)
    {
        $event = SchoolEvent::findOrFail($id);
        $event->is_active = !$event->is_active;
        $event->save();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $event->is_active,
                'message' => 'Status changed to ' . ($event->is_active ? 'Active' : 'Inactive')
            ]);
        }

        return redirect()->back()
            ->with('success', 'Event status changed to ' . ($event->is_active ? 'Active' : 'Inactive') . '.');
    }

    /**
     * [DELETE] Remove event and its uploaded asset.
     */
    public function destroy($id)
    {
        $event = SchoolEvent::findOrFail($id);

        if ($event->image_path && str_starts_with($event->image_path, 'uploads/events/')) {
            $oldPath = public_path($event->image_path);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Latest Event deleted successfully.');
    }
}
