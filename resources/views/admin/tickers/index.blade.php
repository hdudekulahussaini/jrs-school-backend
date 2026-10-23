@extends('admin.layout')

@section('title', 'News Ticker (Marquee)')
@section('header', 'Breaking News & Marquee Ticker')

@section('content')
<div class="space-y-6">

    <!-- Live Ticker Preview Card -->
    <div class="bg-jrs-navy rounded-2xl p-4 sm:p-5 text-white border border-white/10 shadow-lg">
        <div class="flex items-center gap-2 mb-2 text-xs font-bold uppercase tracking-wider text-amber-400">
            <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
            <span>Live Website Display Preview</span>
        </div>
        <div class="bg-black/40 rounded-xl border border-white/10 flex items-stretch overflow-hidden">
            <div class="bg-jrs-red px-3 py-2 flex items-center gap-1.5 text-white text-xs font-bold uppercase tracking-wider shrink-0">
                <svg class="w-3.5 h-3.5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 6a13 13 0 008.4-2.8A1 1 0 0121 4v12a1 1 0 01-1.6.8A13 13 0 0011 14H5a2 2 0 01-2-2V8a2 2 0 012-2z"/></svg>
                <span>News</span>
            </div>
            <div class="flex-1 overflow-hidden py-2 px-3 flex items-center">
                <marquee behavior="scroll" direction="left" scrollamount="6" class="text-xs sm:text-sm text-slate-100">
                    @forelse($tickers->where('is_active', true) as $t)
                        <span class="inline-flex items-center gap-2 mr-8">
                            @if($t->is_highlighted)
                                <span class="text-amber-400 font-bold">★</span>
                            @endif
                            <span>{{ $t->title }}</span>
                        </span>
                    @empty
                        <span class="text-slate-400">No active ticker items. Add an announcement below!</span>
                    @endforelse
                </marquee>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add Announcement Form -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-xs h-fit">
            <h3 class="text-base font-bold text-slate-900 font-heading mb-1">Add Announcement</h3>
            <p class="text-xs text-slate-500 mb-4">Post a new rolling alert on the home page ticker</p>

            <form action="{{ route('admin.tickers.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Ticker Text *</label>
                    <textarea name="title" rows="3" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red" placeholder="e.g., Admissions Open for Academic Year 2026-2027 (Nursery to Grade XII)"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Link URL (Optional)</label>
                    <input type="text" name="link_url" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red" placeholder="e.g., /admissions or https://...">
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Order</label>
                        <input type="number" name="sort_order" value="1" class="w-20 p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                    </div>

                    <label class="flex items-center gap-2 cursor-pointer pt-4">
                        <input type="checkbox" name="is_highlighted" value="1" checked class="w-4 h-4 text-jrs-red rounded border-slate-300 focus:ring-jrs-red">
                        <span class="text-xs font-bold text-slate-700">Gold Star Badge (★)</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-jrs-red hover:bg-jrs-red-dark shadow-md shadow-red-600/30 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Publish Announcement</span>
                </button>
            </form>
        </div>

        <!-- Tickers List Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900 font-heading">Current Ticker Announcements</h3>
                    <p class="text-xs text-slate-500">Live order and visibility controls</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                    {{ $tickers->count() }} Items
                </span>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($tickers as $ticker)
                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-slate-50/70 transition-colors">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                @if($ticker->is_highlighted)
                                    <span class="text-amber-500 font-black">★</span>
                                @endif
                                <p class="text-xs sm:text-sm font-semibold text-slate-900 break-words">{{ $ticker->title }}</p>
                            </div>
                            @if($ticker->link_url)
                                <a href="{{ $ticker->link_url }}" target="_blank" class="text-[11px] text-jrs-accent hover:underline block mt-0.5 truncate max-w-md">
                                    🔗 {{ $ticker->link_url }}
                                </a>
                            @endif
                            <div class="flex items-center gap-3 mt-1 text-[11px] text-slate-400">
                                <span>Order: <strong>{{ $ticker->sort_order }}</strong></span>
                                <span>•</span>
                                <span>Updated: {{ $ticker->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <!-- Toggle Active/Inactive -->
                            <form action="{{ route('admin.tickers.toggle', $ticker->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-full text-xs font-bold transition-colors {{ $ticker->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                    {{ $ticker->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </form>

                            <!-- Delete -->
                            <form action="{{ route('admin.tickers.destroy', $ticker->id) }}" method="POST" onsubmit="return confirm('Delete this ticker item?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-500 text-sm">
                        No ticker announcements found. Add one using the form on the left.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
