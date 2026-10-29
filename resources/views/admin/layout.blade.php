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
        <!-- Sidebar Navigation Component -->
        @include('admin.partials.sidebar')

        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-jrs-navy/80 backdrop-blur-xs z-30 hidden lg:hidden"></div>

        <!-- Main Content Area with Header and Footer -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Top Header Component -->
            @include('admin.partials.header')

            <!-- Page Body Content -->
            <main class="flex-1 p-4 sm:p-8">
                @yield('content')
            </main>

            <!-- Footer Component -->
            @include('admin.partials.footer')
        </div>
    </div>

    <!-- Scripts for mobile sidebar & dropdown menus -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');
        const backdrop = document.getElementById('sidebarBackdrop');

        function toggleSidebar() {
            if (sidebar) sidebar.classList.toggle('-translate-x-full');
            if (backdrop) backdrop.classList.toggle('hidden');
        }

        if (openBtn) openBtn.addEventListener('click', toggleSidebar);
        if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        if (backdrop) backdrop.addEventListener('click', toggleSidebar);

        // Helper for dropdown toggles
        function toggleDropdown(menuId, arrowId) {
            const menu = document.getElementById(menuId);
            const arrow = document.getElementById(arrowId);
            if (menu) menu.classList.toggle('hidden');
            if (arrow) arrow.classList.toggle('rotate-180');
        }

        // Backward-compatible named toggle functions
        function toggleHomeDropdown() { toggleDropdown('homeDropdownMenu', 'homeDropdownArrow'); }
        function toggleAcademicsDropdown() { toggleDropdown('academicsDropdownMenu', 'academicsDropdownArrow'); }
        function toggleAmenitiesDropdown() { toggleDropdown('amenitiesDropdownMenu', 'amenitiesDropdownArrow'); }
        function toggleBeyondDropdown() { toggleDropdown('beyondDropdownMenu', 'beyondDropdownArrow'); }
        function toggleAboutDropdown() { toggleDropdown('aboutDropdownMenu', 'aboutDropdownArrow'); }
        function toggleAdmissionsDropdown() { toggleDropdown('admissionsDropdownMenu', 'admissionsDropdownArrow'); }
        function toggleCareersDropdown() { toggleDropdown('careersDropdownMenu', 'careersDropdownArrow'); }
        function toggleLeadershipDropdown(e) {
            if (e) e.stopPropagation();
            toggleDropdown('leadershipDropdownMenu', 'leadershipDropdownArrow');
        }
        function toggleCommitteeDropdown(e) {
            if (e) e.stopPropagation();
            toggleDropdown('committeeDropdownMenu', 'committeeDropdownArrow');
        }
        function toggleMandatoryDropdown(e) {
            if (e) e.stopPropagation();
            toggleDropdown('mandatoryDropdownMenu', 'mandatoryDropdownArrow');
        }
        function toggleGalleryDropdown() { toggleDropdown('galleryDropdownMenu', 'galleryDropdownArrow'); }

    </script>
    @stack('scripts')

    <!-- PHPFlasher Google Material Design Theme -->
    @include('admin.partials.flasher-material')
</body>
</html>
