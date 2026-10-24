@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
<div class="space-y-6">

    <!-- Active Modules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Module 1: News Ticker Announcement -->
        <div class="p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-xl bg-red-50 text-jrs-red flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 font-heading">Breaking News Ticker</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                    Manage the rolling news announcements displayed at the top of the JRS School homepage with links and sort order.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">● Module Active</span>
                <a href="{{ route('admin.tickers.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-jrs-red hover:underline">
                    <span>Manage Ticker &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Module 2: About JRS Homepage Section -->
        <div class="p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-jrs-gold flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 font-heading">About JRS Section</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                    Manage the "Legacy Of Excellence In Education" story, dual campus images, video showcase, and CTA button.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">● Module Active</span>
                <a href="{{ route('admin.about.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-jrs-red hover:underline">
                    <span>Manage About &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Module 3: Vision & Mission Cards -->
        <div class="p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 font-heading">Vision & Mission</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                    Manage the "Our Vision" and "Our Mission" highlight cards with background images, titles, and descriptions.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">● Module Active</span>
                <a href="{{ route('admin.vision-mission.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-jrs-red hover:underline">
                    <span>Manage Cards &rarr;</span>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
