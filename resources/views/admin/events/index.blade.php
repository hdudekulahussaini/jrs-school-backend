@extends('admin.layout')

@section('title', 'Latest Events')
@section('header', 'Latest Events')

@section('content')
<div class="space-y-6">

    <!-- Top Action: Add Button (Aligned Right) -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Event</span>
        </a>
    </div>

    <!-- Toolbar: Tabs + Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Status Tabs -->
        <div class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 p-1 text-slate-500 w-full sm:w-auto">
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ !request('status') ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.events.index', ['status' => 'active']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'active' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.events.index', ['status' => 'inactive']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'inactive' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Disabled ({{ $inactiveCount }})
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.events.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.events.index', ['status' => request('status')]) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Events Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-28">Date Badge</th>
                        <th class="h-10 px-4 w-32">Photo</th>
                        <th class="h-10 px-4 min-w-[200px]">Event Title</th>
                        <th class="h-10 px-4 min-w-[240px]">Description</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($events as $event)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- Sort Order -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center justify-center font-mono text-xs font-semibold text-slate-500 bg-slate-100 rounded-md h-6 w-6">
                                    {{ $event->sort_order }}
                                </span>
                            </td>

                            <!-- Date Badge -->
                            <td class="p-4 align-middle">
                                <div class="inline-flex flex-col items-center justify-center bg-white border border-slate-200 rounded-xl px-2.5 py-1 shadow-xs text-center min-w-[50px]">
                                    <span class="text-base font-extrabold text-jrs-red leading-tight">{{ $event->display_day }}</span>
                                    <span class="text-[10px] font-bold text-jrs-navy uppercase tracking-wider">{{ $event->display_month }}</span>
                                </div>
                            </td>

                            <!-- Image Thumbnail -->
                            <td class="p-4 align-middle">
                                <div class="relative w-24 h-16 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 shadow-2xs group cursor-pointer" onclick="openImageModal('{{ $event->image_full_url ?? '' }}', '{{ addslashes($event->title) }}')">
                                    @if($event->image_full_url)
                                        <img src="{{ $event->image_full_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Event Title -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1">
                                    <div class="font-bold text-sm text-jrs-navy">{{ $event->title }}</div>
                                    @if($event->event_date)
                                        <div class="text-[11px] text-slate-400 flex items-center gap-1 font-mono">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span>{{ $event->event_date->format('F d, Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="p-4 align-middle">
                                @if($event->description)
                                    <p class="text-xs text-slate-600 line-clamp-2 max-w-sm">
                                        {{ $event->description }}
                                    </p>
                                @endif
                            </td>

                            <!-- Status Toggle -->
                            <td class="p-4 align-middle text-center">
                                <button type="button" 
                                        onclick="toggleStatus({{ $event->id }}, this)" 
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer {{ $event->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $event->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span class="status-label">{{ $event->is_active ? 'Active' : 'Disabled' }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit Event">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" onclick="confirmDelete({{ $event->id }}, '{{ addslashes($event->title) }}')" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-red hover:bg-red-50 transition-colors cursor-pointer" title="Delete Event">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500">
                                <div class="max-w-sm mx-auto space-y-2">
                                    <svg class="w-10 h-10 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-sm font-semibold text-slate-700">No events found</p>
                                    <p class="text-xs text-slate-500">Click "Add Event" to create your first school event.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
            <div class="px-4 py-3 border-t border-slate-200 bg-slate-50">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="w-12 h-12 rounded-full bg-red-100 text-jrs-red flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900">Delete Event</h3>
                <p class="text-sm text-slate-500 mt-1">Are you sure you want to delete <span id="deleteItemTitle" class="font-semibold text-slate-700"></span>? This action cannot be undone.</p>
            </div>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-2">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors cursor-pointer">Cancel</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-jrs-red hover:opacity-90 rounded-md transition-opacity shadow-xs cursor-pointer">Delete Event</button>
            </form>
        </div>
    </div>
</div>

<!-- Image Zoom Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-xs flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-3xl w-full bg-transparent p-2" onclick="event.stopPropagation()">
        <img id="modalImage" src="" alt="" class="w-full max-h-[80vh] object-contain rounded-lg shadow-2xl">
        <p id="modalCaption" class="text-white text-center mt-3 text-sm font-medium"></p>
        <button type="button" onclick="closeImageModal()" class="absolute top-4 right-4 text-white/80 hover:text-white bg-black/40 rounded-full p-1 cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>

<script>
function toggleStatus(id, btn) {
    fetch(`/admin/events/${id}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const label = btn.querySelector('.status-label');
            const dot = btn.querySelector('span');
            if (data.is_active) {
                btn.className = 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100';
                dot.className = 'w-1.5 h-1.5 rounded-full mr-1.5 bg-emerald-500';
                label.textContent = 'Active';
            } else {
                btn.className = 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200';
                dot.className = 'w-1.5 h-1.5 rounded-full mr-1.5 bg-slate-400';
                label.textContent = 'Disabled';
            }
        }
    })
    .catch(err => console.error('Status toggle error:', err));
}

function confirmDelete(id, title) {
    document.getElementById('deleteItemTitle').textContent = `"${title}"`;
    document.getElementById('deleteForm').action = `/admin/events/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function openImageModal(url, caption) {
    if (!url) return;
    document.getElementById('modalImage').src = url;
    document.getElementById('modalCaption').textContent = caption;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}
</script>
@endsection
