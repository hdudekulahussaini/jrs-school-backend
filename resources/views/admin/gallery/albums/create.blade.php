@extends('admin.layout')

@section('title', 'Add Gallery Photos | JRS School Admin')
@section('header', 'Add Gallery Photos')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.gallery-albums.index') }}" class="text-xs text-slate-500 hover:text-jrs-navy font-semibold flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Albums</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-xs text-slate-700 font-medium">New Gallery Section</span>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">Add Gallery Photos</h2>
        </div>
    </div>

    <!-- Create Form -->
    <form action="{{ route('admin.gallery-albums.store') }}" method="POST" enctype="multipart/form-data" id="galleryForm" class="space-y-6">
        @csrf

        <!-- Photo Gallery Box -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">

            <!-- Section Header -->
            <div class="flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2.5 h-0.5 bg-rose-500 rounded-full inline-block"></span>
                        <span>PHOTO GALLERY</span>
                    </h3>
                    <p class="text-xs text-slate-500">
                        Upload gallery photos for this section. Each photo can be added or removed individually.
                    </p>
                </div>

                <!-- Hidden file input -->
                <input type="file" id="photoFileInput" name="gallery_photos[]" multiple accept="image/*" class="hidden">

                <!-- Add Photo Button -->
                <button type="button" id="addPhotoBtn" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-rose-200 bg-rose-50/70 hover:bg-rose-100 text-rose-700 text-xs font-semibold shadow-2xs transition-all cursor-pointer shrink-0">
                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span>Add Photo</span>
                </button>
            </div>

            <!-- Photos Grid -->
            <div id="photosGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pt-1">
                <!-- Dynamically populated photo cards -->
            </div>

            <!-- Empty State Placeholder -->
            <div id="emptyPhotosState" class="py-14 text-center rounded-xl border border-dashed border-slate-200 bg-slate-50/50">
                <div class="max-w-xs mx-auto space-y-2">
                    <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 mx-auto flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">No photos added yet</p>
                    <p class="text-[11px] text-slate-400">Click "+ Add Photo" to select images from your computer.</p>
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
                <span>Save Gallery Photos</span>
            </button>
        </div>

    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addBtn = document.getElementById('addPhotoBtn');
        const fileInput = document.getElementById('photoFileInput');
        const grid = document.getElementById('photosGrid');
        const emptyState = document.getElementById('emptyPhotosState');

        // Maintain list of uploaded files via DataTransfer
        const dt = new DataTransfer();

        addBtn.addEventListener('click', function () {
            fileInput.click();
        });

        fileInput.addEventListener('change', function () {
            const files = Array.from(fileInput.files);
            if (!files.length) return;

            files.forEach(file => {
                if (!file.type.startsWith('image/')) return;

                const fileIdx = dt.items.length;
                dt.items.add(file);

                const reader = new FileReader();
                reader.onload = function (e) {
                    const card = document.createElement('div');
                    card.className = 'relative rounded-2xl overflow-hidden border border-slate-200/90 shadow-2xs bg-slate-900 group aspect-4/3 transition-all animate-in fade-in duration-200';
                    card.dataset.fileIdx = fileIdx;

                    card.innerHTML = `
                        <img src="${e.target.result}" alt="${file.name}" class="w-full h-full object-cover">
                        <button type="button" class="remove-photo-btn absolute top-2.5 right-2.5 inline-flex items-center gap-1 rounded-md bg-[#dc2626] hover:bg-red-700 text-white text-xs font-semibold px-2.5 py-1 shadow-sm transition-all cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>Remove</span>
                        </button>
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/85 via-black/45 to-transparent px-3 py-2 pointer-events-none">
                            <p class="text-xs text-white/95 font-mono truncate">${file.name}</p>
                        </div>
                    `;

                    // Remove handler
                    card.querySelector('.remove-photo-btn').addEventListener('click', function () {
                        // Rebuild DataTransfer omitting this file
                        const targetName = file.name;
                        const targetSize = file.size;
                        const newDt = new DataTransfer();
                        for (let i = 0; i < dt.files.length; i++) {
                            const cur = dt.files[i];
                            if (cur.name === targetName && cur.size === targetSize) {
                                continue;
                            }
                            newDt.items.add(cur);
                        }
                        // Replace dt contents
                        while (dt.items.length > 0) {
                            dt.items.remove(0);
                        }
                        for (let i = 0; i < newDt.files.length; i++) {
                            dt.items.add(newDt.files[i]);
                        }
                        fileInput.files = dt.files;

                        card.remove();
                        if (grid.children.length === 0) {
                            emptyState.classList.remove('hidden');
                        }
                    });

                    grid.appendChild(card);
                    emptyState.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            });

            fileInput.files = dt.files;
        });
    });
</script>
@endsection
