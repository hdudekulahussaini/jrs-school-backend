@extends('admin.layout')

@section('title', 'Announcement #' . $ticker->id)
@section('header', 'Announcement Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumbs & Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-800">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.tickers.index') }}" class="hover:text-slate-800">News Ticker</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Details #{{ $ticker->id }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.tickers.edit', $ticker->id) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-jrs-navy hover:bg-jrs-navy-dark text-white transition-colors inline-flex items-center gap-1.5 shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Announcement</span>
            </a>
            <a href="{{ route('admin.tickers.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors inline-flex items-center gap-1.5 shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Metadata Details Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 font-heading text-base">Announcement Information</h3>
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $ticker->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                {{ $ticker->is_active ? '● Active' : '○ Disabled' }}
            </span>
        </div>

        <div class="divide-y divide-slate-100">
            <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Announcement Text</span>
                <span class="sm:col-span-2 text-sm font-medium text-slate-900 leading-relaxed">{{ $ticker->title }}</span>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Badge Label</span>
                <span class="sm:col-span-2">
                    <span class="px-2.5 py-1 rounded text-xs font-bold bg-red-100 text-red-700 uppercase">
                        {{ $ticker->badge_text ?? 'NEWS' }}
                    </span>
                </span>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Display Sequence</span>
                <span class="sm:col-span-2 text-sm font-bold text-slate-800">Order #{{ $ticker->sort_order }}</span>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Target Click Link</span>
                <span class="sm:col-span-2 text-sm">
                    @if($ticker->link_url)
                        <a href="{{ $ticker->link_url }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                            <span>{{ $ticker->link_url }}</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @else
                        <span class="text-slate-400 italic">No click link configured</span>
                    @endif
                </span>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Created Date</span>
                <span class="sm:col-span-2 text-sm text-slate-700">{{ $ticker->created_at->format('F d, Y - h:i A') }}</span>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Last Modified</span>
                <span class="sm:col-span-2 text-sm text-slate-700">{{ $ticker->updated_at->format('F d, Y - h:i A') }} ({{ $ticker->updated_at->diffForHumans() }})</span>
            </div>
        </div>

        <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
            <form action="{{ route('admin.tickers.destroy', $ticker->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this announcement?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Delete Announcement</span>
                </button>
            </form>

            <a href="{{ route('admin.tickers.edit', $ticker->id) }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-jrs-red hover:bg-jrs-red-dark text-white shadow-md shadow-red-600/30 transition-all inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Announcement</span>
            </a>
        </div>
    </div>

</div>
@endsection
