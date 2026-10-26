@extends('admin.layout')

@section('title', 'Gallery Albums & Sections | JRS School Admin')
@section('header', 'Gallery Albums & Sections')

@section('content')
<div class="space-y-6">

    <!-- Top Breadcrumb & Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-heading">Gallery Albums & Sections</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-jrs-navy/10 text-jrs-navy">
                    {{ $totalCount }} {{ Str::plural('Album', $totalCount) }}
                </span>
            </div>
            <p class="text-sm text-slate-500">
                Manage all image and video showcase sections displayed on the public Gallery page.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.gallery-items.index') }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>View All Media ({{ $totalItemsCount }})</span>
            </a>
            <a href="{{ route('admin.gallery-albums.create') }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add Album Section</span>
            </a>
        </div>
    </div>

    <!-- Stats Pill Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Albums</p>
                <p class="text-2xl font-bold text-slate-900 mt-1 font-heading">{{ $totalCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>
        <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Active Status</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1 font-heading">{{ $activeCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
        <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Media Items</p>
                <p class="text-2xl font-bold text-jrs-navy mt-1 font-heading">{{ $totalItemsCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-jrs-navy flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <form action="{{ route('admin.gallery-albums.index') }}" method="GET" class="flex flex-wrap items-center gap-2 w-full sm:w-auto flex-1">
            <div class="relative w-full sm:w-80">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, badge, or description..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>

            <select name="media_type" onchange="this.form.submit()" class="h-9 px-3 text-xs rounded-md border border-slate-200 bg-white text-slate-700 shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                <option value="">All Media Types</option>
                <option value="image" {{ request('media_type') === 'image' ? 'selected' : '' }}>Photos (Images)</option>
                <option value="video" {{ request('media_type') === 'video' ? 'selected' : '' }}>Videos</option>
            </select>

            <select name="status" onchange="this.form.submit()" class="h-9 px-3 text-xs rounded-md border border-slate-200 bg-white text-slate-700 shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
            </select>

            @if(request('search') || request('media_type') || request('status'))
                <a href="{{ route('admin.gallery-albums.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-semibold border border-slate-200 bg-white px-3 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Albums Table List -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-semibold text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-28">Cover</th>
                        <th class="h-10 px-4 min-w-[260px]">Album Title & Header</th>
                        <th class="h-10 px-4 w-28 text-center">Type</th>
                        <th class="h-10 px-4 w-32 text-center">Media Items</th>
                        <th class="h-10 px-4 w-28 text-center">Status</th>
                        <th class="h-10 px-4 w-40 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($albums as $album)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="p-4 text-center font-mono font-bold text-xs text-slate-500">
                                #{{ $album->sort_order }}
                            </td>
                            <td class="p-4">
                                <div class="w-20 h-14 rounded-lg bg-slate-100 overflow-hidden border border-slate-200 relative group-hover:shadow-xs transition-shadow">
                                    @if($album->cover_full_url)
                                        <img src="{{ $album->cover_full_url }}" alt="{{ $album->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-50">
                                            <svg class="w-5 h-5 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="space-y-1">
                                    @if($album->badge)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase bg-red-50 text-jrs-red border border-red-100">
                                            {{ $album->badge }}
                                        </span>
                                    @endif
                                    <div class="font-bold text-slate-900 group-hover:text-jrs-red transition-colors text-sm font-heading">
                                        {{ $album->title }}
                                        @if($album->highlight_text)
                                            <span class="text-xs font-normal text-slate-400"> (Highlight: <span class="text-jrs-red font-semibold">"{{ $album->highlight_text }}"</span>)</span>
                                        @endif
                                    </div>
                                    @if($album->description)
                                        <p class="text-xs text-slate-500 line-clamp-1 max-w-xl">
                                            {{ $album->description }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                @if($album->media_type === 'video')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Video
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Photos
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.gallery-items.index', ['album_id' => $album->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 hover:bg-jrs-navy hover:text-white text-slate-700 transition-colors" title="Manage album photos/videos">
                                    <span>{{ $album->items_count }}</span>
                                    <span class="font-normal opacity-80">{{ Str::plural('item', $album->items_count) }}</span>
                                    <svg class="w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                            <td class="p-4 text-center">
                                <button type="button" 
                                        onclick="toggleAlbumStatus({{ $album->id }})" 
                                        id="album-status-btn-{{ $album->id }}"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer {{ $album->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $album->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span id="album-status-text-{{ $album->id }}">{{ $album->is_active ? 'Active' : 'Draft' }}</span>
                                </button>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.gallery-items.create', ['album_id' => $album->id]) }}" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-md transition-colors" title="Add photos/videos to this album">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    </a>
                                    <a href="{{ route('admin.gallery-albums.edit', $album->id) }}" class="p-1.5 text-slate-500 hover:text-jrs-navy hover:bg-slate-100 rounded-md transition-colors" title="Edit Album Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" 
                                            onclick="openDeleteModal({{ $album->id }}, '{{ addslashes($album->title) }}')"
                                            class="p-1.5 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-md transition-colors" 
                                            title="Delete Album">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-900">No gallery albums found</p>
                                    <p class="text-xs text-slate-500">Get started by creating your first photo or video album section.</p>
                                    <a href="{{ route('admin.gallery-albums.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold bg-jrs-red hover:opacity-95 text-white h-8 px-3">
                                        Create Album
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($albums->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $albums->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl border border-slate-200 space-y-4">
        <div class="flex items-center gap-3 text-jrs-red">
            <div class="p-2 rounded-full bg-red-50 border border-red-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-jrs-navy font-heading">Delete Album Section</h3>
        </div>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
            Are you sure you want to delete <span id="deleteItemTitle" class="font-bold text-slate-900"></span>? This will also remove all photos and videos attached to this album.
        </p>
        <div class="flex items-center justify-end gap-2.5 pt-2">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-xs font-semibold rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                Cancel
            </button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-xs font-semibold rounded-lg bg-jrs-red hover:opacity-95 text-white shadow-xs transition-colors">
                    Yes, Delete Album
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(id, title) {
    document.getElementById('deleteItemTitle').textContent = '"' + title + '"';
    document.getElementById('deleteForm').action = '/admin/gallery-albums/' + id;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function toggleAlbumStatus(id) {
    const btn = document.getElementById('album-status-btn-' + id);
    const txt = document.getElementById('album-status-text-' + id);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    btn.disabled = true;
    btn.classList.add('opacity-50');

    fetch('/admin/gallery-albums/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.classList.remove('opacity-50');
        if (data.success) {
            if (data.is_active) {
                btn.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100';
                btn.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span><span>Active</span>';
            } else {
                btn.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200';
                btn.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span><span>Draft</span>';
            }
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.classList.remove('opacity-50');
    });
}
</script>
@endsection
