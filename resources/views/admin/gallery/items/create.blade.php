@extends('admin.layout')

@section('title', 'Upload Gallery Media | JRS School Admin')
@section('header', 'Upload Gallery Media')

@section('content')
<div class="max-w-3xl space-y-6">

    <!-- Breadcrumb -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.gallery-items.index') }}" class="text-xs text-slate-500 hover:text-jrs-navy font-semibold flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Media</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-xs text-slate-700 font-medium">Upload Media</span>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">Upload Photos / Videos</h2>
        </div>
    </div>

    <!-- Upload Form -->
    <form action="{{ route('admin.gallery-items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs space-y-6">

            <!-- Target Album Selection -->
            <div class="space-y-1.5">
                <label for="gallery_album_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                    Select Target Album Section <span class="text-jrs-red">*</span>
                </label>
                <select name="gallery_album_id" id="gallery_album_id" required class="flex h-11 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm font-semibold shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy @error('gallery_album_id') border-red-500 @enderror">
                    <option value="">-- Choose Album Section --</option>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}" {{ (old('gallery_album_id', $selectedAlbumId) == $album->id) ? 'selected' : '' }}>
                            {{ $album->title }} ({{ $album->badge ? $album->badge . ' — ' : '' }}{{ ucfirst($album->media_type) }})
                        </option>
                    @endforeach
                </select>
                @error('gallery_album_id') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <hr class="border-slate-100">

            <!-- File Upload (Single or Multiple) -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Upload Image Files (Supports Multi-Select)
                    </label>
                    <span class="text-[10px] text-slate-400">JPG, PNG, WebP up to 5MB each</span>
                </div>

                <div class="border-2 border-dashed border-slate-300 hover:border-jrs-navy rounded-2xl p-6 text-center transition-colors bg-slate-50/50">
                    <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden" onchange="previewFiles(this)">
                    <label for="images" class="cursor-pointer space-y-2 block">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-jrs-navy mx-auto flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-jrs-navy hover:text-jrs-red transition-colors">Click to browse</span>
                            <span class="text-xs text-slate-500"> or select multiple files at once</span>
                        </div>
                    </label>
                </div>
                <div id="filePreviewList" class="flex flex-wrap gap-2 pt-2"></div>
                @error('images') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
                @error('image') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Video URL Option -->
            <div class="space-y-1.5">
                <label for="video_url" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                    Or Video URL (For Video Gallery Cards)
                </label>
                <div class="relative">
                    <svg class="w-4 h-4 text-purple-600 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=... or MP4 URL" class="flex h-10 w-full rounded-xl border border-slate-200 bg-white pl-10 pr-3.5 py-2 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy @error('video_url') border-red-500 @enderror">
                </div>
                <p class="text-[10px] text-slate-400">Used for section cards like "Create Life Skills" with play video popup.</p>
                @error('video_url') <p class="text-[11px] text-red-600 font-medium">{{ $message }}</p> @enderror
            </div>

            <hr class="border-slate-100">

            <!-- Caption & Order -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="caption" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Caption / Label (Optional)
                    </label>
                    <input type="text" name="caption" id="caption" value="{{ old('caption') }}" placeholder="e.g. Classroom, Walk Gallery, Entrance, Campus" class="flex h-10 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy @error('caption') border-red-500 @enderror">
                    <p class="text-[10px] text-slate-400">Displayed below the photo as in the Amphitheatre gallery.</p>
                </div>

                <div class="space-y-1.5">
                    <label for="sort_order" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                        Sort Sequence Order
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder) }}" class="flex h-10 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                </div>

                <div class="sm:col-span-2 pt-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-jrs-red focus:ring-jrs-navy border-slate-300">
                        <div>
                            <span class="text-xs font-bold text-slate-800">Publish Immediately</span>
                            <p class="text-[10px] text-slate-400">Items will be visible in the gallery upon upload.</p>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Sticky Form Footer -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between">
            <a href="{{ route('admin.gallery-items.index', ['album_id' => $selectedAlbumId]) }}" class="px-4 py-2 text-xs font-semibold rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-6 py-2 gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <span>Upload to Gallery</span>
            </button>
        </div>

    </form>

</div>

<script>
function previewFiles(input) {
    const list = document.getElementById('filePreviewList');
    list.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const badge = document.createElement('span');
            badge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200';
            badge.textContent = file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
            list.appendChild(badge);
        });
    }
}
</script>
@endsection
