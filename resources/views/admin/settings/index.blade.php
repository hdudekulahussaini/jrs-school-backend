@extends('admin.layout')

@section('title', 'School Settings')
@section('header', 'School Configuration & Contact Settings')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
        <h3 class="text-base font-bold text-slate-900 font-heading mb-1">Global School Contact & Admissions Details</h3>
        <p class="text-xs text-slate-500 mb-6">These values dynamically feed into the top header, admissions forms, brochure downloads, and footer of the React website.</p>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Section 1: Basic School Identity -->
            <div class="border-b border-slate-100 pb-5">
                <h4 class="text-xs font-bold uppercase tracking-wider text-jrs-navy mb-3">1. School Identity</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">School Name</label>
                        <input type="text" name="school_name" value="{{ $settings['school_name'] ?? 'JRS International School' }}" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tagline</label>
                        <input type="text" name="tagline" value="{{ $settings['tagline'] ?? 'Empowering Future Leaders' }}" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">CBSE Affiliation Text</label>
                        <input type="text" name="affiliation_text" value="{{ $settings['affiliation_text'] ?? 'CBSE Affiliated Senior Secondary School' }}" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">
                    </div>
                </div>
            </div>

            <!-- Section 2: Admissions & Helplines -->
            <div class="border-b border-slate-100 pb-5">
                <h4 class="text-xs font-bold uppercase tracking-wider text-jrs-navy mb-3">2. Admissions & Helpline</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Admissions Phone 1</label>
                        <input type="text" name="admissions_phone_1" value="{{ $settings['admissions_phone_1'] ?? '+91 91009 55555' }}" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Admissions Phone 2</label>
                        <input type="text" name="admissions_phone_2" value="{{ $settings['admissions_phone_2'] ?? '+91 91009 66666' }}" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Admissions Email</label>
                        <input type="email" name="admissions_email" value="{{ $settings['admissions_email'] ?? 'admissions@jrsinternationalschool.com' }}" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Current Academic Year</label>
                        <input type="text" name="academic_year" value="{{ $settings['academic_year'] ?? '2026-2027' }}" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">
                    </div>
                </div>
            </div>

            <!-- Section 3: General Contact & Prospectus -->
            <div class="border-b border-slate-100 pb-5">
                <h4 class="text-xs font-bold uppercase tracking-wider text-jrs-navy mb-3">3. School Contact & Prospectus</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Official School Phone</label>
                        <input type="text" name="phone" value="{{ $settings['phone'] ?? '+91 915740 43210' }}" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Official School Email</label>
                        <input type="email" name="email" value="{{ $settings['email'] ?? 'info@jrsinternationalschool.com' }}" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Prospectus Brochure PDF Download URL</label>
                        <input type="text" name="prospectus_url" value="{{ $settings['prospectus_url'] ?? 'https://jrsinternationalschooluppal.com/wp-content/uploads/2022/01/Brochure-2020-JRS.pdf' }}" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Campus Address</label>
                        <textarea name="campus_address" rows="2" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-jrs-red">{{ $settings['campus_address'] ?? 'Survey No. 44 & 45, Narapally, Near Uppal, Hyderabad, Telangana - 500098' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-jrs-red hover:bg-jrs-red-dark shadow-md shadow-red-600/30 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save School Settings</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
