@extends('admin.layout')

@section('title', 'Home Banner')
@section('header', 'Home Banner')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Breadcrumb & Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-slate-500">Home Page</span>
            <span>/</span>
            <span class="text-slate-900 font-semibold">Home Banner</span>
        </div>

        @if($banner && $banner->image_full_url)
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Active Banner Configured</span>
            </div>
        @else
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <span>No Banner Uploaded Yet</span>
            </div>
        @endif
    </div>

    <!-- Live Banner Display Card -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
            <div>
                <h3 class="text-base font-bold text-slate-900">Current Home Page Banner</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    This banner image is displayed across the home page (e.g. IIT | JEE | NEET / Olympiad promotional banner).
                </p>
            </div>

            @if($banner && $banner->image_full_url)
                <button type="button" onclick="openDeleteModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition-colors cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Delete Banner</span>
                </button>
            @endif
        </div>

        <div class="p-6">
            @if($banner && $banner->image_full_url)
                <div class="space-y-4">
                    <!-- Artwork Container with Subtle Glow & Shadow -->
                    <div class="relative rounded-2xl overflow-hidden border border-slate-200/90 shadow-md bg-slate-950 group">
                        <img id="currentBannerImage" src="{{ $banner->image_full_url }}" alt="Home Banner" class="w-full h-auto object-cover max-h-[380px] mx-auto block transition-transform duration-300 group-hover:scale-[1.01]">
                        <div class="absolute bottom-3 left-3 bg-slate-950/80 backdrop-blur-md px-3 py-1 rounded-lg text-[11px] font-mono text-white/90 border border-white/10 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span>{{ $banner->image_path }}</span>
                        </div>
                        <a href="{{ $banner->image_full_url }}" target="_blank" class="absolute top-3 right-3 bg-slate-950/80 hover:bg-slate-900 text-white px-2.5 py-1 rounded-lg text-xs font-semibold backdrop-blur-md border border-white/10 flex items-center gap-1 transition-colors">
                            <i class="bi bi-box-arrow-up-right text-[11px]"></i>
                            <span>View Full Size</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="py-12 px-6 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800">No Home Banner Image Uploaded</h4>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                        Upload your promotional banner graphic below to display it on the home page.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Image Upload Form Card (STRICTLY IMAGE ONLY) -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/70">
            <h3 class="text-base font-bold text-slate-900">
                {{ $banner && $banner->image_full_url ? 'Replace Home Banner Image' : 'Upload Home Banner Image' }}
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">
                Upload banner graphic (PNG, JPG, WEBP up to 10MB). No extra fields are required.
            </p>
        </div>

        <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @if($formMethod)
                @method($formMethod)
            @endif

            <!-- Single Image Upload Dropzone -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Banner Image File <span class="text-red-500">*</span>
                </label>

                <div class="border-2 border-dashed border-slate-300 hover:border-jrs-navy rounded-2xl p-8 text-center bg-slate-50/50 hover:bg-slate-50 transition-all cursor-pointer group" onclick="document.getElementById('banner_file_input').click()">
                    <input type="file" name="image" id="banner_file_input" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="hidden" onchange="previewSelectedImage(this)">
                    
                    <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 group-hover:bg-red-50 group-hover:text-jrs-red flex items-center justify-center mx-auto mb-3 transition-colors">
                        <i class="bi bi-cloud-arrow-up-fill text-2xl"></i>
                    </div>

                    <p class="text-sm font-bold text-slate-700 group-hover:text-jrs-navy transition-colors">
                        Click or drag & drop banner image here
                    </p>
                    <p class="text-xs text-slate-400 mt-1">
                        High resolution recommended (e.g. 1920x600 or 1200x400) • Supports PNG, JPG, WEBP (up to 10MB)
                    </p>
                </div>

                @error('image')
                    <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Live Selected Preview -->
            <div id="newPreviewContainer" class="hidden space-y-2">
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">New Image Preview</span>
                <div class="relative rounded-2xl overflow-hidden border-2 border-emerald-400 bg-slate-950 max-h-[360px] shadow-sm">
                    <img id="newPreviewImg" src="" alt="Selected Preview" class="w-full h-auto object-cover max-h-[360px] mx-auto block">
                    <span class="absolute top-3 left-3 bg-emerald-600 text-white text-[11px] font-bold px-2.5 py-1 rounded-md shadow-xs">
                        Ready to Upload
                    </span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-jrs-red hover:bg-red-700 text-white shadow-md shadow-red-600/30 transition-all flex items-center gap-2 cursor-pointer">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ $banner && $banner->image_full_url ? 'Save & Replace Banner' : 'Upload Banner' }}</span>
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Delete Confirmation Modal -->
@if($banner)
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="w-12 h-12 rounded-full bg-red-100 text-jrs-red flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900">Delete Home Banner</h3>
                <p class="text-sm text-slate-500 mt-1">Are you sure you want to delete this home banner image? This action cannot be undone.</p>
            </div>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-2">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors cursor-pointer">Cancel</button>
            <form method="POST" action="{{ route('admin.home-banner.destroy', $banner->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-jrs-red hover:opacity-90 rounded-md transition-opacity shadow-xs cursor-pointer">Delete Banner</button>
            </form>
        </div>
    </div>
</div>
@endif

<script>
function previewSelectedImage(input) {
    const container = document.getElementById('newPreviewContainer');
    const img = document.getElementById('newPreviewImg');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        container.classList.add('hidden');
    }
}

function openDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) modal.classList.add('hidden');
}
</script>
@endsection
