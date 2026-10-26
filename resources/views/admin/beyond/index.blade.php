@extends('admin.layout')

@section('title', 'Beyond Classroom Page')
@section('header', 'Beyond Classroom Page')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Beyond Classroom Page</h2>
                <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                    {{ $totalCount }} {{ Str::plural('activity', $totalCount) }}
                </div>
            </div>
            <p class="text-xs sm:text-sm text-slate-500">
                Manage co-curricular activities (Arts, Music, Dance, Karate, Yoga, Skating, Sports, Labs, Tours, Clubs) for the dedicated Beyond Classroom page.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.beyond-classrooms.create') }}" class="inline-flex items-center justify-center rounded-md text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add Activity</span>
            </a>
        </div>
    </div>

    <!-- Toolbar: Tabs + Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Status Tabs -->
        <div class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 p-1 text-slate-500 w-full sm:w-auto">
            <a href="{{ route('admin.beyond-classrooms.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ !request('status') ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.beyond-classrooms.index', ['status' => 'active']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'active' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.beyond-classrooms.index', ['status' => 'inactive']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'inactive' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Disabled ({{ $inactiveCount }})
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.beyond-classrooms.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search activities..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.beyond-classrooms.index', ['status' => request('status')]) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Beyond Classroom Activities Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-28">Photo</th>
                        <th class="h-10 px-4 min-w-[200px]">Activity & Category</th>
                        <th class="h-10 px-4 min-w-[160px]">Theme Color & Icon</th>
                        <th class="h-10 px-4 min-w-[220px]">Description</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($activities as $activity)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- Sort Order -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center justify-center font-mono text-xs font-semibold text-slate-500 bg-slate-100 rounded-md h-6 w-6">
                                    {{ $activity->sort_order }}
                                </span>
                            </td>

                            <!-- Image Thumbnail -->
                            <td class="p-4 align-middle">
                                <div class="relative w-20 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 shadow-2xs group cursor-pointer" onclick="openImageModal('{{ $activity->image_full_url ?? '' }}', '{{ addslashes($activity->title) }}')">
                                    @if($activity->image_full_url)
                                        <img src="{{ $activity->image_full_url }}" alt="{{ $activity->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-400 font-medium">No Photo</div>
                                    @endif
                                </div>
                            </td>

                            <!-- Activity Title & Category -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1">
                                    <div class="font-bold text-sm text-jrs-navy">{{ $activity->title }}</div>
                                    @if($activity->category)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold text-slate-600 bg-slate-100 border border-slate-200">
                                            {{ $activity->category }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Theme Color & Icon -->
                            <td class="p-4 align-middle">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full border border-slate-300 shadow-2xs shrink-0" style="background-color: {{ $activity->color ?? '#15803d' }}"></span>
                                    <span class="font-mono text-xs text-slate-600">{{ $activity->color ?? '#15803d' }}</span>
                                    <span class="px-2 py-0.5 rounded bg-slate-50 text-[11px] text-slate-500 border border-slate-200 font-mono">{{ $activity->icon ?? 'trophy' }}</span>
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="p-4 align-middle">
                                <p class="text-xs text-slate-600 line-clamp-2 max-w-sm">
                                    {{ $activity->description ?? '—' }}
                                </p>
                            </td>

                            <!-- Status Toggle -->
                            <td class="p-4 align-middle text-center">
                                <button type="button" 
                                        onclick="toggleStatus({{ $activity->id }}, this)" 
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer {{ $activity->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $activity->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span class="status-label">{{ $activity->is_active ? 'Active' : 'Disabled' }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.beyond-classrooms.show', $activity->id) }}" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.beyond-classrooms.edit', $activity->id) }}" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit Activity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" onclick="confirmDelete({{ $activity->id }}, '{{ addslashes($activity->title) }}')" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-red hover:bg-red-50 transition-colors cursor-pointer" title="Delete Activity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500">
                                <div class="max-w-sm mx-auto space-y-2">
                                    <svg class="w-10 h-10 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    <p class="text-sm font-semibold text-slate-700">No Beyond Classroom activities found</p>
                                    <p class="text-xs text-slate-500">Click "Add Activity" to create your first activity.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
            <div class="px-4 py-3 border-t border-slate-200 bg-slate-50">
                {{ $activities->links() }}
            </div>
        @endif
    </div>

    <!-- API Integration Information Card (GET only) -->
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs">
        <div class="flex items-start gap-3">
            <div class="p-2 rounded-lg bg-blue-50 text-blue-600 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="space-y-1.5 flex-1">
                <h4 class="text-sm font-bold text-jrs-navy font-heading">Frontend API Integration (Read-Only GET)</h4>
                <p class="text-xs text-slate-500">
                    The Beyond Classroom page on the React website fetches page details and active activities via these read-only GET endpoints:
                </p>
                <div class="flex flex-wrap gap-2 pt-1 font-mono text-xs">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-slate-100 text-slate-800 font-semibold border border-slate-200">
                        <span class="text-emerald-600 font-bold">GET</span> /api/beyond-classroom-page
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-slate-100 text-slate-800 font-semibold border border-slate-200">
                        <span class="text-emerald-600 font-bold">GET</span> /api/beyond-classrooms
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-slate-100 text-slate-800 font-semibold border border-slate-200">
                        <span class="text-emerald-600 font-bold">GET</span> /api/beyond
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-slate-100 text-slate-800 font-semibold border border-slate-200">
                        <span class="text-emerald-600 font-bold">GET</span> /api/beyond-classrooms/{id}
                    </span>
                </div>
            </div>
        </div>
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
                <h3 class="text-lg font-bold text-slate-900">Delete Beyond Classroom Activity</h3>
                <p class="text-sm text-slate-500 mt-1">Are you sure you want to delete <span id="deleteItemTitle" class="font-semibold text-slate-700"></span>? This action cannot be undone.</p>
            </div>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-2">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors cursor-pointer">Cancel</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-jrs-red hover:opacity-90 rounded-md transition-opacity shadow-xs cursor-pointer">Delete Activity</button>
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
    fetch(`/admin/beyond-classrooms/${id}/toggle`, {
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
    document.getElementById('deleteForm').action = `/admin/beyond-classrooms/${id}`;
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
