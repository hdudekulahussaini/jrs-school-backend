<!-- Top Navbar Header -->
<header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between shrink-0 sticky top-0 z-20 shadow-xs">
    <!-- Left: Mobile Toggle & Page Title -->
    <div class="flex items-center gap-3 sm:gap-4 min-w-0">
        <button id="openSidebarBtn" type="button" class="lg:hidden text-jrs-navy hover:text-jrs-red p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Open Sidebar Menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="lg:hidden flex items-center shrink-0" title="JRS Admin Dashboard">
            <img src="{{ asset('images/logo.png') }}" alt="JRS Logo" class="h-7 w-auto object-contain">
        </a>
        <div class="min-w-0">
            <h1 class="text-base sm:text-lg font-bold text-jrs-navy font-heading tracking-tight leading-none truncate">
                @yield('header', 'Admin Dashboard')
            </h1>
        </div>
    </div>

    <!-- Right: User Profile Dropdown -->
    <div class="relative shrink-0">
        <!-- Dropdown Trigger Button -->
        <button type="button" 
                id="userProfileDropdownBtn" 
                class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 text-slate-700 transition-all focus:outline-hidden focus:ring-2 focus:ring-jrs-navy/20 cursor-pointer"
                aria-expanded="false" 
                aria-haspopup="true">
            <span class="w-7 h-7 rounded-full bg-jrs-navy text-white text-xs font-bold flex items-center justify-center shrink-0 shadow-xs">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </span>
            <div class="hidden sm:flex flex-col text-left">
                <span class="text-xs font-semibold text-slate-800 leading-tight max-w-[120px] truncate">
                    {{ Auth::user()->name ?? 'Administrator' }}
                </span>
                <span class="text-[10px] text-slate-500 font-medium leading-none">
                    Admin
                </span>
            </div>
            <svg id="userProfileDropdownArrow" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div id="userProfileDropdownMenu" 
             class="hidden absolute right-0 mt-2 w-60 sm:w-64 bg-white rounded-xl shadow-lg border border-slate-200/90 py-1 z-50 divide-y divide-slate-100"
             role="menu">
            
            <!-- User Info Summary Header -->
            <div class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-full bg-jrs-navy text-white text-sm font-bold flex items-center justify-center shrink-0 shadow-xs">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="text-xs font-bold text-slate-900 truncate font-heading">
                            {{ Auth::user()->name ?? 'Administrator' }}
                        </div>
                        <div class="text-[11px] text-slate-500 truncate">
                            {{ Auth::user()->email ?? 'admin@jrsschool.com' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Links Group -->
            <div class="py-1">
                <a href="{{ route('admin.profile.index') }}" 
                   class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-jrs-navy transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-slate-50 text-jrs-navy font-semibold' : '' }}" 
                   role="menuitem">
                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Profile Settings</span>
                </a>

            </div>

            <!-- Sign Out Section -->
            <div class="py-1">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-jrs-red hover:bg-red-50/80 transition-colors text-left cursor-pointer" 
                            role="menuitem">
                        <svg class="w-4 h-4 text-jrs-red shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const profileBtn = document.getElementById('userProfileDropdownBtn');
        const profileMenu = document.getElementById('userProfileDropdownMenu');
        const profileArrow = document.getElementById('userProfileDropdownArrow');

        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isHidden = profileMenu.classList.toggle('hidden');
                profileBtn.setAttribute('aria-expanded', !isHidden);
                if (profileArrow) {
                    profileArrow.classList.toggle('rotate-180', !isHidden);
                }
            });

            document.addEventListener('click', function (e) {
                if (!profileMenu.contains(e.target) && !profileBtn.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                    profileBtn.setAttribute('aria-expanded', 'false');
                    if (profileArrow) {
                        profileArrow.classList.remove('rotate-180');
                    }
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !profileMenu.classList.contains('hidden')) {
                    profileMenu.classList.add('hidden');
                    profileBtn.setAttribute('aria-expanded', 'false');
                    if (profileArrow) {
                        profileArrow.classList.remove('rotate-180');
                    }
                }
            });
        }
    });
</script>
