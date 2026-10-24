@extends('admin.layout')

@section('title', 'Edit Event - ' . $event->title)
@section('header', 'Edit Latest Event')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Latest Events</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Edit: {{ $event->title }}</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Update event title, dates, badge day/month, photo, and ordering.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.events.show', $event->id) }}" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 shadow-xs h-9 px-3 py-1.5 gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>View Details</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl">
        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Event Details</h3>
                    <p class="text-xs text-slate-500">Configure event title, date, and date badge display.</p>
                </div>

                <!-- Event Title -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Event Title <span class="text-jrs-red">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required placeholder="e.g. Republic Day Celebrations, Annual Day" class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    @error('title')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Date & Badge Overrides -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="event_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Calendar Date
                        </label>
                        <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $event->event_date ? $event->event_date->format('Y-m-d') : '') }}" onchange="updateBadgeFromDate(this.value)" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('event_date')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="badge_day" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Badge Day (e.g. 26)
                        </label>
                        <input type="text" name="badge_day" id="badge_day" value="{{ old('badge_day', $event->badge_day) }}" placeholder="26" maxlength="10" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Red bold number on badge.</span>
                    </div>

                    <div>
                        <label for="badge_month" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Badge Month (e.g. JAN)
                        </label>
                        <input type="text" name="badge_month" id="badge_month" value="{{ old('badge_month', $event->badge_month) }}" placeholder="JAN" maxlength="10" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm uppercase font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Navy uppercase label.</span>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Event Description
                    </label>
                    <textarea name="description" id="description" rows="3" placeholder="Brief summary of patriotic performances, awards, guest lectures, or games..." class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Media & Photo Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Event Photo</h3>
                    <p class="text-xs text-slate-500">Update event celebration photo (recommended ratio 16:10).</p>
                </div>

                <!-- Current Photo Preview -->
                @if($event->image_full_url)
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="relative w-20 h-14 rounded-md overflow-hidden border border-slate-200 shrink-0">
                                <img src="{{ $event->image_full_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                <div class="absolute top-1 left-1 bg-white/95 rounded px-1 text-[9px] font-bold text-jrs-red leading-tight">
                                    {{ $event->display_day }} {{ $event->display_month }}
                                </div>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-700 block">Current Photo</span>
                                <span class="text-[11px] text-slate-400 block font-mono truncate max-w-xs">{{ $event->image_path }}</span>
                            </div>
                        </div>
                        <label class="flex items-center gap-1.5 text-xs text-jrs-red hover:underline cursor-pointer">
                            <input type="checkbox" name="remove_image" value="1" class="rounded border-slate-300 text-jrs-red focus:ring-jrs-red">
                            <span>Remove</span>
                        </label>
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Replace Image</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed rounded-lg cursor-pointer transition-colors border-slate-300 hover:border-jrs-navy bg-slate-50/50 hover:bg-slate-50">
                                <div class="flex flex-col items-center justify-center pt-4 pb-4">
                                    <svg class="w-6 h-6 mb-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <p class="text-xs text-slate-600 font-medium"><span class="font-bold text-jrs-navy">Upload new image</span> (replaces current)</p>
                                    <p class="text-[11px] text-slate-400">WEBP, JPG, PNG up to 5MB</p>
                                </div>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*">
                            </label>
                        </div>
                        @error('image')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative flex items-center justify-center">
                        <div class="border-t border-slate-200 w-full"></div>
                        <span class="bg-white px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider absolute">OR</span>
                    </div>

                    <div>
                        <label for="image_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Image Asset Path / Remote URL
                        </label>
                        <input type="text" name="image_url" id="image_url" value="{{ old('image_url') }}" placeholder="e.g. /images/events/republic-day.jpg or https://..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('image_url')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Target Link Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Call to Action Link</h3>
                    <p class="text-xs text-slate-500">Configure link button at the bottom of the event card.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="link_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Link Label
                        </label>
                        <input type="text" name="link_text" id="link_text" value="{{ old('link_text', $event->link_text) }}" placeholder="Explore event" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    </div>

                    <div>
                        <label for="link_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Target URL / Route
                        </label>
                        <input type="text" name="link_url" id="link_url" value="{{ old('link_url', $event->link_url) }}" placeholder="/gallery or https://..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    </div>
                </div>
            </div>

            <!-- Publishing Settings Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Display & Order Settings</h3>
                    <p class="text-xs text-slate-500">Control appearance order and immediate visibility.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Display Sort Order
                        </label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $event->sort_order) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Lower numbers appear first.</span>
                    </div>

                    <div class="pt-4 sm:pt-0">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-jrs-red focus:ring-jrs-red">
                            <div class="space-y-0.5">
                                <span class="text-xs font-bold text-slate-700 block">Published / Visible</span>
                                <span class="text-[11px] text-slate-500 block">Show this event on the school homepage.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.events.index') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-10 px-5 py-2 gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Save Updates</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateBadgeFromDate(val) {
    if (!val) return;
    const d = new Date(val);
    if (!isNaN(d.getTime())) {
        const months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        const day = String(d.getDate()).padStart(2, '0');
        const month = months[d.getMonth()];
        const dayInput = document.getElementById('badge_day');
        const monthInput = document.getElementById('badge_month');
        if (dayInput && !dayInput.value) dayInput.value = day;
        if (monthInput && !monthInput.value) monthInput.value = month;
    }
}
</script>
@endsection
