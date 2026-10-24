@extends('admin.layout')

@section('title', $activity->title . ' - Beyond Classroom')
@section('header', 'Beyond Classroom Activity')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.beyond-classrooms.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Beyond Classroom</span>
                </a>
            </div>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">{{ $activity->title }}</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $activity->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $activity->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    {{ $activity->is_active ? 'Active' : 'Disabled' }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.beyond-classrooms.edit', $activity->id) }}" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-navy hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Activity</span>
            </a>
            <button type="button" onclick="confirmDelete({{ $activity->id }}, '{{ addslashes($activity->title) }}')" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold border border-red-200 bg-red-50 hover:bg-red-100 text-jrs-red h-9 px-3 py-2 gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                <span>Delete</span>
            </button>
        </div>
    </div>

    <!-- Main Detail Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Photo & Badge Card -->
        <div class="lg:col-span-1 rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-jrs-navy uppercase tracking-wider">Activity Portrait</h3>
            <div class="relative aspect-[4/5] rounded-xl overflow-hidden bg-slate-900 border border-slate-200 shadow-sm">
                @if($activity->image_full_url)
                    <img src="{{ $activity->image_full_url }}" alt="{{ $activity->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">No Image Uploaded</div>
                @endif
                <div class="absolute inset-x-0 bottom-0 p-3 bg-gradient-to-t from-black/80 to-transparent">
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-white font-bold text-xs" style="background-color: {{ $activity->color ?? '#15803d' }}">
                        <span>{{ $activity->title }}</span>
                    </div>
                </div>
            </div>
            <div class="space-y-2 pt-2 text-xs text-slate-500">
                <div class="flex items-center justify-between">
                    <span>Sort Order:</span>
                    <span class="font-mono font-bold text-slate-700">{{ $activity->sort_order }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Created At:</span>
                    <span class="text-slate-700">{{ $activity->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Updated At:</span>
                    <span class="text-slate-700">{{ $activity->updated_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Information Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <h3 class="text-base font-bold text-jrs-navy font-heading border-b border-slate-100 pb-3">Details & Configuration</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Title</span>
                        <p class="text-sm font-bold text-jrs-navy mt-1">{{ $activity->title }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Category / Tag</span>
                        <p class="text-sm text-slate-700 mt-1">{{ $activity->category ?? '—' }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Theme / Badge Color</span>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-4 h-4 rounded-full border border-slate-300 shadow-2xs" style="background-color: {{ $activity->color ?? '#15803d' }}"></span>
                            <span class="font-mono text-xs font-bold text-slate-700">{{ $activity->color ?? '#15803d' }}</span>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Icon</span>
                        <span class="inline-block mt-1 font-mono text-xs px-2.5 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">{{ $activity->icon ?? 'trophy' }}</span>
                    </div>
                </div>

                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Description</span>
                    <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-200/80">
                        {{ $activity->description ?? 'No description provided.' }}
                    </p>
                </div>

                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">API JSON Format</span>
                    <pre class="bg-slate-900 text-slate-100 text-xs p-4 rounded-lg overflow-x-auto font-mono">{{ json_encode($activity, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>
        </div>
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
                <h3 class="text-lg font-bold text-slate-900">Delete Beyond Classroom Activity</h3>
                <p class="text-sm text-slate-500 mt-1">Are you sure you want to delete <span id="deleteItemTitle" class="font-semibold text-slate-700"></span>? This action cannot be undone.</p>
            </div>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-2">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors cursor-pointer">Cancel</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-jrs-red hover:opacity-90 rounded-md transition-opacity shadow-xs cursor-pointer">Delete Activity</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, title) {
    document.getElementById('deleteItemTitle').textContent = `"${title}"`;
    document.getElementById('deleteForm').action = `/admin/beyond-classrooms/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
