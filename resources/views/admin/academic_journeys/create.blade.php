@extends('admin.layout')

@section('title', 'Add Academic Journey')
@section('header', 'Add Academic Journey')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.academic-journeys.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Academic Journeys</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Add Academic Journey</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Configure a new early learning stage card (e.g. Pre-Primary Programme, Young Buddies, Butterflies, Honey Bees).
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-3xl">
        <form action="{{ route('admin.academic-journeys.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Details Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Programme Details</h3>
                    <p class="text-xs text-slate-500">Title, age group badge, and icon identifier.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Programme Title <span class="text-jrs-red">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Butterflies Programme" class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('title')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Age Group Badge -->
                    <div>
                        <label for="age_group" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Age Group Badge / Subtitle
                        </label>
                        <input type="text" name="age_group" id="age_group" value="{{ old('age_group') }}" placeholder="e.g. EARLY YEARS or AGE 3.5 TO 4.5 YEARS" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Shown in gold badge under title.</span>
                        @error('age_group')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            URL Slug
                        </label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="e.g. butterflies-programme (auto-generated if empty)" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('slug')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon Identifier -->
                    <div>
                        <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Badge Icon Symbol
                        </label>
                        <select name="icon" id="icon" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            <option value="baby" {{ old('icon') == 'baby' ? 'selected' : '' }}>baby (Pre-Primary / Early Years)</option>
                            <option value="users" {{ old('icon') == 'users' ? 'selected' : '' }}>users (Young Buddies / Community)</option>
                            <option value="sparkles" {{ old('icon') == 'sparkles' ? 'selected' : '' }}>sparkles (Butterflies / Curiosity)</option>
                            <option value="heart" {{ old('icon') == 'heart' ? 'selected' : '' }}>heart (Honey Bees / Care & Values)</option>
                            <option value="book" {{ old('icon') == 'book' ? 'selected' : '' }}>book (Reading & Learning)</option>
                            <option value="award" {{ old('icon') == 'award' ? 'selected' : '' }}>award (Excellence & Growth)</option>
                        </select>
                        @error('icon')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Description <span class="text-jrs-red">*</span>
                    </label>
                    <textarea name="description" id="description" rows="3" required placeholder="Describe this academic stage and developmental goals..." class="flex min-h-[80px] w-full rounded-md border {{ $errors->has('description') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link URL -->
                <div>
                    <label for="link_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Explore Details Link
                    </label>
                    <input type="text" name="link_url" id="link_url" value="{{ old('link_url') }}" placeholder="e.g. /academics/butterflies-programme" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    <span class="text-[11px] text-slate-400">Target path when visitors click "Explore details".</span>
                    @error('link_url')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Media / Image Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Stage Photograph</h3>
                    <p class="text-xs text-slate-500">Upload a high-quality photograph showcasing classroom or campus learning.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Upload Photo File
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" class="flex w-full rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy/10 file:text-jrs-navy hover:file:bg-jrs-navy/20 cursor-pointer">
                        <span class="text-[11px] text-slate-400">Accepted formats: JPEG, PNG, WEBP. Max size: 4MB.</span>
                        @error('image')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t border-slate-200"></div>
                        <span class="flex-shrink mx-4 text-slate-400 text-xs uppercase font-medium">OR existing image path</span>
                        <div class="flex-grow border-t border-slate-200"></div>
                    </div>

                    <div>
                        <label for="image_path" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Static Image Path / URL
                        </label>
                        <input type="text" name="image_path" id="image_path" value="{{ old('image_path') }}" placeholder="e.g. images/journey/butterflies-programme.jpg" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('image_path')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Publishing & Order Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Display & Order Settings</h3>
                    <p class="text-xs text-slate-500">Position order and immediate visibility on the Academics page.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Display Sort Order
                        </label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Position 1 to 4 from left to right.</span>
                    </div>

                    <div class="pt-4 sm:pt-0">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-jrs-red focus:ring-jrs-red">
                            <div class="space-y-0.5">
                                <span class="text-xs font-bold text-slate-700 block">Published / Visible</span>
                                <span class="text-[11px] text-slate-500 block">Show this card on the Academics page.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.academic-journeys.index') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-10 px-5 py-2 gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Create Journey Card</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
