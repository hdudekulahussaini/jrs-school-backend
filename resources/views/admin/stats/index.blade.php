@extends('admin.layout')

@section('title', 'Stats Section')
@section('header', 'Stats Section')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Stats Section</h2>
                <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                    {{ $totalCount }} {{ Str::plural('stat', $totalCount) }}
                </div>
            </div>
            <p class="text-xs sm:text-sm text-slate-500">
                Manage the key impact metrics & achievements displayed on the homepage (e.g. 2021 Year of Establishment, 1000+ Happy Students, 50+ Experienced Faculty).
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.stats.create') }}" class="inline-flex items-center justify-center rounded-md text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add Stat</span>
            </a>
        </div>
    </div>

    <!-- Toolbar: Tabs + Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Status Tabs -->
        <div class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 p-1 text-slate-500 w-full sm:w-auto">
            <a href="{{ route('admin.stats.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ !request('status') ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.stats.index', ['status' => 'active']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'active' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.stats.index', ['status' => 'inactive']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'inactive' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Disabled ({{ $inactiveCount }})
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.stats.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search stats..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.stats.index', ['status' => request('status')]) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Stats Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-20 text-center">Icon</th>
                        <th class="h-10 px-4 w-32 font-bold text-slate-700">Value</th>
                        <th class="h-10 px-4 min-w-[200px]">Metric Label / Title</th>
                        <th class="h-10 px-4 min-w-[220px]">Description</th>
                        <th class="h-10 px-4 w-28 text-center">Status</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($stats as $stat)
                        <tr class="transition-colors hover:bg-slate-50/60" id="stat-row-{{ $stat->id }}">
                            <!-- Sort Order -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center justify-center font-mono text-xs font-semibold text-slate-500 bg-slate-100 rounded-md h-6 w-6">
                                    {{ $stat->sort_order }}
                                </span>
                            </td>

                            <!-- Icon Preview -->
                            <td class="p-4 align-middle text-center">
                                <div class="inline-flex w-10 h-10 rounded-xl items-center justify-center text-amber-500 bg-amber-50 border border-amber-200 shadow-2xs mx-auto">
                                    @if($stat->icon === 'graduation-cap')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                    @elseif($stat->icon === 'users')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    @elseif($stat->icon === 'award')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="8" r="6"/><path stroke-linecap="round" stroke-linejoin="round" d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                                    @elseif($stat->icon === 'trophy')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8m-4-4v4M5 4h14a2 2 0 012 2v2a5 5 0 01-5 5h-8a5 5 0 01-5-5V6a2 2 0 012-2zm-3 4h3m14 0h3"/></svg>
                                    @elseif($stat->icon === 'book')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    @endif
                                </div>
                            </td>

                            <!-- Value -->
                            <td class="p-4 align-middle">
                                <span class="font-extrabold text-base font-heading text-jrs-navy tracking-tight px-2.5 py-1 bg-slate-100 rounded-md inline-block">
                                    {{ $stat->value }}
                                </span>
                            </td>

                            <!-- Title / Label -->
                            <td class="p-4 align-middle">
                                <div class="font-bold text-sm text-jrs-navy">{{ $stat->title }}</div>
                                <span class="font-mono text-[11px] text-slate-400">icon: {{ $stat->icon ?? 'graduation-cap' }}</span>
                            </td>

                            <!-- Description -->
                            <td class="p-4 align-middle">
                                <p class="text-xs text-slate-600 line-clamp-2 max-w-sm">
                                    {{ $stat->description ?? '—' }}
                                </p>
                            </td>

                            <!-- Status Toggle -->
                            <td class="p-4 align-middle text-center">
                                <button type="button" 
                                        onclick="toggleStatStatus({{ $stat->id }})" 
                                        id="status-btn-{{ $stat->id }}"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer {{ $stat->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $stat->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span>{{ $stat->is_active ? 'Active' : 'Disabled' }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.stats.edit', $stat->id) }}" class="p-1.5 text-slate-500 hover:text-jrs-navy hover:bg-slate-100 rounded-md transition-colors" title="Edit Stat">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.stats.destroy', $stat->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this stat card?');" class="inline">
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
                                    <svg class="w-8 h-8 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    <p class="font-medium">No stats cards found.</p>
                                    <p class="text-xs text-slate-400">Click "Add Stat" above to add your first counter metric.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($stats->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $stats->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function toggleStatStatus(id) {
    const btn = document.getElementById('status-btn-' + id);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    btn.disabled = true;
    btn.classList.add('opacity-50');

    fetch('/admin/stats/' + id + '/toggle', {
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
