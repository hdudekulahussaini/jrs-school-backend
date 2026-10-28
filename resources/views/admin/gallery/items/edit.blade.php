@extends('admin.layout')

@section('title', 'Edit Gallery Media | JRS School Admin')
@section('header', 'Edit Gallery Media')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Breadcrumb -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.gallery-items.index', ['album_id' => $item->gallery_album_id]) }}" class="text-xs text-slate-500 hover:text-jrs-navy font-semibold flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Media</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-xs text-slate-700 font-medium">Edit Item #{{ $item->id }}</span>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">Edit Gallery Media</h2>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.gallery-items.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs space-y-6">

            <!-- Target Album Selection -->
            <div class="space-y-1.5">
                <label for="gallery_album_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                    Target Album Section <span class="text-jrs-red">*</span>
                </label>
                <select name="gallery_album_id" id="gallery_album_id" required class="flex h-11 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm font-semibold shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy @error('gallery_album_id') border-red-500 @enderror">
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}" {{ (old('gallery_album_id', $item->gallery_album_id) == $album->id) ? 'selected' : '' }}>
                            {{ $album->title }} ({{ $album->badge ? $album->badge . ' — ' : '' }}{{ ucfirst($album->media_type) }})
                        </option>
                    @endforeach
                </select>
                @error('gallery_album_id') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <hr class="border-slate-100">

            <!-- Current Image Preview & Replacement -->
            <div>
                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Photo / Image',
                    'current' => $item->image_full_url ?? null,
                    'aspect' => 'landscape',
                    'help' => 'Leave empty to keep existing photo. Upload a new image to replace.',
                ])
            </div>

            <!-- Video URL Option -->
            <div class="space-y-1.5">
                <label for="video_url" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                    Video URL (Optional)
                </label>
                <div class="relative">
                    <svg class="w-4 h-4 text-purple-600 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $item->video_url) }}" placeholder="https://www.youtube.com/watch?v=..." class="flex h-10 w-full rounded-xl border border-slate-200 bg-white pl-10 pr-3.5 py-2 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy @error('video_url') border-red-500 @enderror">
                </div>
                @error('video_url') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <hr class="border-slate-100">

            <!-- Caption & Order -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="caption" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Caption / Label (e.g. Classroom, Walk Gallery)
                    </label>
                    <input type="text" name="caption" id="caption" value="{{ old('caption', $item->caption) }}" placeholder="e.g. Classroom, Entrance, Campus" class="flex h-10 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy @error('caption') border-red-500 @enderror">
                </div>

                <div class="space-y-1.5">
                    <label for="sort_order" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Sort Sequence Order
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $item->sort_order) }}" class="flex h-10 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                </div>

                <div class="sm:col-span-2 pt-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-jrs-red focus:ring-jrs-navy border-slate-300">
                        <div>
                            <span class="text-xs font-bold text-slate-800">Publish Immediately</span>
                            <p class="text-[10px] text-slate-400">Make this media item visible in the gallery.</p>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Sticky Form Footer -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between">
            <a href="{{ route('admin.gallery-items.index', ['album_id' => $item->gallery_album_id]) }}" class="px-4 py-2 text-xs font-semibold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-6 py-2 gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span>Save Changes</span>
            </button>
        </div>

    </form>

</div>
@endsection
