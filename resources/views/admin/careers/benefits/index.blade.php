@extends('admin.layout')

@section('title', 'Work Culture & Benefits - Careers Page')
@section('header', 'Work Culture & Benefits')

@section('content')
<div class="space-y-6">

    <!-- Top Action: Add Button (Aligned Right) -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-jrs-navy font-heading">Work Culture & Benefits</h2>
            <p class="text-xs text-slate-500">Manage culture and benefit cards displayed on the Careers page.</p>
        </div>
        <a href="{{ route('admin.careers-benefits.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Benefit Card</span>
        </a>
    </div>

    <!-- Table of Culture & Benefits -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-200 bg-slate-50/75 flex items-center justify-between">
            <h3 class="text-sm font-bold text-jrs-navy font-heading">Benefit Cards</h3>
            <span class="text-xs text-slate-500">{{ $benefits->count() }} cards total</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-20 text-center">Icon</th>
                        <th class="h-10 px-4 min-w-[200px]">Heading</th>
                        <th class="h-10 px-4 min-w-[320px]">Description</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-28 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($benefits as $item)
                        <tr class="transition-colors hover:bg-slate-50/60 {{ $item->is_active ? '' : 'bg-slate-50/40 opacity-75' }}">
                            <!-- Icon (Remaining Pages Design) -->
                            <td class="p-4 align-middle text-center">
                                @php
                                    $rawIcon = trim($item->icon ?? '');
                                    $iconClass = $rawIcon;
                                    $aliasMap = [
                                        'users' => 'bi bi-people-fill',
                                        'graduation-cap' => 'bi bi-mortarboard-fill',
                                        'lightbulb' => 'bi bi-lightbulb-fill',
                                        'star' => 'bi bi-star-fill',
                                        'heart' => 'bi bi-heart-fill',
                                        'trophy' => 'bi bi-trophy-fill',
                                        'sparkles' => 'bi bi-stars',
                                        'shield-check' => 'bi bi-shield-check',
                                        'briefcase' => 'bi bi-briefcase-fill',
                                        'laptop' => 'bi bi-laptop',
                                    ];
                                    if (isset($aliasMap[$rawIcon])) {
                                        $iconClass = $aliasMap[$rawIcon];
                                    } elseif ($rawIcon && !str_contains($rawIcon, ' ') && !str_contains($rawIcon, '<')) {
                                        $iconClass = 'bi bi-' . $rawIcon;
                                    }
                                @endphp
                                <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-rose-50 border border-rose-200/80 text-rose-600 text-lg shadow-2xs">
                                    @if(str_starts_with($rawIcon, '<'))
                                        {!! $rawIcon !!}
                                    @else
                                        <i class="{{ $iconClass ?: 'bi bi-people-fill' }}"></i>
                                    @endif
                                </div>
                            </td>

                            <!-- Heading -->
                            <td class="p-4 align-middle">
                                <span class="font-bold text-sm text-jrs-navy">
                                    {{ $item->title }}
                                </span>
                            </td>

                            <!-- Description -->
                            <td class="p-4 align-middle">
                                <p class="text-xs text-slate-600 leading-relaxed max-w-xl">
                                    {{ $item->description }}
                                </p>
                            </td>

                            <!-- Status Toggle -->
                            <td class="p-4 align-middle text-center">
                                <form action="{{ route('admin.careers-benefits.toggle', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-colors cursor-pointer {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-300 hover:bg-slate-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                        <span>{{ $item->is_active ? 'Active' : 'Hidden' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.careers-benefits.edit', $item->id) }}" class="p-1.5 text-slate-500 hover:text-jrs-navy hover:bg-slate-100 rounded-md transition-colors" title="Edit Card">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" onclick="confirmDelete({{ $item->id }}, '{{ addslashes($item->title) }}')" class="p-1.5 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-md transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                <p class="text-sm font-medium">No Work Culture & Benefits cards found.</p>
                                <a href="{{ route('admin.careers-benefits.create') }}" class="mt-3 inline-flex items-center text-xs font-semibold text-jrs-red hover:underline">
                                    Add your first benefit card &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl border border-slate-200 space-y-4">
        <div class="flex items-center gap-3 text-jrs-red">
            <div class="p-2 rounded-full bg-red-50 border border-red-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-jrs-navy font-heading">Delete Benefit Card</h3>
        </div>
        <p class="text-sm text-slate-600">
            Are you sure you want to remove <span id="deleteItemTitle" class="font-semibold text-jrs-navy"></span>?
        </p>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-end gap-2.5 pt-2">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-xs font-semibold rounded-md border border-slate-200 text-slate-700 hover:bg-slate-50">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-xs font-semibold rounded-md bg-jrs-red text-white hover:opacity-90">
                    Yes, Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmDelete(id, title) {
        document.getElementById('deleteItemTitle').textContent = '"' + title + '"';
        document.getElementById('deleteForm').action = '/admin/careers-benefits/' + id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
