@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('header', 'Overview')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="space-y-1">
        <h2 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">Dashboard Overview</h2>
        <p class="text-sm text-slate-500">
            Welcome to the JRS International School Central Administration Panel.
        </p>
    </div>

    <!-- Active Modules Grid (shadcn/ui Card style) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <!-- Module 1: News Ticker Announcement -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-colors">
            <div>
                <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-900 flex items-center justify-center mb-4 border border-slate-200/60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-base font-semibold text-slate-900 font-heading tracking-tight">Breaking News Ticker</h3>
                    <span class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-[11px] font-medium text-emerald-700">Active</span>
                </div>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Manage the rolling marquee announcements shown at the top of the homepage with external links and sort ordering.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Header Marquee</span>
                <a href="{{ route('admin.tickers.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium transition-colors bg-slate-900 text-white hover:bg-slate-800 h-8 px-3 gap-1 shadow-2xs">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Module 2: Hero Sliders -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-colors">
            <div>
                <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-900 flex items-center justify-center mb-4 border border-slate-200/60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-base font-semibold text-slate-900 font-heading tracking-tight">Hero Sliders</h3>
                    <span class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-[11px] font-medium text-emerald-700">Active</span>
                </div>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Design and customize main banner slides with highlighted words, badges, background photos, and action buttons.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Hero Section</span>
                <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium transition-colors bg-slate-900 text-white hover:bg-slate-800 h-8 px-3 gap-1 shadow-2xs">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Module 3: Facilities -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-colors">
            <div>
                <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-900 flex items-center justify-center mb-4 border border-slate-200/60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-base font-semibold text-slate-900 font-heading tracking-tight">Our Facilities</h3>
                    <span class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-[11px] font-medium text-emerald-700">Active</span>
                </div>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Manage the World-Class Infrastructure showcase cards: Smart Classrooms, Science Labs, Library, Sports, and Transport.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Facilities Cards</span>
                <a href="{{ route('admin.facilities.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium transition-colors bg-slate-900 text-white hover:bg-slate-800 h-8 px-3 gap-1 shadow-2xs">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
