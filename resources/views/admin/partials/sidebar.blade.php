<!-- Sidebar Navigation -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-jrs-navy text-white transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto flex flex-col border-r border-white/10 shrink-0">
    <!-- Brand Header -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-white/10 bg-jrs-navy shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
            <div class="bg-white rounded-lg px-2 py-1.5 flex items-center justify-center shadow-xs shrink-0 group-hover:scale-105 transition-transform">
                <img src="{{ asset('images/logo.png') }}" alt="JRS International School" class="h-7 w-auto object-contain">
            </div>
            <div class="min-w-0">
                <div class="font-bold text-xs leading-tight text-white font-heading tracking-tight truncate group-hover:text-red-200 transition-colors">JRS School</div>
                <div class="text-[10px] text-white/60 font-medium tracking-wide">Admin Portal</div>
            </div>
        </a>
        <button id="closeSidebarBtn" type="button" class="lg:hidden text-white/60 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition-colors" aria-label="Close Sidebar">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Navigation Links Scroll Container -->
    <div class="flex-1 overflow-y-auto custom-scrollbar py-4 px-3 space-y-4">
        
        <!-- SECTION 1: MAIN MENU -->
        <div class="space-y-1">
            <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-white/40">Main Menu</div>
            
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.profile.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ request()->routeIs('admin.profile.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Admin Profile</span>
            </a>

            <a href="{{ route('admin.top-bar.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ request()->routeIs('admin.top-bar.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                <span>Header Top Bar</span>
            </a>

            <a href="{{ route('admin.breadcrumb-banners.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ request()->routeIs('admin.breadcrumb-banners.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Breadcrumb Banners</span>
            </a>
        </div>

        <!-- SECTION 2: WEBSITE CMS PAGES -->
        <div class="space-y-1">
            <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-white/40">Website Pages</div>

            <!-- Home Page Dropdown -->
            @php
                $isFacilitiesActive = request()->routeIs('admin.facilities.*') || request()->routeIs('admin.amenities.*');
                $isHomeActive = request()->routeIs('admin.tickers.*') || 
                                request()->routeIs('admin.sliders.*') || 
                                request()->routeIs('admin.features.*') || 
                                request()->routeIs('admin.stats.*') || 
                                $isFacilitiesActive || 
                                request()->routeIs('admin.programs.*') || 
                                request()->routeIs('admin.events.*');
            @endphp
            <div class="space-y-1">
                <button type="button" 
                        id="homeDropdownBtn"
                        onclick="toggleHomeDropdown()" 
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ $isHomeActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
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

                    <a href="{{ route('admin.facilities.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ $isFacilitiesActive ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $isFacilitiesActive ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Facilities</span>
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

            <!-- About Page Dropdown -->
            @php
                $isAboutActive = request()->routeIs('admin.about.*') 
                    || request()->routeIs('admin.vision-mission.*')
                    || request()->routeIs('admin.chairman.*')
                    || request()->routeIs('admin.principal.*')
                    || request()->routeIs('admin.campus-life.*')
                    || request()->routeIs('admin.why-choose.*')
                    || request()->routeIs('admin.educational-society.*')
                    || request()->routeIs('admin.school-management-committee.*')
                    || request()->routeIs('admin.pta-members.*')
                    || request()->routeIs('admin.admission-banner.*')
                    || request()->routeIs('admin.mandatory-disclosure.*');
            @endphp
            <div class="space-y-1">
                <button type="button" 
                        id="aboutDropdownBtn"
                        onclick="toggleAboutDropdown()" 
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ $isAboutActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
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

                    <!-- Leadership Sub-Dropdown -->
                    @php
                        $isLeadershipActive = request()->routeIs('admin.chairman.*') || request()->routeIs('admin.principal.*');
                    @endphp
                    <div class="space-y-1">
                        <button type="button" 
                                id="leadershipDropdownBtn"
                                onclick="toggleLeadershipDropdown(event)" 
                                class="w-full flex items-center justify-between px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ $isLeadershipActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span>Leadership</span>
                            </div>
                            <svg id="leadershipDropdownArrow" class="w-3 h-3 shrink-0 transition-transform duration-200 {{ $isLeadershipActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div id="leadershipDropdownMenu" class="{{ $isLeadershipActive ? '' : 'hidden' }} pl-3 pr-1 py-1 space-y-1 border-l border-white/10 ml-3">
                            <a href="{{ route('admin.chairman.index') }}" class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[11px] font-medium transition-colors {{ request()->routeIs('admin.chairman.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.chairman.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                                <span>Chairman of JRS</span>
                            </a>

                            <a href="{{ route('admin.principal.index') }}" class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[11px] font-medium transition-colors {{ request()->routeIs('admin.principal.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.principal.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                                <span>Principal of JRS</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.campus-life.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.campus-life.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.campus-life.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Campus Tour & Life</span>
                    </a>

                    <a href="{{ route('admin.why-choose.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.why-choose.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.why-choose.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Why Choose JRS</span>
                    </a>

                    <!-- Committee Sub-Dropdown -->
                    @php
                        $isCommitteeActive = request()->routeIs('admin.educational-society.*') || request()->routeIs('admin.school-management-committee.*') || request()->routeIs('admin.pta-members.*');
                    @endphp
                    <div class="space-y-1">
                        <button type="button" 
                                id="committeeDropdownBtn"
                                onclick="toggleCommitteeDropdown(event)" 
                                class="w-full flex items-center justify-between px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ $isCommitteeActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                <span>Committee</span>
                            </div>
                            <svg id="committeeDropdownArrow" class="w-3 h-3 shrink-0 transition-transform duration-200 {{ $isCommitteeActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div id="committeeDropdownMenu" class="{{ $isCommitteeActive ? '' : 'hidden' }} pl-3 pr-1 py-1 space-y-1 border-l border-white/10 ml-3">
                            <a href="{{ route('admin.educational-society.index') }}" class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[11px] font-medium transition-colors {{ request()->routeIs('admin.educational-society.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.educational-society.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                                <span>Educational Society</span>
                            </a>

                            <a href="{{ route('admin.school-management-committee.index') }}" class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[11px] font-medium transition-colors {{ request()->routeIs('admin.school-management-committee.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.school-management-committee.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                                <span>School Management Committee</span>
                            </a>

                            <a href="{{ route('admin.pta-members.index') }}" class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[11px] font-medium transition-colors {{ request()->routeIs('admin.pta-members.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.pta-members.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                                <span>PTA Committee</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.admission-banner.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.admission-banner.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.admission-banner.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Admission Banner</span>
                    </a>

                    <a href="{{ route('admin.mandatory-disclosure.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.mandatory-disclosure.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.mandatory-disclosure.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Mandatory Disclosure</span>
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
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ $isAcademicsActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
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
                $isAmenitiesActive = request()->routeIs('admin.facilities.*') || request()->routeIs('admin.amenities.*') || request()->routeIs('admin.amenities-cta.*');
                $isFacilitiesActive = request()->routeIs('admin.facilities.*') || request()->routeIs('admin.amenities.*');
                $isAmenitiesCtaActive = request()->routeIs('admin.amenities-cta.*');
            @endphp
            <div class="space-y-1">
                <button type="button" 
                        id="amenitiesDropdownBtn"
                        onclick="toggleAmenitiesDropdown()" 
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ $isAmenitiesActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Amenities Page</span>
                    </div>
                    <svg id="amenitiesDropdownArrow" class="w-4 h-4 shrink-0 transition-transform duration-200 {{ $isAmenitiesActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div id="amenitiesDropdownMenu" class="{{ $isAmenitiesActive ? '' : 'hidden' }} pl-4 pr-1 py-1 space-y-1 border-l border-white/10 ml-5">
                    <a href="{{ route('admin.amenities-cta.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ $isAmenitiesCtaActive ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $isAmenitiesCtaActive ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>CTA Banner Section</span>
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
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ $isBeyondActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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

            <!-- Admissions Dropdown -->
            @php
                $isAdmissionsActive = request()->routeIs('admin.admission-hero.*') || 
                                      request()->routeIs('admin.admission-steps.*') || 
                                      request()->routeIs('admin.admission-criteria.*') || 
                                      request()->routeIs('admin.admission-faqs.*') || 
                                      request()->routeIs('admin.admission-banner.*');
            @endphp
            <div class="space-y-1">
                <button type="button" 
                        id="admissionsDropdownBtn"
                        onclick="toggleAdmissionsDropdown()" 
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ $isAdmissionsActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Admissions</span>
                    </div>
                    <svg id="admissionsDropdownArrow" class="w-4 h-4 shrink-0 transition-transform duration-200 {{ $isAdmissionsActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div id="admissionsDropdownMenu" class="{{ $isAdmissionsActive ? '' : 'hidden' }} pl-4 pr-1 py-1 space-y-1 border-l border-white/10 ml-5">
                    <a href="{{ route('admin.admission-hero.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.admission-hero.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.admission-hero.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Admission Open (Hero)</span>
                    </a>

                    <a href="{{ route('admin.admission-steps.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.admission-steps.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.admission-steps.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Admission Process</span>
                    </a>

                    <a href="{{ route('admin.admission-criteria.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.admission-criteria.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.admission-criteria.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Criteria & Guidelines</span>
                    </a>

                    <a href="{{ route('admin.admission-faqs.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.admission-faqs.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.admission-faqs.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Admission FAQs</span>
                    </a>

                    <a href="{{ route('admin.admission-banner.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request()->routeIs('admin.admission-banner.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.admission-banner.*') ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Admission Banner</span>
                    </a>
                </div>
            </div>

            <!-- Careers Page Dropdown -->
            @php
                $isCareersActive = request()->routeIs('admin.careers-teaching.*') || request()->routeIs('admin.careers-benefits.*') || request()->routeIs('admin.careers-opportunities.*');
            @endphp
            <div class="space-y-1">
                <button type="button" 
                        id="careersDropdownBtn"
                        onclick="toggleCareersDropdown()" 
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ $isCareersActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
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
                </div>
            </div>

            <!-- Gallery Page Dropdown -->
            @php
                $isGalleryActive = request()->routeIs('admin.gallery-albums.*') || request()->routeIs('admin.gallery-items.*') || request()->routeIs('admin.news-media.*');
                $isGalleryAlbumsActive = request()->routeIs('admin.gallery-albums.*');
                $isGalleryItemsActive = request()->routeIs('admin.gallery-items.*');
                $isNewsMediaActive = request()->routeIs('admin.news-media.*');
            @endphp
            <div class="space-y-1">
                <button type="button" 
                        id="galleryDropdownBtn"
                        onclick="toggleGalleryDropdown()" 
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ $isGalleryActive ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Gallery Page</span>
                    </div>
                    <svg id="galleryDropdownArrow" class="w-4 h-4 shrink-0 transition-transform duration-200 {{ $isGalleryActive ? 'rotate-180 text-white' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div id="galleryDropdownMenu" class="{{ $isGalleryActive ? '' : 'hidden' }} pl-4 pr-1 py-1 space-y-1 border-l border-white/10 ml-5">
                    <a href="{{ route('admin.gallery-albums.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ $isGalleryAlbumsActive ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $isGalleryAlbumsActive ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Album Sections (6)</span>
                    </a>

                    <a href="{{ route('admin.gallery-items.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ $isGalleryItemsActive ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $isGalleryItemsActive ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>Photos & Videos</span>
                    </a>

                    <a href="{{ route('admin.news-media.index') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ $isNewsMediaActive ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $isNewsMediaActive ? 'bg-white ring-2 ring-white/30' : 'bg-white/40' }}"></span>
                        <span>News & Media (Press)</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- SECTION 3: INQUIRIES & CRM -->
        <div class="space-y-1">
            <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-white/40">Inquiries & CRM</div>

            <a href="{{ route('admin.admission-enquiries.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ request()->routeIs('admin.admission-enquiries.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>Admission Enquiries</span>
            </a>

            <a href="{{ route('admin.contact-inquiries.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ request()->routeIs('admin.contact-inquiries.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                <svg class="w-4 h-4 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>Contact Inquiries</span>
            </a>

            <a href="{{ route('admin.contact-settings.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ request()->routeIs('admin.contact-settings.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Contact Us Settings</span>
            </a>
        </div>

        <!-- SECTION 4: DEVELOPER & SYSTEM -->
        <div class="space-y-1">
            <div class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-white/40">Developer & System</div>

            <a href="{{ route('admin.swagger') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all {{ request()->routeIs('admin.swagger') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                <svg class="w-4 h-4 shrink-0 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                <span>Swagger API Docs</span>
            </a>
        </div>

    </div>

    <!-- User Footer Info & Logout -->
    <div class="p-3 border-t border-white/10 bg-jrs-navy flex items-center justify-between shrink-0">
        <a href="{{ route('admin.profile.index') }}" class="flex items-center gap-2.5 overflow-hidden group flex-1 mr-2" title="Manage Profile Settings">
            <div class="w-8 h-8 rounded-full bg-jrs-red text-white border border-white/20 flex items-center justify-center font-bold text-xs shrink-0 group-hover:scale-105 transition-transform shadow-xs">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="truncate">
                <div class="text-xs font-semibold text-white truncate group-hover:text-red-200 transition-colors">{{ Auth::user()->name ?? 'Administrator' }}</div>
                <div class="text-[11px] text-white/60 truncate">{{ Auth::user()->email ?? 'admin@jrsschool.com' }}</div>
            </div>
        </a>
        <form action="{{ route('admin.logout') }}" method="POST" class="shrink-0">
            @csrf
            <button type="submit" title="Sign Out" class="p-2 text-white/60 hover:text-white hover:bg-red-600/80 rounded-lg transition-colors" aria-label="Sign Out">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </button>
        </form>
    </div>
</aside>
