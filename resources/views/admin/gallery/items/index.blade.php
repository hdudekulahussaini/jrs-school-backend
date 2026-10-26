@extends('admin.layout')

@section('title', 'Gallery Media & Photos | JRS School Admin')
@section('header', 'Gallery Media & Photos')

@section('content')
<div class="space-y-6">

    <!-- Top Breadcrumb & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-heading">Gallery Media Items</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-jrs-navy/10 text-jrs-navy">
                    {{ $totalCount }} {{ Str::plural('Item', $totalCount) }}
                </span>
            </div>
            <p class="text-sm text-slate-500">
                Manage, organize, and upload photos & videos into albums across the school Gallery.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.gallery-albums.index') }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>Album Sections</span>
            </a>
            <a href="{{ route('admin.gallery-items.create', ['album_id' => request('album_id')]) }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Upload Photos / Videos</span>
            </a>
        </div>
    </div>

    <!-- Filter & Album Switcher Toolbar -->
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-xs space-y-3">
        <form action="{{ route('admin.gallery-items.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="w-full sm:w-64">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Filter by Album Section</label>
                <select name="album_id" onchange="this.form.submit()" class="h-9 px-3 w-full text-xs rounded-xl border border-slate-200 bg-slate-50 text-slate-800 font-semibold focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    <option value="">All Album Sections ({{ $albums->count() }})</option>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}" {{ request('album_id') == $album->id ? 'selected' : '' }}>
                            {{ $album->title }} ({{ $album->media_type === 'video' ? 'Videos' : 'Photos' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Search Caption</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search captions (e.g. Classroom, Walk Gallery)..." class="flex h-9 w-full rounded-xl border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                </div>
            </div>

            <div class="w-full sm:w-40">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Status</label>
                <select name="status" onchange="this.form.submit()" class="h-9 px-3 w-full text-xs rounded-xl border border-slate-200 bg-white text-slate-700 shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Draft / Inactive</option>
                </select>
            </div>

            @if(request('album_id') || request('search') || request('status'))
                <div class="pt-5">
                    <a href="{{ route('admin.gallery-items.index') }}" class="inline-flex items-center justify-center rounded-xl text-xs font-semibold border border-slate-200 bg-slate-100 hover:bg-slate-200 px-3 h-9 text-slate-600 transition-colors">
                        Reset Filters
                    </a>
                </div>
            @endif
        </form>

        @if($selectedAlbum)
            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-slate-700">Currently showing:</span>
                    <span class="font-bold text-jrs-navy font-heading">{{ $selectedAlbum->title }}</span>
                    @if($selectedAlbum->badge)
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-jrs-red uppercase">{{ $selectedAlbum->badge }}</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.gallery-albums.edit', $selectedAlbum->id) }}" class="text-xs font-semibold text-jrs-navy hover:underline">
                        Edit Album Header &rarr;
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Media Items Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($items as $item)
            <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col group">
                <!-- Media Preview -->
                <div class="relative aspect-4/3 bg-slate-100 overflow-hidden">
                    <img src="{{ $item->image_full_url }}" alt="{{ $item->caption ?? 'Gallery Item' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    
                    @if($item->video_url)
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center pointer-events-none">
                            <div class="w-9 h-9 rounded-full bg-white/90 text-jrs-red flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                    @endif

                    <div class="absolute top-2 left-2">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-mono font-bold bg-black/60 text-white backdrop-blur-xs">
                            #{{ $item->sort_order }}
                        </span>
                    </div>

                    <div class="absolute top-2 right-2">
                        <button type="button" 
                                onclick="toggleItemStatus({{ $item->id }})" 
                                id="item-status-dot-{{ $item->id }}"
                                title="Click to toggle status"
                                class="w-5 h-5 rounded-full flex items-center justify-center transition-transform hover:scale-110 shadow-xs {{ $item->is_active ? 'bg-emerald-500 text-white' : 'bg-slate-400 text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        </button>
                    </div>
                </div>

                <!-- Info & Actions Footer -->
                <div class="p-3 flex-1 flex flex-col justify-between space-y-2">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider truncate" title="{{ $item->album->title ?? '' }}">
                            {{ $item->album->title ?? 'Unassigned' }}
                        </p>
                        <p class="text-xs font-semibold text-slate-800 line-clamp-1 mt-0.5" title="{{ $item->caption }}">
                            {{ $item->caption ?: 'No caption' }}
                        </p>
                        @if($item->video_url)
                            <p class="text-[10px] text-purple-600 truncate mt-0.5 font-mono">
                                {{ $item->video_url }}
                            </p>
                        @endif
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                        <span id="item-status-text-{{ $item->id }}" class="text-[10px] font-bold uppercase tracking-wider {{ $item->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $item->is_active ? 'Active' : 'Draft' }}
                        </span>

                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.gallery-items.edit', $item->id) }}" class="p-1 text-slate-400 hover:text-jrs-navy hover:bg-slate-100 rounded transition-colors" title="Edit Item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <button type="button" 
                                    onclick="openDeleteItemModal({{ $item->id }}, '{{ addslashes($item->caption ?? 'Item #' . $item->id) }}')" 
                                    class="p-1 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded transition-colors" 
                                    title="Delete Item">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center">
                <div class="max-w-sm mx-auto space-y-3">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-900">No media items found</p>
                    <p class="text-xs text-slate-500">Upload photos or video links to populate this gallery album.</p>
                    <a href="{{ route('admin.gallery-items.create', ['album_id' => request('album_id')]) }}" class="inline-flex items-center justify-center rounded-xl text-xs font-semibold bg-jrs-red hover:opacity-95 text-white h-9 px-4">
                        Upload Media
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($items->hasPages())
        <div class="p-4 rounded-2xl border border-slate-200 bg-white shadow-xs">
            {{ $items->links() }}
        </div>
    @endif

</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl border border-slate-200 space-y-4">
        <div class="flex items-center gap-3 text-jrs-red">
            <div class="p-2 rounded-full bg-red-50 border border-red-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-jrs-navy font-heading">Delete Media Item</h3>
        </div>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
            Are you sure you want to delete <span id="deleteItemTitle" class="font-bold text-slate-900"></span>? The uploaded file will be permanently removed.
        </p>
        <div class="flex items-center justify-end gap-2.5 pt-2">
            <button type="button" onclick="closeDeleteItemModal()" class="px-4 py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                Cancel
            </button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-xs font-semibold rounded-lg bg-jrs-red hover:opacity-95 text-white shadow-xs transition-colors">
                    Yes, Delete Item
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteItemModal(id, title) {
    document.getElementById('deleteItemTitle').textContent = '"' + title + '"';
    document.getElementById('deleteForm').action = '/admin/gallery-items/' + id;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteItemModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function toggleItemStatus(id) {
    const dot = document.getElementById('item-status-dot-' + id);
    const txt = document.getElementById('item-status-text-' + id);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/admin/gallery-items/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            if (data.is_active) {
                dot.className = 'w-5 h-5 rounded-full flex items-center justify-center transition-transform hover:scale-110 shadow-xs bg-emerald-500 text-white';
                if (txt) {
                    txt.textContent = 'Active';
                    txt.className = 'text-[10px] font-bold uppercase tracking-wider text-emerald-600';
                }
            } else {
                dot.className = 'w-5 h-5 rounded-full flex items-center justify-center transition-transform hover:scale-110 shadow-xs bg-slate-400 text-white';
                if (txt) {
                    txt.textContent = 'Draft';
                    txt.className = 'text-[10px] font-bold uppercase tracking-wider text-slate-400';
                }
            }
        }
    });
}
</script>
@endsection
