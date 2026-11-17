@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('header', 'Overview')

@section('content')
    <div class="space-y-6">

        <!-- Welcome Banner with Official Logo -->
        <div
            class="relative overflow-hidden rounded-2xl bg-jrs-navy p-6 sm:p-7 text-white shadow-sm border border-white/10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 max-w-xl text-center md:text-left z-10">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-jrs-red animate-pulse"></span>
                    Central Portal Active
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight font-heading text-white">
                    Welcome back, {{ Auth::user()->name ?? 'Administrator' }}
                </h2>
                <p class="text-xs sm:text-sm text-white/80 leading-relaxed">
                    Central administration for JRS International School. Control the homepage news ticker, hero slider
                    visuals, and world-class infrastructure facilities in real-time.
                </p>
                <div class="pt-2 flex flex-wrap gap-2 justify-center md:justify-start">
                    <a href="{{ route('admin.tickers.index') }}"
                        class="px-3.5 py-1.5 rounded-lg bg-jrs-red hover:opacity-95 text-xs font-semibold text-white shadow-xs transition-opacity inline-flex items-center gap-1.5">
                        <span>Marquee Ticker</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.sliders.index') }}"
                        class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                        <span>Hero Sliders</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.features.index') }}"
                        class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                        <span>Key Features</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.stats.index') }}"
                        class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                        <span>Stats Section</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.facilities.index') }}"
                        class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                        <span>Facilities</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.programs.index') }}"
                        class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                        <span>Academic Programs</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.academic-journeys.index') }}"
                        class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                        <span>Academic Journeys</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.beyond-classrooms.index') }}"
                        class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                        <span>Beyond Classroom</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.events.index') }}"
                        class="px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium backdrop-blur-sm transition-colors border border-white/20 inline-flex items-center gap-1.5 text-white">
                        <span>Latest Events</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            <div
                class="shrink-0 bg-white rounded-2xl p-4 shadow-xl shadow-black/30 flex items-center justify-center border border-white z-10">
                <img src="{{ asset('images/logo.png') }}" alt="JRS International School Logo"
                    class="h-16 sm:h-20 w-auto object-contain">
            </div>
            <!-- Decorative Glow using brand Red -->
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-jrs-red/20 rounded-full blur-3xl pointer-events-none">
            </div>
        </div>

    </div>
@endsection
