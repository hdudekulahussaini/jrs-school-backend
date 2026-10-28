@extends('admin.layout')

@section('title', 'Add Latest Event')
@section('header', 'Add Latest Event')

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
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Add Latest Event</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Configure a new celebration or achievement card for the "What's Happening At JRS" homepage section.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="w-full">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

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
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
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
                        <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" onchange="updateBadgeFromDate(this.value)" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('event_date')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="badge_day" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Badge Day (e.g. 26)
                        </label>
                        <input type="text" name="badge_day" id="badge_day" value="{{ old('badge_day') }}" maxlength="10" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Red bold number on badge.</span>
                    </div>

                    <div>
                        <label for="badge_month" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Badge Month (e.g. JAN)
                        </label>
                        <input type="text" name="badge_month" id="badge_month" value="{{ old('badge_month') }}" maxlength="10" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm uppercase font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Navy uppercase label.</span>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Event Description
                    </label>
                    <textarea name="description" id="description" rows="3" class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Media & Photo Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Event Photo</h3>
                    <p class="text-xs text-slate-500">Upload event celebration photo (recommended ratio 16:10).</p>
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Event Photograph',
                    'aspect' => 'video',
                    'help' => 'Supported: WEBP, JPG, PNG up to 5MB (recommended 16:10 landscape).',
                    'urlField' => true,
                    'urlName' => 'image_url',
                    'urlValue' => old('image_url'),
                ])
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
                        <input type="text" name="link_text" id="link_text" value="{{ old('link_text') }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    </div>

                    <div>
                        <label for="link_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Target URL / Route
                        </label>
                        <input type="text" name="link_url" id="link_url" value="{{ old('link_url') }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
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
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Lower numbers appear first.</span>
                    </div>

                    <div class="pt-4 sm:pt-0">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-jrs-red focus:ring-jrs-red">
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
                    <span>Create Event</span>
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
