@extends('admin.layout')

@section('title', 'Key Features')
@section('header', 'Key Features')

@section('content')
<div class="space-y-6">

    <!-- Top Action: Add Button (Aligned Right) -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.features.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Feature</span>
        </a>
    </div>

    <!-- Toolbar: Tabs + Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Status Tabs -->
        <div class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 p-1 text-slate-500 w-full sm:w-auto">
            <a href="{{ route('admin.features.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ !request('status') ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.features.index', ['status' => 'active']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'active' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.features.index', ['status' => 'inactive']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'inactive' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Disabled ({{ $inactiveCount }})
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.features.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search features..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.features.index', ['status' => request('status')]) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Features Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-24 text-center">Icon Badge</th>
                        <th class="h-10 px-4 min-w-[200px]">Feature Title</th>
                        <th class="h-10 px-4 min-w-[260px]">Description</th>
                        <th class="h-10 px-4 w-28">Color Code</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($features as $feature)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- Sort Order -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center justify-center font-mono text-xs font-semibold text-slate-500 bg-slate-100 rounded-md h-6 w-6">
                                    {{ $feature->sort_order }}
                                </span>
                            </td>

                            <!-- Icon Badge Preview -->
                            <td class="p-4 align-middle text-center">
                                @php
                                    $rawIcon = trim($feature->icon ?? '');
                                    $aliasMap = [
                                        'graduation-cap' => 'bi bi-mortarboard-fill',
                                        'sparkles' => 'bi bi-stars',
                                        'award' => 'bi bi-award-fill',
                                        'shield-check' => 'bi bi-shield-check',
                                        'building-2' => 'bi bi-buildings-fill',
                                        'building' => 'bi bi-buildings-fill',
                                        'book' => 'bi bi-book-half',
                                        'users' => 'bi bi-people-fill',
                                        'trophy' => 'bi bi-trophy-fill',
                                        'heart' => 'bi bi-heart-pulse-fill',
                                    ];
                                    $iconClass = $aliasMap[$rawIcon] ?? (str_starts_with($rawIcon, 'bi ') || str_starts_with($rawIcon, 'fa-') ? $rawIcon : ('bi bi-' . $rawIcon));
                                    $badgeColor = $feature->color ?: '#e31e24';
                                @endphp
                                <div class="inline-flex w-10 h-10 rounded-xl items-center justify-center text-white shadow-xs mx-auto text-lg transition-transform hover:scale-110" style="background-color: {{ $badgeColor }}">
                                    @if(str_contains($rawIcon, '<'))
                                        {!! $rawIcon !!}
                                    @elseif($rawIcon)
                                        <i class="{{ $iconClass }}"></i>
                                    @else
                                        <i class="bi bi-stars"></i>
                                    @endif
                                </div>
                            </td>

                            <!-- Title -->
                            <td class="p-4 align-middle">
                                <div class="font-bold text-sm text-jrs-navy">{{ $feature->title }}</div>
                                @if($feature->icon)
                                    <span class="font-mono text-[11px] text-slate-400">icon: {{ $feature->icon }}</span>
                                @endif
                            </td>

                            <!-- Description -->
                            <td class="p-4 align-middle">
                                @if($feature->description)
                                    <p class="text-xs text-slate-600 line-clamp-2 max-w-sm">
                                        {{ $feature->description }}
                                    </p>
                                @endif
                            </td>

                            <!-- Color Swatch -->
                            <td class="p-4 align-middle">
                                @if($feature->color)
                                    <div class="flex items-center gap-2">
                                        <span class="w-3.5 h-3.5 rounded-full border border-slate-300 shrink-0 shadow-2xs" style="background-color: {{ $feature->color }}"></span>
                                        <span class="font-mono text-xs text-slate-600">{{ $feature->color }}</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Status Toggle -->
                            <td class="p-4 align-middle text-center">
                                <button type="button" 
                                        onclick="toggleStatus({{ $feature->id }}, this)" 
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer {{ $feature->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $feature->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span class="status-label">{{ $feature->is_active ? 'Active' : 'Disabled' }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.features.edit', $feature->id) }}" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit Feature">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" onclick="confirmDelete({{ $feature->id }}, '{{ addslashes($feature->title) }}')" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-red hover:bg-red-50 transition-colors cursor-pointer" title="Delete Feature">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500">
                                <div class="max-w-sm mx-auto space-y-2">
                                    <svg class="w-10 h-10 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <p class="text-sm font-semibold text-slate-700">No feature cards found</p>
                                    <p class="text-xs text-slate-500">Click "Add Feature" to create your first card.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($features->hasPages())
            <div class="px-4 py-3 border-t border-slate-200 bg-slate-50">
                {{ $features->links() }}
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
                <h3 class="text-lg font-bold text-slate-900">Delete Key Feature</h3>
                <p class="text-sm text-slate-500 mt-1">Are you sure you want to delete <span id="deleteItemTitle" class="font-semibold text-slate-700"></span>? This action cannot be undone.</p>
            </div>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-2">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors cursor-pointer">Cancel</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-jrs-red hover:opacity-90 rounded-md transition-opacity shadow-xs cursor-pointer">Delete Feature</button>
            </form>
        </div>
    </div>
</div>

<script>
function toggleStatus(id, btn) {
    fetch(`/admin/features/${id}/toggle`, {
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
    document.getElementById('deleteForm').action = `/admin/features/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
