@extends('admin.layout')

@section('title', 'News Ticker Management')
@section('header', 'Breaking News Ticker')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-heading">News Ticker</h2>
                <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                    {{ $totalCount }} {{ Str::plural('announcement', $totalCount) }}
                </div>
            </div>
            <p class="text-sm text-slate-500">
                Manage the rolling marquee announcements shown on top of the JRS School homepage.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.tickers.create') }}" class="inline-flex items-center justify-center rounded-md text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add Announcement</span>
            </a>
        </div>
    </div>

    <!-- Toolbar: Tabs + Search (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Status Tabs (shadcn/ui TabsList) -->
        <div class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 p-1 text-slate-500 w-full sm:w-auto">
            <a href="{{ route('admin.tickers.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 {{ !request('status') ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.tickers.index', ['status' => 'active']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 {{ request('status') === 'active' ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.tickers.index', ['status' => 'inactive']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 {{ request('status') === 'inactive' ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Disabled ({{ $inactiveCount }})
            </a>
        </div>

        <!-- Search Input (shadcn/ui Input) -->
        <form action="{{ route('admin.tickers.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter announcements..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.tickers.index', ['status' => request('status')]) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Announcements Table Card (shadcn/ui Card + Table) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-24">Badge</th>
                        <th class="h-10 px-4 min-w-[240px]">Announcement</th>
                        <th class="h-10 px-4 w-44">Target URL</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-28 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($tickers as $ticker)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- Order -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center justify-center font-mono text-xs font-semibold text-slate-500 bg-slate-100 rounded-md h-6 w-6">
                                    {{ $ticker->sort_order }}
                                </span>
                            </td>

                            <!-- Badge -->
                            <td class="p-4 align-middle">
                                <span class="inline-flex items-center rounded-md border border-red-200 bg-red-50 px-2 py-0.5 text-xs font-semibold text-red-700 uppercase font-heading">
                                    {{ $ticker->badge_text ?? 'NEWS' }}
                                </span>
                            </td>

                            <!-- Title -->
                            <td class="p-4 align-middle">
                                <a href="{{ route('admin.tickers.show', $ticker->id) }}" class="font-medium text-slate-900 hover:text-slate-700 transition-colors leading-snug">
                                    {{ $ticker->title }}
                                </a>
                                <div class="text-[11px] text-slate-400 mt-0.5">Updated {{ $ticker->updated_at->diffForHumans() }}</div>
                            </td>

                            <!-- URL -->
                            <td class="p-4 align-middle">
                                @if($ticker->link_url)
                                    <a href="{{ $ticker->link_url }}" target="_blank" class="text-xs text-slate-600 hover:text-slate-900 underline truncate block max-w-[180px]">
                                        {{ $ticker->link_url }}
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $ticker->is_active ? 'border border-emerald-200 bg-emerald-50 text-emerald-700' : 'border border-slate-200 bg-slate-50 text-slate-600' }}">
                                    {{ $ticker->is_active ? 'Active' : 'Disabled' }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="inline-flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.tickers.show', $ticker->id) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 h-8 w-8 transition-colors" title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.tickers.edit', $ticker->id) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 h-8 w-8 transition-colors" title="Edit Announcement">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.tickers.destroy', $ticker->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 h-8 w-8 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-500">
                                <p class="font-medium text-slate-700 font-heading">No announcements found</p>
                                <p class="text-xs text-slate-400 mt-1">Get started by creating your first marquee announcement.</p>
                                <a href="{{ route('admin.tickers.create') }}" class="mt-4 inline-flex items-center justify-center rounded-md text-xs font-medium bg-slate-900 text-white hover:bg-slate-800 h-8 px-3 gap-1 shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    <span>Add Announcement</span>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tickers->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $tickers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
