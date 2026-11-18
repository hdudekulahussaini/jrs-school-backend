@extends('admin.layout')

@section('title', 'Admission Banner')
@section('header', 'Admission Banner (CTA)')

@section('content')
<div class="space-y-6">

    <!-- Top Action Toolbar (Add button hidden when banner exists) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-base font-bold text-jrs-navy font-heading">Admission Banner (CTA)</h2>
            <p class="text-xs text-slate-500 mt-0.5">Manage the admission call-to-action banner for the website.</p>
        </div>
        @if(($totalCount ?? 0) === 0)
            <a href="{{ route('admin.admission-banner.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add Admission Banner</span>
            </a>
        @endif
    </div>

    @if($banner)
    <!-- Field Configuration & Content Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-jrs-navy font-heading text-base">Field Configuration & Content Data</h3>
                <span class="text-xs text-slate-400">ID #{{ $banner->id }} • Updated {{ $banner->updated_at->diffForHumans() }}</span>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.admission-banner.edit', $banner->id) }}" class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold bg-jrs-red hover:bg-red-700 text-white shadow-xs transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Edit</span>
                </a>
                <form action="{{ route('admin.admission-banner.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this admission banner?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold bg-white hover:bg-red-50 text-red-600 border border-red-200 transition-all flex items-center gap-1.5 shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Delete</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="divide-y divide-slate-100 text-sm">
            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Main Heading</span>
                <span class="sm:col-span-3 font-bold text-slate-900">{{ $banner->title }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Highlight Text (Amber)</span>
                <span class="sm:col-span-3 font-bold text-amber-500">{{ $banner->title_highlight ?? '—' }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Description / Paragraph</span>
                <span class="sm:col-span-3 text-slate-700 leading-relaxed text-xs">{{ $banner->description ?? '—' }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2 items-center">
                <span class="text-xs font-bold text-slate-500 uppercase">Background Image</span>
                <div class="sm:col-span-3 flex items-center gap-3">
                    @if($banner->image_full_url)
                        <img src="{{ $banner->image_full_url }}" alt="Background" class="w-20 h-12 rounded-lg object-cover border border-slate-200 shrink-0">
                        <span class="text-xs text-slate-600 font-mono">{{ $banner->image_path }}</span>
                    @else
                        <span class="text-xs text-slate-400">None</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400 mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </div>
        <h4 class="text-sm font-bold text-slate-800">No Admission Banner Found</h4>
        <p class="text-xs text-slate-500 mt-1 mb-4">Click below to create an admission banner.</p>
        <a href="{{ route('admin.admission-banner.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-jrs-red hover:bg-red-700 text-white shadow-xs transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Admission Banner</span>
        </a>
    </div>
    @endif

</div>
@endsection
