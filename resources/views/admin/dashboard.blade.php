@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('header', 'Overview')

@section('content')
<div class="space-y-6">

    <!-- Welcome Banner with Official Logo -->
    <div class="relative overflow-hidden rounded-2xl bg-jrs-navy p-6 sm:p-7 text-white shadow-sm border border-white/10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2 max-w-xl text-center md:text-left z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-jrs-red animate-pulse"></span>
                Central Portal Active
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight font-heading text-white">
                Welcome back, {{ Auth::user()->name ?? 'Administrator' }}
            </h2>
            <p class="text-xs sm:text-sm text-white/80 leading-relaxed">
                Central administration for JRS International School. Control the homepage news ticker, hero slider visuals, and world-class infrastructure facilities in real-time.
            </p>
            <div class="pt-2 flex flex-wrap gap-2 justify-center md:justify-start">
                <a href="{{ route('admin.tickers.index') }}" class="px-3.5 py-1.5 rounded-lg bg-jrs-red hover:opacity-95 text-xs font-semibold text-white shadow-xs transition-opacity inline-flex items-center gap-1.5">
                    <span>Marquee Ticker</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.sliders.index') }}" class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                    <span>Hero Sliders</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.features.index') }}" class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                    <span>Key Features</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.facilities.index') }}" class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                    <span>Facilities</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.programs.index') }}" class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                    <span>Academic Programs</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.beyond-classrooms.index') }}" class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                    <span>Beyond Classroom</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.events.index') }}" class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                    <span>Latest Events</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        <div class="shrink-0 bg-white rounded-2xl p-4 shadow-xl shadow-black/30 flex items-center justify-center border border-white z-10">
            <img src="{{ asset('images/logo.png') }}" alt="JRS International School Logo" class="h-16 sm:h-20 w-auto object-contain">
        </div>
        <!-- Decorative Glow using brand Red -->
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-jrs-red/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Active Modules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Module 1: News Ticker Announcement -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between hover:border-jrs-navy/40 transition-colors">
            <div>
                <div class="w-10 h-10 rounded-lg bg-jrs-navy/5 text-jrs-navy flex items-center justify-center mb-4 border border-jrs-navy/15">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-base font-bold text-jrs-navy font-heading tracking-tight">News Ticker</h3>
                    <span class="inline-flex items-center rounded-full border border-jrs-red/20 bg-jrs-red/10 px-2 py-0.5 text-[11px] font-semibold text-jrs-red">Active</span>
                </div>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Manage the rolling marquee announcements shown at the top of the homepage with external links and sort ordering.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-medium">Marquee</span>
                <a href="{{ route('admin.tickers.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-semibold transition-colors bg-jrs-navy hover:bg-jrs-red text-white h-8 px-3 gap-1 shadow-2xs">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Module 2: Hero Sliders -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between hover:border-jrs-navy/40 transition-colors">
            <div>
                <div class="w-10 h-10 rounded-lg bg-jrs-navy/5 text-jrs-navy flex items-center justify-center mb-4 border border-jrs-navy/15">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-base font-bold text-jrs-navy font-heading tracking-tight">Hero Sliders</h3>
                    <span class="inline-flex items-center rounded-full border border-jrs-red/20 bg-jrs-red/10 px-2 py-0.5 text-[11px] font-semibold text-jrs-red">Active</span>
                </div>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Design and customize main banner slides with highlighted words, badges, background photos, and action buttons.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-medium">Hero Banners</span>
                <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-semibold transition-colors bg-jrs-navy hover:bg-jrs-red text-white h-8 px-3 gap-1 shadow-2xs">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Module: Key Features -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between hover:border-jrs-navy/40 transition-colors">
            <div>
                <div class="w-10 h-10 rounded-lg bg-jrs-navy/5 text-jrs-navy flex items-center justify-center mb-4 border border-jrs-navy/15">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-base font-bold text-jrs-navy font-heading tracking-tight">Key Features</h3>
                    <span class="inline-flex items-center rounded-full border border-jrs-red/20 bg-jrs-red/10 px-2 py-0.5 text-[11px] font-semibold text-jrs-red">Active</span>
                </div>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Manage the 5 highlight cards under the hero slider: CBSE Curriculum, Holistic Development, Experienced Faculty, and more.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-medium">Value Badges</span>
                <a href="{{ route('admin.features.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-semibold transition-colors bg-jrs-navy hover:bg-jrs-red text-white h-8 px-3 gap-1 shadow-2xs">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Module 3: Facilities -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between hover:border-jrs-navy/40 transition-colors">
            <div>
                <div class="w-10 h-10 rounded-lg bg-jrs-navy/5 text-jrs-navy flex items-center justify-center mb-4 border border-jrs-navy/15">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-base font-bold text-jrs-navy font-heading tracking-tight">Our Facilities</h3>
                    <span class="inline-flex items-center rounded-full border border-jrs-red/20 bg-jrs-red/10 px-2 py-0.5 text-[11px] font-semibold text-jrs-red">Active</span>
                </div>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Manage the World-Class Infrastructure showcase cards: Smart Classrooms, Science Labs, Library, and Sports.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-medium">Infrastructure</span>
                <a href="{{ route('admin.facilities.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-semibold transition-colors bg-jrs-navy hover:bg-jrs-red text-white h-8 px-3 gap-1 shadow-2xs">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Module 4: Academic Programs -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between hover:border-jrs-navy/40 transition-colors">
            <div>
                <div class="w-10 h-10 rounded-lg bg-jrs-navy/5 text-jrs-navy flex items-center justify-center mb-4 border border-jrs-navy/15">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-base font-bold text-jrs-navy font-heading tracking-tight">Academic Stages</h3>
                    <span class="inline-flex items-center rounded-full border border-jrs-red/20 bg-jrs-red/10 px-2 py-0.5 text-[11px] font-semibold text-jrs-red">Active</span>
                </div>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Manage the homepage academic stages (Pre-Primary, Primary, Middle School) with photos, curriculum bullet points, and badges.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-medium">Academics</span>
                <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-semibold transition-colors bg-jrs-navy hover:bg-jrs-red text-white h-8 px-3 gap-1 shadow-2xs">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Module 5: Beyond Classroom -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between hover:border-jrs-navy/40 transition-colors">
            <div>
                <div class="w-10 h-10 rounded-lg bg-jrs-navy/5 text-jrs-navy flex items-center justify-center mb-4 border border-jrs-navy/15">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-base font-bold text-jrs-navy font-heading tracking-tight">Beyond Classroom</h3>
                    <span class="inline-flex items-center rounded-full border border-jrs-red/20 bg-jrs-red/10 px-2 py-0.5 text-[11px] font-semibold text-jrs-red">Active</span>
                </div>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Manage the homepage "A Platform For Every Talent" activities (Sports, Music, Dance, Karate, Science & Activities, Skating).
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-medium">Co-Curricular</span>
                <a href="{{ route('admin.beyond-classrooms.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-semibold transition-colors bg-jrs-navy hover:bg-jrs-red text-white h-8 px-3 gap-1 shadow-2xs">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Module 6: Latest Events -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6 shadow-xs flex flex-col justify-between hover:border-jrs-navy/40 transition-colors">
            <div>
                <div class="w-10 h-10 rounded-lg bg-jrs-navy/5 text-jrs-navy flex items-center justify-center mb-4 border border-jrs-navy/15">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-base font-bold text-jrs-navy font-heading tracking-tight">Latest Events</h3>
                    <span class="inline-flex items-center rounded-full border border-jrs-red/20 bg-jrs-red/10 px-2 py-0.5 text-[11px] font-semibold text-jrs-red">Active</span>
                </div>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Manage the homepage "What's Happening At JRS" showcase cards (Republic Day, Annual Day, Sports Day) with date badges.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-medium">Happenings</span>
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-semibold transition-colors bg-jrs-navy hover:bg-jrs-red text-white h-8 px-3 gap-1 shadow-2xs">
                    <span>Manage</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
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

</div>
@endsection
