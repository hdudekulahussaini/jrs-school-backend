@extends('admin.layout')

@section('title', 'Academic Journeys')
@section('header', 'Academics')

@section('content')
<div class="space-y-6">

    <!-- Top Action: Add Button (Aligned Right) -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.academic-journeys.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Journey Card</span>
        </a>
    </div>

    <!-- Toolbar: Tabs + Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Status Tabs -->
        <div class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 p-1 text-slate-500 w-full sm:w-auto">
            <a href="{{ route('admin.academic-journeys.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ !request('status') ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.academic-journeys.index', ['status' => 'active']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'active' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.academic-journeys.index', ['status' => 'inactive']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'inactive' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Disabled ({{ $inactiveCount }})
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.academic-journeys.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search journeys..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.academic-journeys.index', ['status' => request('status')]) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Journeys Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-28 text-center">Photo</th>
                        <th class="h-10 px-4 min-w-[200px]">Programme / Stage</th>
                        <th class="h-10 px-4 min-w-[160px]">Age Group Badge</th>
                        <th class="h-10 px-4 min-w-[260px]">Description</th>
                        <th class="h-10 px-4 w-28 text-center">Status</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($journeys as $item)
                        <tr class="transition-colors hover:bg-slate-50/60" id="journey-row-{{ $item->id }}">
                            <!-- Sort Order -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center justify-center font-mono text-xs font-semibold text-slate-500 bg-slate-100 rounded-md h-6 w-6">
                                    {{ $item->sort_order }}
                                </span>
                            </td>

                            <!-- Image Preview with Circular Icon Badge Overlay -->
                            <td class="p-4 align-middle text-center">
                                <div class="relative inline-block">
                                    @if($item->image_path)
                                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="w-20 h-14 rounded-lg object-cover border border-slate-200 shadow-2xs">
                                    @else
                                        <div class="w-20 h-14 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-xs font-medium">
                                            No Image
                                        </div>
                                    @endif
                                    <!-- Circular Blue Badge (matching design) -->
                                    <div class="absolute -bottom-1.5 -left-1.5 w-6 h-6 rounded-full bg-jrs-navy text-white flex items-center justify-center shadow-xs border-2 border-white">
                                        @if(Str::startsWith($item->icon ?? '', ['bi ', 'bi-', 'fa', 'fas ', 'far ']))
                                            <i class="{{ $item->icon }} text-[10px]"></i>
                                        @elseif($item->icon === 'baby')
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M12 13v8M9 17h6"/></svg>
                                        @elseif($item->icon === 'users')
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        @elseif($item->icon === 'sparkles')
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                                        @elseif($item->icon === 'heart')
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                                        @elseif($item->icon === 'book')
                                            <i class="bi bi-book-half text-[10px]"></i>
                                        @elseif($item->icon === 'award')
                                            <i class="bi bi-award-fill text-[10px]"></i>
                                        @else
                                            <i class="{{ $item->icon ? 'bi bi-' . $item->icon : 'bi bi-mortarboard-fill' }} text-[10px]"></i>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Title & Slug -->
                            <td class="p-4 align-middle">
                                <div class="font-bold text-sm text-jrs-navy">{{ $item->title }}</div>
                                <span class="font-mono text-[11px] text-slate-400">{{ $item->slug ?? Str::slug($item->title) }}</span>
                            </td>

                            <!-- Age Group Badge -->
                            <td class="p-4 align-middle">
                                @if($item->age_group)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold tracking-wider uppercase bg-amber-50 text-amber-800 border border-amber-200">
                                        {{ $item->age_group }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>

                            <!-- Description -->
                            <td class="p-4 align-middle">
                                <p class="text-xs text-slate-600 line-clamp-2 max-w-sm">
                                    {{ $item->description }}
                                </p>
                            </td>

                            <!-- Status Toggle -->
                            <td class="p-4 align-middle text-center">
                                <button type="button" 
                                        onclick="toggleJourneyStatus({{ $item->id }})" 
                                        id="status-btn-{{ $item->id }}"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span>{{ $item->is_active ? 'Active' : 'Disabled' }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.academic-journeys.show', $item->id) }}" class="p-1.5 text-slate-500 hover:text-jrs-navy hover:bg-slate-100 rounded-md transition-colors" title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.academic-journeys.edit', $item->id) }}" class="p-1.5 text-slate-500 hover:text-jrs-navy hover:bg-slate-100 rounded-md transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.academic-journeys.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this academic journey card?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-md transition-colors cursor-pointer" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500 text-xs sm:text-sm">
                                <div class="max-w-sm mx-auto space-y-2">
                                    <svg class="w-8 h-8 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                                    <p class="font-medium">No academic journey cards found.</p>
                                    <p class="text-xs text-slate-400">Click "Add Journey Card" above to create one.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($journeys->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $journeys->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function toggleJourneyStatus(id) {
    const btn = document.getElementById('status-btn-' + id);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    btn.disabled = true;
    btn.classList.add('opacity-50');

    fetch('/admin/academic-journeys/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.classList.remove('opacity-50');
        if (data.success) {
            if (data.is_active) {
                btn.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100';
                btn.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span><span>Active</span>';
            } else {
                btn.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200';
                btn.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span><span>Disabled</span>';
            }
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.classList.remove('opacity-50');
        console.error('Error toggling status:', err);
    });
}
</script>
@endsection
