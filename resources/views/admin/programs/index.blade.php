@extends('admin.layout')

@section('title', 'Academic Programmes')
@section('header', 'Academic Programmes')

@section('content')
<div class="space-y-6">

    <!-- Top Action: Add Button (Aligned Right) -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.programs.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Academic Program</span>
        </a>
    </div>

    <!-- Toolbar: Tabs + Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Status Tabs -->
        <div class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 p-1 text-slate-500 w-full sm:w-auto">
            <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ !request('status') ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.programs.index', ['status' => 'active']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'active' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.programs.index', ['status' => 'inactive']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'inactive' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Disabled ({{ $inactiveCount }})
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.programs.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.programs.index', ['status' => request('status')]) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Academic Programs Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-28">Photo</th>
                        <th class="h-10 px-4 min-w-[220px]">Program & Stage</th>
                        <th class="h-10 px-4 min-w-[200px]">Curriculum Highlights</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($programs as $program)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- Sort Order -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center justify-center font-mono text-xs font-semibold text-slate-500 bg-slate-100 rounded-md h-6 w-6">
                                    {{ $program->sort_order }}
                                </span>
                            </td>

                            <!-- Image Thumbnail -->
                            <td class="p-4 align-middle">
                                <div class="relative w-20 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 shadow-2xs group cursor-pointer" onclick="openImageModal('{{ $program->image_full_url ?? '' }}', '{{ addslashes($program->title) }}')">
                                    @if($program->image_full_url)
                                        <img src="{{ $program->image_full_url }}" alt="{{ $program->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Program Info -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1">
                                    @if($program->stage_badge)
                                        <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider text-jrs-red bg-red-50 border border-red-200">
                                            {{ $program->stage_badge }}
                                        </div>
                                    @endif
                                    <div class="font-bold text-base text-jrs-navy font-heading">
                                        {{ $program->title }}
                                    </div>
                                    @if($program->subtitle)
                                        <div class="text-xs font-semibold text-jrs-red">
                                            {{ $program->subtitle }}
                                        </div>
                                    @endif
                                    @if($program->description)
                                        <p class="text-xs text-slate-500 line-clamp-1 max-w-md">
                                            {{ $program->description }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            <!-- Highlights -->
                            <td class="p-4 align-middle">
                                @if(!empty($program->highlights) && is_array($program->highlights))
                                    <div class="space-y-1 max-w-xs">
                                        @foreach(array_slice($program->highlights, 0, 2) as $point)
                                            <div class="flex items-center gap-1.5 text-xs text-slate-600 truncate">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                                <span class="truncate">{{ $point }}</span>
                                            </div>
                                        @endforeach
                                        @if(count($program->highlights) > 2)
                                            <span class="inline-block text-[10px] text-slate-400 font-medium">
                                                +{{ count($program->highlights) - 2 }} more highlights
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>

                            <!-- Active Status Toggle -->
                            <td class="p-4 align-middle text-center">
                                <form action="{{ route('admin.programs.toggle', $program->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" title="Click to toggle status" class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors cursor-pointer {{ $program->is_active ? 'border-jrs-navy/20 bg-jrs-navy/5 text-jrs-navy hover:bg-jrs-navy hover:text-white' : 'border-slate-200 bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $program->is_active ? 'bg-jrs-red' : 'bg-slate-400' }}"></span>
                                        <span>{{ $program->is_active ? 'Active' : 'Disabled' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- View / Preview -->
                                    <a href="{{ route('admin.programs.show', $program->id) }}" title="View Card Details" class="p-1.5 text-slate-500 hover:text-jrs-navy hover:bg-slate-100 rounded-md transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.programs.edit', $program->id) }}" title="Edit Program" class="p-1.5 text-slate-500 hover:text-jrs-red hover:bg-slate-100 rounded-md transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete \'{{ addslashes($program->title) }}\'?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete Program" class="p-1.5 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-md transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                                    <p class="text-sm font-medium text-slate-600">No academic programmes found.</p>
                                    <p class="text-xs text-slate-400">Click "+ Add Academic Program" to publish your first stage.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($programs->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                {{ $programs->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Image Lightbox Modal -->
<div id="imageModal" class="fixed inset-0 bg-jrs-navy/80 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-2xl max-h-[90vh] p-2 bg-jrs-navy rounded-xl border border-white/20 shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
        <button onclick="closeImageModal()" class="absolute top-3 right-3 text-white/70 hover:text-white p-1 rounded-full bg-black/40 hover:bg-black/60 z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img id="modalImage" src="" alt="Program Preview" class="max-h-[80vh] w-auto rounded-lg object-contain">
        <p id="modalCaption" class="text-xs text-center text-white/80 py-2 font-medium"></p>
    </div>
</div>

<!-- Image Lightbox Modal Script -->
<script>
    function openImageModal(url, caption) {
        if (!url) return;
        document.getElementById('modalImage').src = url;
        document.getElementById('modalCaption').textContent = caption || '';
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }
</script>
@endsection
