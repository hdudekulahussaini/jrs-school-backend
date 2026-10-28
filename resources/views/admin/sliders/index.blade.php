@extends('admin.layout')

@section('title', 'Hero Sliders')
@section('header', 'Hero Sliders')

@section('content')
<div class="space-y-6">

    <!-- Top Action: Add Button (Aligned Right) -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.sliders.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Hero Slide</span>
        </a>
    </div>

    <!-- Toolbar: Tabs + Search (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Status Tabs (shadcn/ui TabsList) -->
        <div class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 p-1 text-slate-500 w-full sm:w-auto">
            <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 {{ !request('status') ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.sliders.index', ['status' => 'active']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 {{ request('status') === 'active' ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.sliders.index', ['status' => 'inactive']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 {{ request('status') === 'inactive' ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Disabled ({{ $inactiveCount }})
            </a>
        </div>

        <!-- Search Input (shadcn/ui Input) -->
        <form action="{{ route('admin.sliders.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.sliders.index', ['status' => request('status')]) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card (shadcn/ui Card + Table) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-28">Preview</th>
                        <th class="h-10 px-4 min-w-[240px]">Content & Typography</th>
                        <th class="h-10 px-4 min-w-[160px]">Action Buttons</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($sliders as $slider)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- Sort Order -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center justify-center font-mono text-xs font-semibold text-slate-500 bg-slate-100 rounded-md h-6 w-6">
                                    {{ $slider->sort_order }}
                                </span>
                            </td>

                            <!-- Image Thumbnail -->
                            <td class="p-4 align-middle">
                                @if($slider->image_full_url)
                                    <div class="w-20 h-12 rounded-md overflow-hidden border border-slate-200 bg-slate-100 relative group cursor-pointer shadow-2xs" onclick="openImageModal('{{ $slider->image_full_url }}', '{{ addslashes($slider->title) }}')">
                                        <img src="{{ $slider->image_full_url }}" alt="{{ $slider->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity text-white">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-20 h-12 rounded-md border border-dashed border-slate-200 bg-slate-50"></div>
                                @endif
                            </td>

                            <!-- Title & Subtitle Content -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1">
                                    @if($slider->badge_title)
                                        <div class="inline-flex items-center rounded-md border border-slate-200 bg-slate-50 px-2 py-0.5 text-[10px] font-semibold text-slate-600 tracking-wide uppercase">
                                            {{ $slider->badge_title }}
                                        </div>
                                    @endif
                                    <div class="font-semibold text-slate-900 leading-snug">
                                        {{ $slider->title }}
                                        @if($slider->highlight_text)
                                            <span class="text-amber-600 font-bold ml-1">{{ $slider->highlight_text }}</span>
                                        @endif
                                    </div>
                                    @if($slider->description)
                                        <p class="text-xs text-slate-500 line-clamp-1 max-w-md">
                                            {{ $slider->description }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            <!-- Action Buttons -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1.5 text-xs">
                                    @if($slider->primary_button_text)
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                            <span class="font-medium text-slate-800">{{ $slider->primary_button_text }}</span>
                                        </div>
                                    @endif

                                    @if($slider->secondary_button_text)
                                        <div class="flex items-center gap-1.5 text-slate-500">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            <span>{{ $slider->secondary_button_text }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Status (shadcn/ui Badge) -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-xs font-medium {{ $slider->is_active ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-slate-100 text-slate-600' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $slider->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span>{{ $slider->is_active ? 'Active' : 'Disabled' }}</span>
                                </span>
                            </td>

                            <!-- Actions (shadcn/ui Ghost / Outline Buttons) -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.sliders.edit', $slider->id) }}" title="Edit slide" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-slate-100 hover:text-slate-900 h-8 w-8 text-slate-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <button type="button" onclick="confirmDelete({{ $slider->id }}, '{{ addslashes($slider->title) }}')" title="Delete slide" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-red-50 hover:text-red-600 h-8 w-8 text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-500">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-10 h-10 rounded-full border border-slate-200 bg-slate-50 text-slate-400 mx-auto flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="font-medium text-slate-900 text-sm">No hero slides found</p>
                                        <p class="text-xs text-slate-500">Get started by creating your first hero slider slide.</p>
                                    </div>
                                    <a href="{{ route('admin.sliders.create') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium bg-slate-900 text-white shadow hover:bg-slate-800 h-8 px-3">
                                        Add First Slide
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sliders->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                {{ $sliders->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Delete Confirmation Dialog (shadcn/ui AlertDialog) -->
<div id="deleteModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-lg border border-slate-200 max-w-md w-full p-6 shadow-lg space-y-4">
        <div class="space-y-2">
            <h4 class="text-lg font-semibold leading-none tracking-tight text-slate-900">Are you absolutely sure?</h4>
            <p class="text-sm text-slate-500 leading-relaxed">
                This action cannot be undone. This will permanently delete slide <strong id="deleteSlideTitle" class="text-slate-900"></strong> and remove its image from the server.
            </p>
        </div>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeDeleteModal()" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 h-9 px-4 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-red-600 text-white shadow-xs hover:bg-red-700 h-9 px-4 transition-colors">
                    Continue
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Image Lightbox Modal (shadcn/ui Dialog) -->
<div id="imageLightboxModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-xs hidden items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-3xl max-h-[90vh] p-2 bg-slate-950 rounded-xl border border-slate-800 shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
        <img id="lightboxImg" src="" alt="Slide Preview" class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
        <div class="p-3 text-white text-xs font-medium flex items-center justify-between">
            <span id="lightboxCaption" class="truncate font-mono text-slate-300"></span>
            <button onclick="closeImageModal()" class="inline-flex items-center justify-center rounded-md border border-slate-700 text-xs text-slate-300 hover:text-white hover:bg-slate-800 px-3 py-1 transition-colors">Close (Esc)</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id, title) {
        document.getElementById('deleteSlideTitle').textContent = '"' + title + '"';
        document.getElementById('deleteForm').action = "{{ url('admin/sliders') }}/" + id;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    function openImageModal(url, title) {
        document.getElementById('lightboxImg').src = url;
        document.getElementById('lightboxCaption').textContent = title;
        const modal = document.getElementById('imageLightboxModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageLightboxModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
            closeImageModal();
        }
    });
</script>
@endpush
@endsection
