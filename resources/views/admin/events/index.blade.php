@extends('admin.layout')

@section('title', "What's Happening Events")
@section('header', "What's Happening At JRS (School Events)")

@section('content')
<div class="space-y-6">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add Event Form -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-xs h-fit">
            <h3 class="text-base font-bold text-slate-900 font-heading mb-1">Add School Event</h3>
            <p class="text-xs text-slate-500 mb-4">Publish upcoming sports meets, cultural fests, or academic exhibitions</p>

            <form action="{{ route('admin.events.store') }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Event Title *</label>
                    <input type="text" name="title" required placeholder="e.g., Annual Sports Meet 2026" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Category</label>
                        <select name="category" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                            <option value="Cultural Celebration">Cultural Celebration</option>
                            <option value="Sports">Sports</option>
                            <option value="Academics & Tech">Academics & Tech</option>
                            <option value="STEM & Robotics">STEM & Robotics</option>
                            <option value="Campus Life">Campus Life</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Event Date *</label>
                        <input type="date" name="event_date" value="{{ date('Y-m-d') }}" required class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description *</label>
                    <textarea name="description" rows="3" required placeholder="Brief description of the event..." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Image URL / Path</label>
                    <input type="text" name="image_url" value="/images/hero image.png" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Event Link / Article URL</label>
                    <input type="text" name="link_url" placeholder="/media or https://..." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" checked class="w-4 h-4 text-jrs-red rounded border-slate-300 focus:ring-jrs-red">
                        <span class="text-xs font-bold text-slate-700">Feature on Homepage</span>
                    </label>

                    <div class="flex items-center gap-1">
                        <span class="text-xs text-slate-500">Order:</span>
                        <input type="number" name="sort_order" value="1" class="w-16 p-1 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-jrs-red hover:bg-jrs-red-dark shadow-md shadow-red-600/30 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Publish Event</span>
                </button>
            </form>
        </div>

        <!-- Events Cards Grid -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900 font-heading">Scheduled Events ({{ $events->count() }})</h3>
                <span class="text-xs text-slate-500">Sorted by event date</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($events as $event)
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="p-5">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $event->category }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium">
                                    📅 {{ $event->event_date ? $event->event_date->format('M d, Y') : 'Upcoming' }}
                                </span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-sm sm:text-base font-heading mt-1">{{ $event->title }}</h4>
                            <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">{{ $event->description }}</p>
                        </div>

                        <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-semibold {{ $event->is_featured ? 'text-emerald-600' : 'text-slate-400' }}">
                                {{ $event->is_featured ? '★ Featured on Home' : 'Standard' }}
                            </span>

                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 bg-white rounded-2xl p-8 text-center text-slate-500 border border-slate-200">
                        No events added yet. Use the form on the left to add one.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
