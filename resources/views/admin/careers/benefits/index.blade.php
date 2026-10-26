@extends('admin.layout')

@section('title', 'Work Culture & Benefits - Careers Page')
@section('header', 'Work Culture & Benefits')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Work Culture & Benefits</h2>
                <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                    {{ $totalCount }} {{ Str::plural('item', $totalCount) }}
                </div>
            </div>
            <p class="text-xs sm:text-sm text-slate-500">
                Manage the "Why Join JRS? / Work Culture & Benefits" cards displayed on the Careers page.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.careers-benefits.create') }}" class="inline-flex items-center justify-center rounded-md text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add Benefit Card</span>
            </a>
        </div>
    </div>

    <!-- Stats summary badges -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
            <div class="text-xs font-medium text-slate-500">Total Cards</div>
            <div class="text-2xl font-bold text-jrs-navy mt-1">{{ $totalCount }}</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
            <div class="text-xs font-medium text-slate-500">Active Online</div>
            <div class="text-2xl font-bold text-emerald-600 mt-1">{{ $activeCount }}</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
            <div class="text-xs font-medium text-slate-500">Section Badge</div>
            <div class="text-xs font-bold text-jrs-red mt-2 tracking-wide uppercase">WORK CULTURE & BENEFITS</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
            <div class="text-xs font-medium text-slate-500">Section Title</div>
            <div class="text-sm font-bold text-jrs-navy mt-1">Why Join <span class="text-jrs-red">JRS?</span></div>
        </div>
    </div>

    <!-- Table of Culture & Benefits -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-200 bg-slate-50/75 flex items-center justify-between">
            <h3 class="text-sm font-bold text-jrs-navy font-heading">Benefit Cards (Ordered)</h3>
            <span class="text-xs text-slate-500">Card icons render with high-contrast navy circle</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-14 text-center">Order</th>
                        <th class="h-10 px-4 w-20 text-center">Icon</th>
                        <th class="h-10 px-4 min-w-[200px]">Title & Badge</th>
                        <th class="h-10 px-4 min-w-[280px]">Description</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($benefits as $item)
                        <tr class="transition-colors hover:bg-slate-50/60 {{ $item->is_active ? '' : 'bg-slate-50/40 opacity-75' }}">
                            <!-- Order -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-md font-mono text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $item->sort_order }}
                                </span>
                            </td>

                            <!-- Icon (Rendered in navy circle like screenshot) -->
                            <td class="p-4 align-middle text-center">
                                <div class="w-10 h-10 mx-auto rounded-full bg-jrs-navy text-white flex items-center justify-center shadow-2xs">
                                    @if($item->icon === 'users')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    @elseif($item->icon === 'graduation-cap')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"/></svg>
                                    @elseif($item->icon === 'lightbulb')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                    @elseif($item->icon === 'star')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                    @elseif($item->icon === 'heart')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    @elseif($item->icon === 'trophy')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </div>
                            </td>

                            <!-- Title & Badge -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1">
                                    <div class="font-bold text-sm text-jrs-navy">
                                        {{ $item->title }}
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold text-slate-500 bg-slate-100 border border-slate-200">
                                        {{ $item->icon }}
                                    </span>
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="p-4 align-middle">
                                <p class="text-xs text-slate-600 leading-relaxed max-w-lg">
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
                            <td colspan="6" class="p-8 text-center text-slate-500">
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

    <!-- API Info Card (Read-Only GET) -->
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs">
        <div class="flex items-start justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase bg-emerald-100 text-emerald-800">
                        GET ONLY
                    </span>
                    <h4 class="text-sm font-bold text-jrs-navy font-heading">Frontend Public Endpoints</h4>
                </div>
                <p class="text-xs text-slate-500">
                    Your React frontend can fetch these cards directly via public read-only JSON endpoints:
                </p>
            </div>
            <a href="{{ route('admin.swagger') }}" class="text-xs font-semibold text-jrs-navy hover:text-jrs-red hover:underline">
                View Swagger Docs &rarr;
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4 text-xs font-mono">
            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 flex items-center justify-between">
                <div><span class="text-emerald-700 font-bold">GET</span> /api/careers/benefits</div>
                <span class="text-[10px] text-slate-400 font-sans">Returns cards list & metadata</span>
            </div>
            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 flex items-center justify-between">
                <div><span class="text-emerald-700 font-bold">GET</span> /api/careers-page</div>
                <span class="text-[10px] text-slate-400 font-sans">Full page bundle (Teaching + Benefits + Openings)</span>
            </div>
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
