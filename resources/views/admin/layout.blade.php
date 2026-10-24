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

                <a href="{{ route('admin.tickers.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('admin.tickers.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    <span>News Ticker</span>
                </a>

                <a href="{{ route('admin.sliders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('admin.sliders.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Hero Sliders</span>
                </a>

                <a href="{{ route('admin.facilities.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('admin.facilities.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Facilities</span>
                </a>

                @php
                    $isAboutActive = request()->routeIs('admin.about.*') || request()->routeIs('admin.vision-mission.*');
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
                    </div>
                </div>

                <a href="{{ route('admin.programs.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('admin.programs.*') ? 'bg-jrs-red text-white font-semibold shadow-xs' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    <span>Academic Programs</span>
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-white/40">Developer</div>
                <a href="{{ route('admin.swagger') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors text-white/70 hover:text-white hover:bg-white/10">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    <span>Swagger API Docs</span>
                </a>
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
    </script>
    @stack('scripts')
</body>
</html>
