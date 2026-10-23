<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolEvent;

class EventController extends Controller
{
    public function index()
    {
        $events = SchoolEvent::orderBy('event_date', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|string|max:100',
            'event_date' => 'required|date',
            'description' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        SchoolEvent::create([
            'title' => $request->title,
            'category' => $request->category,
            'event_date' => $request->event_date,
            'description' => $request->description,
            'image_url' => $request->image_url ?? '/images/hero image.png',
            'link_url' => $request->link_url,
            'is_featured' => $request->has('is_featured'),
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Event added successfully.');
    }

    public function update(Request $request, $id)
    {
        $event = SchoolEvent::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|string|max:100',
            'event_date' => 'required|date',
            'description' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        $event->update([
            'title' => $request->title,
            'category' => $request->category,
            'event_date' => $request->event_date,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'link_url' => $request->link_url,
            'is_featured' => $request->has('is_featured'),
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        $event = SchoolEvent::findOrFail($id);
        $event->delete();

        return back()->with('success', 'Event deleted.');
    }
}
