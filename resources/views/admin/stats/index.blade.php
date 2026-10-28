@extends('admin.layout')

@section('title', 'Stats Section')
@section('header', 'Stats Section')

@section('content')
<div class="space-y-6">

    <!-- Top Action: Add Button (Aligned Right) -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.stats.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Stat</span>
        </a>
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
                <input type="text" name="search" value="{{ request('search') }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
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
                                @php
                                    $rawIcon = trim($stat->icon ?? '');
                                    $aliasMap = [
                                        'graduation-cap' => 'bi bi-mortarboard-fill',
                                        'users' => 'bi bi-people-fill',
                                        'award' => 'bi bi-award-fill',
                                        'trophy' => 'bi bi-trophy-fill',
                                        'book' => 'bi bi-book-half',
                                        'star' => 'bi bi-stars',
                                        'shield-check' => 'bi bi-shield-check',
                                    ];
                                    $iconClass = $aliasMap[$rawIcon] ?? (str_starts_with($rawIcon, 'bi ') || str_starts_with($rawIcon, 'fa-') ? $rawIcon : ('bi bi-' . $rawIcon));
                                    $badgeColor = $stat->color ?: '#eab308';
                                @endphp
                                <div class="inline-flex w-10 h-10 rounded-xl items-center justify-center text-white shadow-xs mx-auto text-lg transition-transform hover:scale-110" style="background-color: {{ $badgeColor }}">
                                    @if(str_contains($rawIcon, '<'))
                                        {!! $rawIcon !!}
                                    @elseif($rawIcon)
                                        <i class="{{ $iconClass }}"></i>
                                    @else
                                        <i class="bi bi-mortarboard-fill"></i>
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
                                @if($stat->icon)
                                    <span class="font-mono text-[11px] text-slate-400">icon: {{ $stat->icon }}</span>
                                @endif
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
                            <td colspan="6" class="p-8 text-center text-slate-500 text-xs sm:text-sm">
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
