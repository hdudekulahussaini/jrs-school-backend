@extends('admin.layout')

@section('title', 'About JRS Management')
@section('header', 'About JRS Section')

@section('content')
<div class="space-y-6">

    <!-- Top Action: Add Button (Aligned Right) -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-jrs-navy font-heading">About JRS Section</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Manage the main introductory story, highlights, photographs, and video on the homepage.
            </p>
        </div>
        <a href="{{ route('admin.about.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Entry</span>
        </a>
    </div>

    <!-- Toolbar: Tabs + Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Status Tabs -->
        <div class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 p-1 text-slate-500 w-full sm:w-auto">
            <a href="{{ route('admin.about.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ !request('status') ? 'bg-white text-slate-950 font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount ?? $allSections->count() }})
            </a>
            <a href="{{ route('admin.about.index', ['status' => 'active']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'active' ? 'bg-white text-emerald-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Live / Active ({{ $activeCount ?? $allSections->where('is_active', true)->count() }})
            </a>
            <a href="{{ route('admin.about.index', ['status' => 'inactive']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'inactive' ? 'bg-white text-slate-950 font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Inactive ({{ $inactiveCount ?? $allSections->where('is_active', false)->count() }})
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.about.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or text..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.about.index', ['status' => request('status')]) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- About Sections Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-14 text-center">ID</th>
                        <th class="h-10 px-4 w-36 text-center">Photos</th>
                        <th class="h-10 px-4 min-w-[280px]">Eyebrow &amp; Headlines</th>
                        <th class="h-10 px-4 min-w-[240px]">Descriptions</th>
                        <th class="h-10 px-4 min-w-[180px]">CTA &amp; Video</th>
                        <th class="h-10 px-4 w-28 text-center">Homepage Status</th>
                        <th class="h-10 px-4 w-28 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($allSections as $section)
                        <tr class="hover:bg-slate-50/80 transition-colors {{ $section->is_active ? 'bg-amber-50/20' : '' }}">
                            <!-- ID -->
                            <td class="p-4 align-middle text-center font-mono text-xs text-slate-500">
                                #{{ $section->id }}
                            </td>

                            <!-- Photos (Image 1 & Image 2) -->
                            <td class="p-4 align-middle">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Image 1 -->
                                    <div class="group relative w-12 h-12 rounded-lg border border-slate-200 bg-slate-100 overflow-hidden shrink-0 cursor-pointer shadow-2xs"
                                         onclick="openImageModal('{{ $section->image_1_url }}', 'Students Photo (Image 1)')"
                                         title="Click to zoom Image 1">
                                        @if($section->image_1_url)
                                            <img src="{{ $section->image_1_url }}" alt="Img 1" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                            <span class="absolute bottom-0 right-0 bg-slate-900/70 text-[9px] text-white px-1 font-mono leading-tight">1</span>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-400 font-medium">None</div>
                                        @endif
                                    </div>

                                    <!-- Image 2 -->
                                    <div class="group relative w-12 h-12 rounded-lg border border-slate-200 bg-slate-100 overflow-hidden shrink-0 cursor-pointer shadow-2xs"
                                         onclick="openImageModal('{{ $section->image_2_url }}', 'Campus Photo (Image 2)')"
                                         title="Click to zoom Image 2">
                                        @if($section->image_2_url)
                                            <img src="{{ $section->image_2_url }}" alt="Img 2" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                            <span class="absolute bottom-0 right-0 bg-slate-900/70 text-[9px] text-white px-1 font-mono leading-tight">2</span>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-400 font-medium">None</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Eyebrow & Headlines -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1">
                                    @if($section->tagline)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $section->tagline }}
                                        </span>
                                    @endif
                                    <div class="font-bold text-slate-900 font-heading text-sm leading-snug">
                                        {{ $section->title }}
                                        @if($section->title_highlight)
                                            <span class="text-jrs-red font-extrabold">{{ $section->title_highlight }}</span>
                                        @endif
                                    </div>
                                    <div class="text-[11px] text-slate-400">
                                        Updated {{ $section->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                            </td>

                            <!-- Descriptions Preview -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1 max-w-md">
                                    <p class="text-xs text-slate-700 line-clamp-2 leading-relaxed" title="{{ $section->description_p1 }}">
                                        {{ $section->description_p1 }}
                                    </p>
                                    @if($section->description_p2)
                                        <p class="text-[11px] text-slate-400 line-clamp-1 italic" title="{{ $section->description_p2 }}">
                                            P2: {{ $section->description_p2 }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            <!-- CTA Button & Video -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1.5 text-xs">
                                    @if($section->button_text)
                                        <div class="flex items-center gap-1.5 text-slate-700">
                                            <span class="font-semibold px-2 py-0.5 rounded bg-slate-100 text-[11px] border border-slate-200 shrink-0">
                                                {{ $section->button_text }}
                                            </span>
                                            <code class="text-[11px] text-blue-600 font-mono truncate max-w-[120px]">{{ $section->button_link }}</code>
                                        </div>
                                    @endif

                                    @if($section->video_title || $section->video_url)
                                        <div class="flex items-center gap-1 text-[11px] text-slate-600 pt-0.5">
                                            <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                            @if($section->video_url)
                                                <a href="{{ $section->video_url }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline truncate max-w-[140px]" title="{{ $section->video_title }}">
                                                    {{ $section->video_title ?: 'Watch Video' }}
                                                </a>
                                            @else
                                                <span class="truncate max-w-[140px]">{{ $section->video_title }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Status & Toggle -->
                            <td class="p-4 align-middle text-center">
                                <div class="flex flex-col items-center gap-1.5">
                                    <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $section->is_active ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-slate-100 text-slate-600' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $section->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                        <span>{{ $section->is_active ? 'Live' : 'Inactive' }}</span>
                                    </span>

                                    <form action="{{ route('admin.about.toggle', $section->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[11px] font-medium {{ $section->is_active ? 'text-amber-700 hover:underline' : 'text-emerald-700 hover:underline' }}">
                                            {{ $section->is_active ? 'Set Inactive' : 'Set as Live' }}
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.about.edit', $section->id) }}" title="Edit About Section" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-slate-100 hover:text-slate-900 h-8 w-8 text-slate-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Delete -->
                                    <button type="button" onclick="confirmDelete({{ $section->id }}, '{{ addslashes($section->title) }}')" title="Delete Entry" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-red-50 hover:text-red-600 h-8 w-8 text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-500">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-10 h-10 rounded-full border border-slate-200 bg-slate-50 text-slate-400 mx-auto flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="font-medium text-slate-900 text-sm">No About Section content found</p>
                                        <p class="text-xs text-slate-500">Configure the introductory story, student and campus photography for the homepage.</p>
                                    </div>
                                    <a href="{{ route('admin.about.create') }}" class="inline-flex items-center justify-center rounded-md text-xs font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-8 px-3">
                                        Add About Content
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($allSections, 'hasPages') && $allSections->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                {{ $allSections->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Delete Confirmation Dialog -->
<div id="deleteModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl border border-slate-200 max-w-md w-full p-6 shadow-xl space-y-4">
        <div class="space-y-2">
            <h4 class="text-lg font-bold leading-none tracking-tight text-slate-900 font-heading">Delete About Entry</h4>
            <p class="text-sm text-slate-500 leading-relaxed">
                Are you sure you want to delete <strong id="deleteAboutTitle" class="text-slate-900"></strong>? This content entry will be permanently removed.
            </p>
        </div>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeDeleteModal()" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 h-9 px-4 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-semibold bg-red-600 text-white shadow-xs hover:bg-red-700 h-9 px-4 transition-colors">
                    Yes, Delete
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Image Lightbox Modal -->
<div id="imageLightboxModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-xs hidden items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-2xl max-h-[90vh] p-2 bg-slate-950 rounded-xl border border-slate-800 shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
        <img id="lightboxImg" src="" alt="Photo Preview" class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
        <div class="p-3 text-white text-xs font-medium flex items-center justify-between">
            <span id="lightboxCaption" class="truncate font-mono text-slate-300"></span>
            <button onclick="closeImageModal()" class="inline-flex items-center justify-center rounded-md border border-slate-700 text-xs text-slate-300 hover:text-white hover:bg-slate-800 px-3 py-1 transition-colors">Close (Esc)</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id, title) {
        document.getElementById('deleteAboutTitle').textContent = '"' + title + '"';
        document.getElementById('deleteForm').action = "{{ url('admin/about') }}/" + id;
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
        if (!url) return;
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
