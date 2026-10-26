@extends('admin.layout')

@section('title', $feature->title . ' - Key Feature')
@section('header', 'Key Feature Details')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.features.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Key Features</span>
                </a>
            </div>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">{{ $feature->title }}</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $feature->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $feature->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    {{ $feature->is_active ? 'Active' : 'Disabled' }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.features.edit', $feature->id) }}" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-navy hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Feature</span>
            </a>
            <button type="button" onclick="confirmDelete({{ $feature->id }}, '{{ addslashes($feature->title) }}')" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold border border-red-200 bg-red-50 hover:bg-red-100 text-jrs-red h-9 px-3 py-2 gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                <span>Delete</span>
            </button>
        </div>
    </div>

    <!-- Main Detail Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Icon Badge Preview Card -->
        <div class="lg:col-span-1 rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4 text-center">
            <h3 class="text-sm font-bold text-jrs-navy uppercase tracking-wider text-left">Card Preview</h3>
            
            <div class="p-8 bg-slate-50/75 rounded-xl border border-slate-200 flex flex-col items-center justify-center space-y-3">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white shadow-md" style="background-color: {{ $feature->color ?? '#e31e24' }}">
                    @if($feature->icon === 'graduation-cap')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    @elseif($feature->icon === 'sparkles')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    @elseif($feature->icon === 'award')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="8" r="6"/><path stroke-linecap="round" stroke-linejoin="round" d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                    @elseif($feature->icon === 'shield-check')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    @elseif($feature->icon === 'building-2' || $feature->icon === 'building')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    @else
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    @endif
                </div>
                <h4 class="font-bold text-sm text-jrs-navy">{{ $feature->title }}</h4>
                <p class="text-xs text-slate-500 leading-relaxed">{{ $feature->description ?? '—' }}</p>
            </div>

            <div class="space-y-2 pt-2 text-xs text-slate-500 text-left">
                <div class="flex items-center justify-between">
                    <span>Sort Order:</span>
                    <span class="font-mono font-bold text-slate-700">{{ $feature->sort_order }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Icon Key:</span>
                    <span class="font-mono text-slate-700">{{ $feature->icon ?? 'graduation-cap' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Created At:</span>
                    <span class="text-slate-700">{{ $feature->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Updated At:</span>
                    <span class="text-slate-700">{{ $feature->updated_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Information Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <h3 class="text-base font-bold text-jrs-navy font-heading border-b border-slate-100 pb-3">Configuration & Settings</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Title</span>
                        <p class="text-sm font-bold text-jrs-navy mt-1">{{ $feature->title }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Theme / Badge Color</span>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-4 h-4 rounded-full border border-slate-300 shadow-2xs" style="background-color: {{ $feature->color ?? '#e31e24' }}"></span>
                            <span class="font-mono text-xs font-bold text-slate-700">{{ $feature->color ?? '#e31e24' }}</span>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Icon</span>
                        <span class="inline-block mt-1 font-mono text-xs px-2.5 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">{{ $feature->icon ?? 'graduation-cap' }}</span>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Display Status</span>
                        <span class="inline-block mt-1 font-semibold text-xs px-2.5 py-0.5 rounded {{ $feature->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $feature->is_active ? 'Published' : 'Hidden' }}
                        </span>
                    </div>
                </div>

                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Subtitle / Description</span>
                    <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-200/80">
                        {{ $feature->description ?? 'No description provided.' }}
                    </p>
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
