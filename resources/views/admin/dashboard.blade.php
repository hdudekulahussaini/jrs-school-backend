@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
<div class="space-y-6">

    <!-- Welcome Hero Banner -->
    <div class="bg-gradient-to-r from-jrs-navy via-jrs-navy-light to-jrs-navy rounded-2xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-white/10">
        <div class="relative z-10 max-w-3xl">
            <div class="flex items-center gap-2 mb-3">
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-jrs-red text-white shadow-sm">Dashboard Ready</span>
                <span class="text-xs text-amber-300 font-medium">JRS International School</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold font-heading tracking-tight">Welcome to JRS Admin Portal</h2>
            <p class="text-sm text-slate-300 mt-2 leading-relaxed">
                Your backend dashboard is active. You can now build and configure your school management modules one by one according to your requirements.
            </p>
            <div class="mt-5 flex flex-wrap items-center gap-3">
                <a href="https://jrs-school.vercel.app/" target="_blank" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-white text-jrs-navy hover:bg-slate-100 transition-all inline-flex items-center gap-2 shadow-sm">
                    <span>Visit Live React App</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- Quick Status Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card 1: System Status -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">System Status</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold text-slate-900 font-heading">Online</div>
                <p class="text-xs text-slate-500 mt-1">Laravel backend active on local server</p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Database:</span>
                <span class="font-semibold text-slate-700">SQLite (Connected)</span>
            </div>
        </div>

        <!-- Card 2: Frontend Integration -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">React Web App</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-jrs-accent flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold text-slate-900 font-heading truncate">jrs-school</div>
                <p class="text-xs text-slate-500 mt-1">Deployed on Vercel</p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Target URL:</span>
                <a href="https://jrs-school.vercel.app/" target="_blank" class="font-semibold text-jrs-red hover:underline">jrs-school.vercel.app</a>
            </div>
        </div>

        <!-- Card 3: Modules Configuration -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Module Setup</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold text-slate-900 font-heading">Clean Slate</div>
                <p class="text-xs text-slate-500 mt-1">Ready to create page by page</p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Next Action:</span>
                <span class="font-semibold text-amber-600">Choose First Section</span>
            </div>
        </div>
    </div>

    <!-- Instructions / Next Steps Box -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-jrs-navy text-white flex items-center justify-center shrink-0 shadow-md">
                <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900 font-heading">Ready to build your custom pages</h3>
                <p class="text-sm text-slate-600 mt-1 leading-relaxed">
                    The dashboard foundation is set up cleanly. Tell me which section you would like to build first (for example: <strong>Hero Banner</strong>, <strong>News Ticker</strong>, <strong>Admission Enquiries</strong>, <strong>Events</strong>, <strong>Academics</strong>, or <strong>Settings</strong>) and what fields or features you want on that page.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
