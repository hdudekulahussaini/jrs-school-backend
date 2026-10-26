<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | JRS International School</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Google Fonts: Inter & Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        jrs: {
                            navy: 'rgb(3 28 63 / <alpha-value>)',
                            red: 'rgb(227 30 36 / <alpha-value>)',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Manrope', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            background-color: #f8fafc;
            color: rgb(3 28 63);
        }
        h1, h2, h3, h4, h5, h6, .font-heading, th {
            font-family: 'Manrope', -apple-system, BlinkMacSystemFont, sans-serif !important;
            letter-spacing: -0.025em;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgb(3 28 63);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgb(227 30 36);
        }
    </style>
    @stack('styles')
</head>
<body class="text-slate-900 antialiased min-h-screen flex flex-col font-sans">

    <div class="flex h-screen overflow-hidden bg-slate-50/50">
        <!-- Sidebar Navigation -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-jrs-navy text-white transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto flex flex-col border-r border-white/10 shrink-0">
            <!-- Brand Header -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-white/10 bg-jrs-navy">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
                    <div class="bg-white rounded-lg px-2 py-1.5 flex items-center justify-center shadow-xs shrink-0">
                        <img src="{{ asset('images/logo.png') }}" alt="JRS International School" class="h-7 w-auto object-contain">
                    </div>
                    <div class="min-w-0">
                        <div class="font-bold text-xs leading-tight text-white font-heading tracking-tight truncate group-hover:text-red-200 transition-colors">JRS School</div>
                        <div class="text-[10px] text-white/60 font-medium tracking-wide">Admin Portal</div>
                    </div>
                </a>
                <button id="closeSidebarBtn" class="lg:hidden text-white/60 hover:text-white p-1 rounded-md hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto custom-scrollbar py-4 px-3 space-y-1">
                <div class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-white/40">Main Menu</div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>

                <!-- Home Page Dropdown -->
                @php
                    $isHomeActive = request()->routeIs('admin.tickers.*') || 
                                    request()->routeIs('admin.sliders.*') || 
                                    request()->routeIs('admin.features.*') || 
                                    request()->routeIs('admin.stats.*') || 
                                    request()->routeIs('admin.facilities.*') || 
                                    request()->routeIs('admin.programs.*') || 
                                    request()->routeIs('admin.beyond-classrooms.*') || 
                                    request()->routeIs('admin.events.*');
                @endphp
                <div class="space-y-1">
                    <button type="button" 
                            id="homeDropdownBtn"
                            onclick="toggleHomeDropdown()" 
                            class="w-full flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $isHomeActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Home Page</span>
                        </div>
                        <svg id="homeDropdownArrow" class="w-4 h-4 shrink-0 transition-transform duration-200 {{ $isHomeActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="homeDropdownMenu" class="{{ $isHomeActive ? '' : 'hidden' }} pl-4 pr-1 py-1 space-y-1 border-l border-white/10 ml-5">
                        <a href="{{ route('admin.tickers.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.tickers.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.tickers.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>News Ticker</span>
                        </a>

                        <a href="{{ route('admin.sliders.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.sliders.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.sliders.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Hero Sliders</span>
                        </a>

                        <a href="{{ route('admin.features.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.features.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.features.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Key Features</span>
                        </a>

                        <a href="{{ route('admin.stats.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.stats.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.stats.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Stats Section</span>
                        </a>

                        <a href="{{ route('admin.programs.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.programs.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.programs.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Academic Programs</span>
                        </a>

                        <a href="{{ route('admin.events.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.events.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.events.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Latest Events</span>
                        </a>
                    </div>
                </div>

                <!-- Academics Page Dropdown -->
                @php
                    $isAcademicsActive = request()->routeIs('admin.academic-journeys.*');
                @endphp
                <div class="space-y-1">
                    <button type="button" 
                            id="academicsDropdownBtn"
                            onclick="toggleAcademicsDropdown()" 
                            class="w-full flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $isAcademicsActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            <span>Academics Page</span>
                        </div>
                        <svg id="academicsDropdownArrow" class="w-4 h-4 shrink-0 transition-transform duration-200 {{ $isAcademicsActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="academicsDropdownMenu" class="{{ $isAcademicsActive ? '' : 'hidden' }} pl-4 pr-1 py-1 space-y-1 border-l border-white/10 ml-5">
                        <a href="{{ route('admin.academic-journeys.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.academic-journeys.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.academic-journeys.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Academic Journeys</span>
                        </a>
                    </div>
                </div>

                <!-- Amenities Page Dropdown -->
                @php
                    $isAmenitiesActive = request()->routeIs('admin.facilities.*') || request()->routeIs('admin.amenities.*');
                @endphp
                <div class="space-y-1">
                    <button type="button" 
                            id="amenitiesDropdownBtn"
                            onclick="toggleAmenitiesDropdown()" 
                            class="w-full flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $isAmenitiesActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Amenities Page</span>
                        </div>
                        <svg id="amenitiesDropdownArrow" class="w-4 h-4 shrink-0 transition-transform duration-200 {{ $isAmenitiesActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="amenitiesDropdownMenu" class="{{ $isAmenitiesActive ? '' : 'hidden' }} pl-4 pr-1 py-1 space-y-1 border-l border-white/10 ml-5">
                        <a href="{{ route('admin.facilities.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ $isAmenitiesActive ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $isAmenitiesActive ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Facilities (8 Cards)</span>
                        </a>
                    </div>
                </div>

                <!-- Beyond Classroom Page Dropdown -->
                @php
                    $isBeyondActive = request()->routeIs('admin.beyond-classrooms.*') || request()->routeIs('admin.beyond-classroom-cta.*');
                @endphp
                <div class="space-y-1">
                    <button type="button" 
                            id="beyondDropdownBtn"
                            onclick="toggleBeyondDropdown()" 
                            class="w-full flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $isBeyondActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Beyond Classroom Page</span>
                        </div>
                        <svg id="beyondDropdownArrow" class="w-4 h-4 shrink-0 transition-transform duration-200 {{ $isBeyondActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="beyondDropdownMenu" class="{{ $isBeyondActive ? '' : 'hidden' }} pl-4 pr-1 py-1 space-y-1 border-l border-white/10 ml-5">
                        <a href="{{ route('admin.beyond-classrooms.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.beyond-classrooms.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.beyond-classrooms.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Activities (10 Cards)</span>
                        </a>

                        <a href="{{ route('admin.beyond-classroom-cta.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.beyond-classroom-cta.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.beyond-classroom-cta.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>CTA Banner Section</span>
                        </a>
                    </div>
                </div>

                <!-- About Page Dropdown -->
                @php
                    $isAboutActive = request()->routeIs('admin.about.*') 
                        || request()->routeIs('admin.vision-mission.*')
                        || request()->routeIs('admin.campus-life.*')
                        || request()->routeIs('admin.why-choose.*')
                        || request()->routeIs('admin.pta-members.*');
                @endphp
                <div class="space-y-1">
                    <button type="button" 
                            id="aboutDropdownBtn"
                            onclick="toggleAboutDropdown()" 
                            class="w-full flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $isAboutActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>About Page</span>
                        </div>
                        <svg id="aboutDropdownArrow" class="w-4 h-4 shrink-0 transition-transform duration-200 {{ $isAboutActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="aboutDropdownMenu" class="{{ $isAboutActive ? '' : 'hidden' }} pl-4 pr-1 py-1 space-y-1 border-l border-white/10 ml-5">
                        <a href="{{ route('admin.about.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.about.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.about.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>About JRS</span>
                        </a>

                        <a href="{{ route('admin.vision-mission.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.vision-mission.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.vision-mission.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Vision & Mission</span>
                        </a>

                        <a href="{{ route('admin.campus-life.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.campus-life.*') ? 'bg-slate-800 text-white font-semibold' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-900' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.campus-life.*') ? 'bg-emerald-400 ring-2 ring-emerald-400/30' : 'bg-slate-600' }}"></span>
                            <span>Campus Tour & Life</span>
                        </a>

                        <a href="{{ route('admin.why-choose.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.why-choose.*') ? 'bg-slate-800 text-white font-semibold' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-900' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.why-choose.*') ? 'bg-emerald-400 ring-2 ring-emerald-400/30' : 'bg-slate-600' }}"></span>
                            <span>Why Choose JRS</span>
                        </a>

                        <a href="{{ route('admin.pta-members.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.pta-members.*') ? 'bg-slate-800 text-white font-semibold' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-900' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.pta-members.*') ? 'bg-emerald-400 ring-2 ring-emerald-400/30' : 'bg-slate-600' }}"></span>
                            <span>PTA Committee</span>
                        </a>
                    </div>
                </div>

<<<<<<< HEAD
                <!-- Careers Page Dropdown -->
                @php
                    $isCareersActive = request()->routeIs('admin.careers-teaching.*') || request()->routeIs('admin.careers-benefits.*') || request()->routeIs('admin.careers-opportunities.*') || request()->routeIs('admin.job-openings.*');
                @endphp
                <div class="space-y-1">
                    <button type="button" 
                            id="careersDropdownBtn"
                            onclick="toggleCareersDropdown()" 
                            class="w-full flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $isCareersActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Careers Page</span>
                        </div>
                        <svg id="careersDropdownArrow" class="w-4 h-4 shrink-0 transition-transform duration-200 {{ $isCareersActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="careersDropdownMenu" class="{{ $isCareersActive ? '' : 'hidden' }} pl-4 pr-1 py-1 space-y-1 border-l border-white/10 ml-5">
                        <a href="{{ route('admin.careers-teaching.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.careers-teaching.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.careers-teaching.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Teaching at JRS</span>
                        </a>

                        <a href="{{ route('admin.careers-benefits.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.careers-benefits.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.careers-benefits.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Work Culture & Benefits</span>
                        </a>

                        <a href="{{ route('admin.careers-opportunities.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.careers-opportunities.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.careers-opportunities.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>How To Apply</span>
                        </a>

                        <a href="{{ route('admin.job-openings.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.job-openings.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.job-openings.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                            <span>Job Openings</span>
                        </a>
                    </div>
                </div>

                <div class="pt-4 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-white/40">Developer</div>
                <a href="{{ route('admin.swagger') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors text-white/70 hover:text-white hover:bg-white/10">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    <span>Swagger API Docs</span>
                </a>
=======
>>>>>>> 04ab64343de79bd33c3d967ec6538c01b8d40678
            </div>

            <!-- User Footer Info & Logout -->
            <div class="p-3 border-t border-white/10 bg-jrs-navy flex items-center justify-between">
                <div class="flex items-center gap-2.5 overflow-hidden">
                    <div class="w-8 h-8 rounded-full bg-jrs-red text-white border border-white/20 flex items-center justify-center font-bold text-xs shrink-0">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="truncate">
                        <div class="text-xs font-medium text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
                        <div class="text-[11px] text-white/60 truncate">{{ Auth::user()->email ?? 'admin@jrsschool.com' }}</div>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" title="Sign Out" class="p-1.5 text-white/60 hover:text-jrs-red hover:bg-white/10 rounded-md transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Backdrop for mobile sidebar -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-jrs-navy/80 backdrop-blur-xs z-30 hidden lg:hidden"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Top Navbar -->
            <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between shrink-0 sticky top-0 z-20">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button id="openSidebarBtn" class="lg:hidden text-jrs-navy hover:text-jrs-red p-2 rounded-md hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="lg:hidden flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="JRS Logo" class="h-7 w-auto object-contain">
                    </a>
                    <div>
                        <h1 class="text-base sm:text-lg font-bold text-jrs-navy font-heading tracking-tight leading-none">@yield('header', 'Admin Dashboard')</h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">

                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md text-xs font-semibold text-jrs-red hover:bg-jrs-red/10 border border-jrs-red/20 transition-colors" title="Sign Out">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 p-4 sm:p-8">
                <!-- Alerts -->
                @if(session('success'))
                    <div class="mb-6 p-3.5 rounded-lg bg-jrs-navy/5 border border-jrs-navy/20 text-jrs-navy text-sm flex items-center gap-3 shadow-2xs">
                        <svg class="w-4 h-4 text-jrs-navy shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-3.5 rounded-lg bg-jrs-red/5 border border-jrs-red/20 text-jrs-red text-sm flex items-center gap-3 shadow-2xs">
                        <svg class="w-4 h-4 text-jrs-red shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Sidebar Mobile Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');
        const backdrop = document.getElementById('sidebarBackdrop');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        if (openBtn) openBtn.addEventListener('click', toggleSidebar);
        if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        if (backdrop) backdrop.addEventListener('click', toggleSidebar);

        function toggleHomeDropdown() {
            const menu = document.getElementById('homeDropdownMenu');
            const arrow = document.getElementById('homeDropdownArrow');
            if (menu) {
                menu.classList.toggle('hidden');
            }
            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
        }

        function toggleAcademicsDropdown() {
            const menu = document.getElementById('academicsDropdownMenu');
            const arrow = document.getElementById('academicsDropdownArrow');
            if (menu) {
                menu.classList.toggle('hidden');
            }
            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
        }

        function toggleAmenitiesDropdown() {
            const menu = document.getElementById('amenitiesDropdownMenu');
            const arrow = document.getElementById('amenitiesDropdownArrow');
            if (menu) {
                menu.classList.toggle('hidden');
            }
            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
        }

        function toggleBeyondDropdown() {
            const menu = document.getElementById('beyondDropdownMenu');
            const arrow = document.getElementById('beyondDropdownArrow');
            if (menu) {
                menu.classList.toggle('hidden');
            }
            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
        }

        function toggleAboutDropdown() {
            const menu = document.getElementById('aboutDropdownMenu');
            const arrow = document.getElementById('aboutDropdownArrow');
            if (menu) {
                menu.classList.toggle('hidden');
            }
            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
        }

        function toggleCareersDropdown() {
            const menu = document.getElementById('careersDropdownMenu');
            const arrow = document.getElementById('careersDropdownArrow');
            if (menu) {
                menu.classList.toggle('hidden');
            }
            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
