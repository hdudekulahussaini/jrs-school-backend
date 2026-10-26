@extends('admin.layout')

@section('title', 'Amenities CTA Banner - Campus Amenities')
@section('header', 'Amenities CTA Banner')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Amenities CTA Banner</h2>
                <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                    {{ $totalCount }} {{ Str::plural('banner', $totalCount) }}
                </div>
            </div>
            <p class="text-xs sm:text-sm text-slate-500">
                Manage the "Join The JRS Journey — We Invite Everyone To Join Us On Our Journey Towards Excellence" CTA banner on the Amenities page.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.amenities-cta.create') }}" class="inline-flex items-center justify-center rounded-md text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>New CTA Banner</span>
            </a>
        </div>
    </div>

    <!-- Stats summary badges -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
            <div class="text-xs font-medium text-slate-500">Banner Eyebrow</div>
            <div class="text-xs font-bold text-amber-500 mt-2 tracking-wide uppercase">JOIN THE JRS JOURNEY</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
            <div class="text-xs font-medium text-slate-500">Primary Button</div>
            <div class="text-xs font-mono font-bold text-jrs-red mt-2 flex items-center gap-1">
                <span>Book a Campus Tour &rarr;</span>
            </div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
            <div class="text-xs font-medium text-slate-500">Secondary Button</div>
            <div class="text-xs font-mono font-bold text-slate-700 mt-2">Contact School</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
            <div class="text-xs font-medium text-slate-500">Active Status</div>
            <div class="text-xs font-bold text-emerald-600 mt-2 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ $activeCta ? 'Live on Amenities Page' : 'None Active' }}</span>
            </div>
        </div>
    </div>

    <!-- CTA Banners Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-200 bg-slate-50/75 flex items-center justify-between">
            <h3 class="text-sm font-bold text-jrs-navy font-heading">All Amenities CTA Banner Variations</h3>
            <span class="text-xs text-slate-500">Only one banner is set to Active on the Amenities page at a time</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-28">Artwork</th>
                        <th class="h-10 px-4 min-w-[260px]">Badge & Headline</th>
                        <th class="h-10 px-4 min-w-[240px]">Description Excerpt</th>
                        <th class="h-10 px-4 min-w-[180px]">Action Buttons</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($ctas as $item)
                        <tr class="transition-colors hover:bg-slate-50/60 {{ $item->is_active ? 'bg-emerald-50/20' : 'opacity-80' }}">
                            <!-- Artwork Thumbnail -->
                            <td class="p-4 align-middle">
                                <div class="relative w-24 h-12 rounded-md overflow-hidden border border-slate-200 bg-slate-900 shadow-2xs group cursor-pointer" onclick="openImageModal('{{ $item->image_full_url }}', '{{ addslashes($item->title) }}')">
                                    <img src="{{ $item->image_full_url }}" alt="CTA" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                </div>
                            </td>

                            <!-- Badge & Headline -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase text-amber-600 bg-amber-50 border border-amber-200">
                                        {{ $item->badge }}
                                    </span>
                                    <div class="font-bold text-sm text-jrs-navy leading-snug">
                                        {{ $item->title }}
                                        @if($item->highlight_text)
                                            <span class="text-amber-500">({{ $item->highlight_text }})</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="p-4 align-middle">
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed max-w-sm">
                                    {{ $item->description }}
                                </p>
                            </td>

                            <!-- Action Buttons -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1 text-xs">
                                    <div class="flex items-center gap-1.5 font-mono text-slate-800">
                                        <span class="w-2 h-2 rounded-full bg-jrs-red"></span>
                                        <span>{{ $item->primary_button_text }}</span>
                                    </div>
                                    @if($item->secondary_button_text)
                                        <div class="flex items-center gap-1.5 font-mono text-slate-500">
                                            <span class="w-2 h-2 rounded-full bg-slate-600"></span>
                                            <span>{{ $item->secondary_button_text }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Status Toggle -->
                            <td class="p-4 align-middle text-center">
                                <form action="{{ route('admin.amenities-cta.toggle', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-colors cursor-pointer {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-300 hover:bg-slate-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                        <span>{{ $item->is_active ? 'Active' : 'Disabled' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.amenities-cta.edit', $item->id) }}" class="p-1.5 text-slate-500 hover:text-jrs-navy hover:bg-slate-100 rounded-md transition-colors" title="Edit Banner">
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
                                <p class="text-sm font-medium">No Amenities CTA banner found.</p>
                                <a href="{{ route('admin.amenities-cta.create') }}" class="mt-3 inline-flex items-center text-xs font-semibold text-jrs-red hover:underline">
                                    Create first CTA banner &rarr;
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
            <h3 class="text-lg font-bold text-jrs-navy font-heading">Delete CTA Banner</h3>
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

<!-- Image Preview Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-3xl w-full bg-slate-900 rounded-2xl overflow-hidden border border-white/10 shadow-2xl" onclick="event.stopPropagation()">
        <div class="p-3 border-b border-white/10 flex items-center justify-between text-white">
            <span id="imageModalTitle" class="text-xs font-medium truncate"></span>
            <button type="button" onclick="closeImageModal()" class="p-1 rounded-md text-white/60 hover:text-white hover:bg-white/10">&times;</button>
        </div>
        <img id="imageModalImg" src="" alt="Preview" class="w-full max-h-[80vh] object-contain bg-slate-950">
    </div>
</div>

<script>
    function confirmDelete(id, title) {
        document.getElementById('deleteItemTitle').textContent = '"' + title + '"';
        document.getElementById('deleteForm').action = '/admin/amenities-cta/' + id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    function openImageModal(url, title) {
        document.getElementById('imageModalImg').src = url;
        document.getElementById('imageModalTitle').textContent = title;
        document.getElementById('imageModal').classList.remove('hidden');
    }
    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }
</script>
@endsection
