@extends('admin.layout')

@section('title', 'News Ticker Management')
@section('header', 'Breaking News Ticker')

@section('content')
<div class="space-y-6">

    <!-- Top Info & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-xl font-bold text-slate-900 font-heading">Homepage News Marquee Bar</h2>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">{{ $activeCount }} Active</span>
                @if($inactiveCount > 0)
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">{{ $inactiveCount }} Disabled</span>
                @endif
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Manage the rolling marquee announcements shown on top of the JRS School homepage.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tickers.create') }}" class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-jrs-red-dark text-white shadow-md shadow-red-600/30 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Announcement</span>
            </a>
        </div>
    </div>

    <!-- Live Preview (Exact Match to Frontend Design) -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-3">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span>Live Website Preview</span>
            </span>
            <span class="text-xs text-slate-400">Updates live when active items change</span>
        </div>

        <!-- Marquee Bar Preview matching uploaded screenshot -->
        <div class="flex items-stretch rounded-xl overflow-hidden shadow-md border border-slate-900/10">
            <!-- Red Badge -->
            <div class="bg-jrs-red text-white px-4 py-3 flex items-center gap-2 shrink-0 font-bold text-xs uppercase tracking-wider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                <span>NEWS</span>
            </div>
            <!-- Dark Navy Scrolling Area -->
            <div class="flex-1 bg-jrs-navy text-white flex items-center px-4 overflow-hidden text-xs sm:text-sm">
                <marquee behavior="scroll" direction="left" scrollamount="6" class="py-1">
                    @forelse($tickers->where('is_active', true) as $ticker)
                        <span class="inline-flex items-center gap-2 mr-10">
                            <span class="text-amber-400 font-bold">★</span>
                            <span class="font-medium text-slate-100">{{ $ticker->title }}</span>
                            @if($ticker->link_url)
                                <a href="{{ $ticker->link_url }}" target="_blank" class="underline text-amber-300 hover:text-white font-semibold ml-1">Open Link &rarr;</a>
                            @endif
                        </span>
                    @empty
                        <span class="text-slate-400 italic">No active ticker announcements. Click "+ Add Announcement" to publish news.</span>
                    @endforelse
                </marquee>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-1.5 p-1 bg-slate-100 rounded-xl w-full md:w-auto">
            <a href="{{ route('admin.tickers.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ !request('status') ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.tickers.index', ['status' => 'active']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ request('status') === 'active' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.tickers.index', ['status' => 'inactive']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ request('status') === 'inactive' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Disabled ({{ $inactiveCount }})
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('admin.tickers.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search announcements..." class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            @if(request('search'))
                <a href="{{ route('admin.tickers.index', ['status' => request('status')]) }}" class="p-2 text-slate-400 hover:text-slate-700 text-xs font-semibold">Clear</a>
            @endif
        </form>
    </div>

    <!-- Ticker Table List -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 font-heading text-base">Announcements List</h3>
            <span class="text-xs text-slate-500">Page {{ $tickers->currentPage() }} of {{ $tickers->lastPage() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 w-16 text-center">Order</th>
                        <th class="py-3.5 px-4 w-24">Badge</th>
                        <th class="py-3.5 px-4">Announcement Text</th>
                        <th class="py-3.5 px-4 w-44">Target Link</th>
                        <th class="py-3.5 px-4 w-28 text-center">Status</th>
                        <th class="py-3.5 px-4 w-44 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tickers as $ticker)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-4 text-center font-bold text-slate-600">
                                #{{ $ticker->sort_order }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-red-100 text-red-700 uppercase">
                                    {{ $ticker->badge_text ?? 'NEWS' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('admin.tickers.show', $ticker->id) }}" class="font-medium text-slate-900 hover:text-jrs-red leading-snug">
                                    {{ $ticker->title }}
                                </a>
                                <div class="text-[11px] text-slate-400 mt-0.5">Updated {{ $ticker->updated_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-4 px-4">
                                @if($ticker->link_url)
                                    <a href="{{ $ticker->link_url }}" target="_blank" class="text-xs text-blue-600 hover:underline truncate block max-w-[180px]">
                                        {{ $ticker->link_url }}
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center">
                                <form action="{{ route('admin.tickers.toggle', $ticker->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-xs font-semibold cursor-pointer transition-colors {{ $ticker->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        {{ $ticker->is_active ? '● Active' : '○ Disabled' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- View Details -->
                                    <a href="{{ route('admin.tickers.show', $ticker->id) }}" class="p-1.5 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors" title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Edit Form -->
                                    <a href="{{ route('admin.tickers.edit', $ticker->id) }}" class="p-1.5 text-slate-500 hover:text-jrs-navy hover:bg-slate-100 rounded-lg transition-colors" title="Edit Announcement">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.tickers.destroy', $ticker->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                <p class="font-medium text-slate-700">No news announcements found</p>
                                <p class="text-xs text-slate-400 mt-1">Click the button below to add your first marquee announcement.</p>
                                <a href="{{ route('admin.tickers.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-jrs-red text-white hover:bg-jrs-red-dark transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span>Add Announcement</span>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tickers->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $tickers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
