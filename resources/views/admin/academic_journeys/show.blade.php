@extends('admin.layout')

@section('title', $journey->title . ' - Academic Journey Details')
@section('header', 'Academic Journey Details')

@section('content')
<div class="space-y-6 max-w-4xl">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.academic-journeys.index') }}"
               class="p-2 text-slate-400 hover:text-jrs-navy hover:bg-slate-100 rounded-lg transition-colors"
               title="Back to Journeys">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    @if($journey->age_group)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold tracking-wider uppercase bg-amber-50 text-amber-800 border border-amber-200">
                            {{ $journey->age_group }}
                        </span>
                    @endif
                    @if($journey->is_active)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Live
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Hidden
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl font-bold font-heading text-jrs-navy mt-1">{{ $journey->title }}</h1>
                <p class="text-xs text-slate-500 font-mono">Slug: {{ $journey->slug }} &bull; Sort Order: {{ $journey->sort_order }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.academic-journeys.edit', $journey->id) }}"
               class="px-4 py-2 bg-jrs-navy text-white text-xs font-semibold rounded-lg hover:bg-jrs-red transition-colors inline-flex items-center gap-1.5 shadow-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit</span>
            </a>

            <form action="{{ route('admin.academic-journeys.destroy', $journey->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this journey card?');"
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="p-2 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                        title="Delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Details Card -->
    <div class="rounded-xl border border-slate-200 bg-white overflow-hidden shadow-xs">
        @if($journey->image_path)
            <div class="w-full h-64 bg-slate-900 relative">
                <img src="{{ asset($journey->image_path) }}" alt="{{ $journey->title }}" class="w-full h-full object-cover">
                <div class="absolute bottom-4 left-4 bg-jrs-navy text-white px-3 py-1.5 rounded-full text-xs font-semibold flex items-center gap-2 shadow-md border border-white/20">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <span>Icon: {{ $journey->icon ?? 'baby' }}</span>
                </div>
            </div>
        @endif

        <div class="p-6 space-y-4">
            <div>
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Description</h3>
                <p class="text-sm text-slate-700 mt-1 leading-relaxed">{{ $journey->description }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100 text-xs">
                <div>
                    <span class="font-bold text-slate-500 uppercase tracking-wider block">Target Link</span>
                    <span class="text-slate-800 font-mono mt-0.5 block">{{ $journey->link_url ?? '—' }}</span>
                </div>
                <div>
                    <span class="font-bold text-slate-500 uppercase tracking-wider block">Created Date</span>
                    <span class="text-slate-800 mt-0.5 block">{{ $journey->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
