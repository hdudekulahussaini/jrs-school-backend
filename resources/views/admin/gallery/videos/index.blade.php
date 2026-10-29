@extends('admin.layout')

@section('title', 'Gallery Videos | JRS School Admin')
@section('header', 'Gallery Videos')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500 font-semibold">Gallery</span>
                <span class="text-slate-300">/</span>
                <span class="text-xs text-slate-700 font-medium">Video Gallery</span>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">Gallery Videos</h2>
        </div>
    </div>

    <!-- Gallery Upload & Management Form -->
    <form action="{{ route('admin.gallery-videos.store') }}" method="POST" enctype="multipart/form-data" id="videosForm" class="space-y-6">
        @csrf

        <!-- Container for removed video IDs -->
        <div id="removedInputsContainer"></div>

        <!-- Container for dynamic video URL inputs -->
        <div id="urlInputsContainer"></div>

        <!-- Video Gallery Box -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">

            <!-- Section Header -->
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2.5 h-0.5 bg-rose-500 rounded-full inline-block"></span>
                        <span>VIDEO GALLERY</span>
                    </h3>
                    <p class="text-xs text-slate-500">
                        Upload gallery videos (MP4, WebM, MOV) or add video links. Each video can be added or removed individually.
                    </p>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <!-- Hidden file input for multi-video upload -->
                    <input type="file" id="videoFileInput" name="gallery_videos[]" multiple accept="video/mp4,video/webm,video/ogg,video/quicktime,video/x-matroska,video/*" class="hidden">

                    <!-- Add Video File Button -->
                    <button type="button" id="addVideoBtn" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-rose-200 bg-rose-50/70 hover:bg-rose-100 text-rose-700 text-xs font-semibold shadow-2xs transition-all cursor-pointer shrink-0">
                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>Upload Video</span>
                    </button>

                    <!-- Add Video URL Button -->
                    <button type="button" id="addUrlBtn" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold shadow-2xs transition-all cursor-pointer shrink-0">
                        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <span>Add Video Link</span>
                    </button>
                </div>
            </div>

            <!-- Videos Grid -->
            <div id="videosGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-5 pt-1">
                @foreach($items as $item)
                    @php
                        $isYoutube = $item->youtube_embed_url !== null;
                        $videoSrc = $item->video_full_url ?: $item->video_url;
                    @endphp
                    <div class="existing-video-card relative rounded-2xl overflow-hidden border border-slate-200/90 shadow-2xs bg-slate-950 flex flex-col transition-all" data-item-id="{{ $item->id }}">
                        
                        <!-- Remove button at top-right -->
                        <button type="button" onclick="removeExistingVideo({{ $item->id }}, this)" class="absolute top-2.5 right-2.5 z-20 inline-flex items-center gap-1 rounded-md bg-[#dc2626] hover:bg-red-700 text-white text-xs font-semibold px-2.5 py-1 shadow-sm transition-all cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>Remove</span>
                        </button>

                        <!-- Media Player Container -->
                        <div class="relative w-full aspect-video bg-black flex items-center justify-center">
                            @if($isYoutube)
                                <iframe src="{{ $item->youtube_embed_url }}" title="{{ $item->caption ?: 'Video' }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @elseif($videoSrc)
                                <video controls preload="metadata" class="w-full h-full object-contain bg-black">
                                    <source src="{{ $videoSrc }}" type="video/mp4">
                                    Your browser does not support HTML5 video.
                                </video>
                            @else
                                <div class="text-white/40 text-xs flex flex-col items-center gap-1">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    <span>No video file</span>
                                </div>
                            @endif
                        </div>

                        <!-- Caption / Details bar -->
                        <div class="px-4 py-2.5 bg-slate-900 border-t border-white/10 flex items-center justify-between gap-2">
                            <p class="text-xs font-medium text-white/90 truncate">
                                {{ $item->caption ?: basename($item->video_url ?: 'Video') }}
                            </p>
                            @if($isYoutube)
                                <span class="shrink-0 text-[10px] font-bold text-rose-400 uppercase tracking-wider bg-rose-500/10 px-2 py-0.5 rounded border border-rose-500/20">YouTube</span>
                            @else
                                <span class="shrink-0 text-[10px] font-bold text-emerald-400 uppercase tracking-wider bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">File</span>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Empty State Placeholder -->
            <div id="emptyVideosState" class="{{ $items->count() > 0 ? 'hidden' : '' }} py-14 text-center rounded-xl border border-dashed border-slate-200 bg-slate-50/50">
                <div class="max-w-xs mx-auto space-y-2">
                    <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 mx-auto flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">No videos added yet</p>
                    <p class="text-[11px] text-slate-400">Click "Upload Video" to select video files or "Add Video Link" to paste YouTube/Vimeo links.</p>
                </div>
            </div>

        </div>

        <!-- Sticky Form Footer -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-end">
            <button type="submit" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-6 py-2 gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span>Save Video Gallery</span>
            </button>
        </div>

    </form>

</div>

<!-- Modal for adding video URL -->
<div id="urlModal" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4 border border-slate-100">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-800">Add Video Link</h3>
            <button type="button" onclick="closeUrlModal()" class="text-slate-400 hover:text-slate-600 text-sm font-bold">&times;</button>
        </div>
        <p class="text-xs text-slate-500">
            Paste a YouTube URL (e.g. <span class="font-mono text-slate-600">https://www.youtube.com/watch?v=...</span>) or direct video link.
        </p>
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Video URL</label>
            <input type="url" id="modalUrlInput" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
        </div>
        <div class="flex items-center justify-end gap-2 pt-2">
            <button type="button" onclick="closeUrlModal()" class="px-3.5 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">
                Cancel
            </button>
            <button type="button" onclick="confirmAddUrl()" class="px-4 py-1.5 rounded-lg bg-jrs-red text-white text-xs font-semibold hover:opacity-95 cursor-pointer">
                Add to Gallery
            </button>
        </div>
    </div>
</div>

<script>
    const removedContainer = document.getElementById('removedInputsContainer');
    const urlContainer = document.getElementById('urlInputsContainer');
    const grid = document.getElementById('videosGrid');
    const emptyState = document.getElementById('emptyVideosState');
    const urlModal = document.getElementById('urlModal');
    const modalUrlInput = document.getElementById('modalUrlInput');

    function checkEmptyState() {
        if (grid.children.length === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    function removeExistingVideo(id, btn) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'removed_item_ids[]';
        input.value = id;
        removedContainer.appendChild(input);

        const card = btn.closest('.existing-video-card');
        if (card) {
            card.remove();
        }
        checkEmptyState();
    }

    function openUrlModal() {
        modalUrlInput.value = '';
        urlModal.classList.remove('hidden');
        setTimeout(() => modalUrlInput.focus(), 50);
    }

    function closeUrlModal() {
        urlModal.classList.add('hidden');
    }

    function getYoutubeId(url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[2].length === 11) ? match[2] : null;
    }

    function confirmAddUrl() {
        const url = modalUrlInput.value.trim();
        if (!url) return;

        const ytId = getYoutubeId(url);

        // Add hidden input to form
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'new_video_urls[]';
        input.value = url;
        urlContainer.appendChild(input);

        // Create card
        const card = document.createElement('div');
        card.className = 'new-url-card relative rounded-2xl overflow-hidden border border-slate-200/90 shadow-2xs bg-slate-950 flex flex-col transition-all animate-in fade-in duration-200';

        let playerHtml = '';
        if (ytId) {
            playerHtml = `<iframe src="https://www.youtube.com/embed/${ytId}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>`;
        } else {
            playerHtml = `<video controls preload="metadata" class="w-full h-full object-contain bg-black"><source src="${url}">Your browser does not support HTML5 video.</video>`;
        }

        card.innerHTML = `
            <button type="button" class="remove-url-btn absolute top-2.5 right-2.5 z-20 inline-flex items-center gap-1 rounded-md bg-[#dc2626] hover:bg-red-700 text-white text-xs font-semibold px-2.5 py-1 shadow-sm transition-all cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                <span>Remove</span>
            </button>
            <div class="relative w-full aspect-video bg-black flex items-center justify-center">
                ${playerHtml}
            </div>
            <div class="px-4 py-2.5 bg-slate-900 border-t border-white/10 flex items-center justify-between gap-2">
                <p class="text-xs font-medium text-white/90 truncate">${url}</p>
                <span class="shrink-0 text-[10px] font-bold text-amber-400 uppercase tracking-wider bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">Link</span>
            </div>
        `;

        card.querySelector('.remove-url-btn').addEventListener('click', function () {
            input.remove();
            card.remove();
            checkEmptyState();
        });

        grid.appendChild(card);
        closeUrlModal();
        checkEmptyState();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const addVideoBtn = document.getElementById('addVideoBtn');
        const addUrlBtn = document.getElementById('addUrlBtn');
        const fileInput = document.getElementById('videoFileInput');

        // Maintain list of newly uploaded files via DataTransfer
        const dt = new DataTransfer();

        addVideoBtn.addEventListener('click', function () {
            fileInput.click();
        });

        addUrlBtn.addEventListener('click', openUrlModal);

        fileInput.addEventListener('change', function () {
            const files = Array.from(fileInput.files);
            if (!files.length) return;

            files.forEach(file => {
                if (!file.type.startsWith('video/') && !file.name.match(/\.(mp4|webm|ogg|mov|mkv|m4v)$/i)) {
                    return;
                }

                dt.items.add(file);

                const blobUrl = URL.createObjectURL(file);
                const card = document.createElement('div');
                card.className = 'new-video-card relative rounded-2xl overflow-hidden border border-slate-200/90 shadow-2xs bg-slate-950 flex flex-col transition-all animate-in fade-in duration-200';

                card.innerHTML = `
                    <button type="button" class="remove-new-btn absolute top-2.5 right-2.5 z-20 inline-flex items-center gap-1 rounded-md bg-[#dc2626] hover:bg-red-700 text-white text-xs font-semibold px-2.5 py-1 shadow-sm transition-all cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Remove</span>
                    </button>
                    <div class="relative w-full aspect-video bg-black flex items-center justify-center">
                        <video controls preload="metadata" class="w-full h-full object-contain bg-black">
                            <source src="${blobUrl}">
                            Your browser does not support HTML5 video.
                        </video>
                    </div>
                    <div class="px-4 py-2.5 bg-slate-900 border-t border-white/10 flex items-center justify-between gap-2">
                        <p class="text-xs font-medium text-white/90 truncate">${file.name}</p>
                        <span class="shrink-0 text-[10px] font-bold text-emerald-400 uppercase tracking-wider bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">New File</span>
                    </div>
                `;

                card.querySelector('.remove-new-btn').addEventListener('click', function () {
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
                    while (dt.items.length > 0) {
                        dt.items.remove(0);
                    }
                    for (let i = 0; i < newDt.files.length; i++) {
                        dt.items.add(newDt.files[i]);
                    }
                    fileInput.files = dt.files;
                    URL.revokeObjectURL(blobUrl);

                    card.remove();
                    checkEmptyState();
                });

                grid.appendChild(card);
                checkEmptyState();
            });

            fileInput.files = dt.files;
        });
    });
</script>
@endsection
