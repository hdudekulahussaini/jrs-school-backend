@extends('admin.layout')

@section('title', 'Add Gallery Album Section | JRS School Admin')
@section('header', 'Add Gallery Album')

@section('content')
<div class="max-w-4xl space-y-6">

    <!-- Breadcrumb -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.gallery-albums.index') }}" class="text-xs text-slate-500 hover:text-jrs-navy font-semibold flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Albums</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-xs text-slate-700 font-medium">New Album Section</span>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">Add Gallery Album Section</h2>
        </div>
    </div>

    <!-- Create Form -->
    <form action="{{ route('admin.gallery-albums.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs space-y-6">

            <!-- Section 1: Basic Information -->
            <div>
                <h3 class="text-sm font-bold text-jrs-navy uppercase tracking-wider font-heading mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-jrs-red"></span>
                    Album Header & Titles
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2 space-y-1.5">
                        <label for="badge" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Badge / Category Tag
                        </label>
                        <input type="text" name="badge" id="badge" value="{{ old('badge') }}" placeholder="e.g. CAMPUS INFRASTRUCTURE & OPEN AIR ARENA, ANNUAL DAY HIGHLIGHTS" class="flex h-10 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy @error('badge') border-red-500 @enderror">
                        @error('badge') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="title" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Main Title <span class="text-jrs-red">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Amphitheatre Open-Air Arena" class="flex h-10 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy @error('title') border-red-500 @enderror">
                        @error('title') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="highlight_text" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Highlighted Word/Text (Styled in Red)
                        </label>
                        <input type="text" name="highlight_text" id="highlight_text" value="{{ old('highlight_text') }}" placeholder="e.g. Open-Air Arena, Celebrations" class="flex h-10 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy @error('highlight_text') border-red-500 @enderror">
                        <p class="text-[10px] text-slate-400">The specific substring that appears highlighted in red in the heading.</p>
                        @error('highlight_text') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2 space-y-1.5">
                        <label for="description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Subtitle / Description
                        </label>
                        <textarea name="description" id="description" rows="3" placeholder="A world-class architectural amphitheatre surrounded by lush manicured greenery..." class="flex w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 2: Media Type & Cover Image -->
            <div>
                <h3 class="text-sm font-bold text-jrs-navy uppercase tracking-wider font-heading mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-jrs-navy"></span>
                    Media Type & Cover Photo
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Section Media Type <span class="text-jrs-red">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                                <input type="radio" name="media_type" value="image" {{ old('media_type', 'image') === 'image' ? 'checked' : '' }} class="text-jrs-red focus:ring-jrs-navy">
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Photo Gallery</p>
                                    <p class="text-[10px] text-slate-500">Image grids & captions</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                                <input type="radio" name="media_type" value="video" {{ old('media_type') === 'video' ? 'checked' : '' }} class="text-jrs-red focus:ring-jrs-navy">
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Video Gallery</p>
                                    <p class="text-[10px] text-slate-500">Video cards & plays</p>
                                </div>
                            </label>
                        </div>
                        @error('media_type') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="cover_image" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Album Cover Image (Optional)
                        </label>
                        <input type="file" name="cover_image" id="cover_image" accept="image/*" class="flex h-10 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition-colors">
                        <p class="text-[10px] text-slate-400">If omitted, the first photo inside this album will be used as the preview.</p>
                        @error('cover_image') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 3: Ordering & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="sort_order" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Display Order
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder) }}" class="flex h-10 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    <p class="text-[10px] text-slate-400">Controls the sequence of albums on the Gallery page (lowest first).</p>
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-jrs-red focus:ring-jrs-navy border-slate-300">
                        <div>
                            <span class="text-xs font-bold text-slate-800">Publish Immediately</span>
                            <p class="text-[10px] text-slate-400">Make this album section visible to the public.</p>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Sticky Form Footer -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between">
            <a href="{{ route('admin.gallery-albums.index') }}" class="px-4 py-2 text-xs font-semibold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-6 py-2 gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span>Save Album Section</span>
            </button>
        </div>

    </form>

</div>
@endsection
