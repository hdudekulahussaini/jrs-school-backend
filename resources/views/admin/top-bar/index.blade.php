@extends('admin.layout')

@section('title', 'Header Top Bar | JRS School Admin')
@section('header', 'Header Top Bar Settings')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Bar Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-heading">Header Top Bar</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $topBar->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                    {{ $topBar->is_active ? 'Active on Website' : 'Hidden' }}
                </span>
            </div>
            <p class="text-sm text-slate-500">
                Manage global header contact details, phone number, email address, CBSE affiliation, mandatory disclosure documents, and school prospectus.
            </p>
        </div>
    </div>

    <!-- Live Top Bar Preview Card -->
    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Live Website Header Preview</span>
            <span class="text-xs text-slate-400">Updates live when saved</span>
        </div>
        
        <div class="rounded-2xl border border-slate-200/80 bg-white p-3 shadow-xs overflow-hidden">
            <!-- Actual Top Bar Representation -->
            <div class="w-full bg-[#f1f5f9] text-[#1e293b] py-2.5 px-4 sm:px-6 rounded-xl border border-slate-200/60 flex flex-col lg:flex-row items-center justify-between gap-3 text-xs font-medium">
                
                <!-- Left: Phone • Email • CBSE Affiliation -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-x-3 gap-y-1.5">
                    <!-- Phone -->
                    <div class="flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-[#031c3f] text-white flex items-center justify-center shrink-0">
                            <svg class="w-2.5 h-2.5 fill-current" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                        </span>
                        <span class="font-bold text-[#e31e24] tracking-wide">{{ $topBar->phone }}</span>
                    </div>

                    <span class="text-slate-300 font-bold">•</span>

                    <!-- Email -->
                    <div class="flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-[#031c3f] text-white flex items-center justify-center shrink-0">
                            <svg class="w-2.5 h-2.5 fill-current" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                        </span>
                        <span class="text-slate-700 hover:text-[#031c3f] transition-colors">{{ $topBar->email }}</span>
                    </div>

                    <span class="text-slate-300 font-bold">•</span>

                    <!-- CBSE Affiliation -->
                    <div class="flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-[#031c3f] text-white flex items-center justify-center shrink-0">
                            <svg class="w-2.5 h-2.5 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                        </span>
                        <span class="text-slate-700 font-medium">{{ $topBar->cbse_affiliation_text }}</span>
                    </div>
                </div>

                <!-- Right: Mandatory Disclosure • School Prospectus -->
                <div class="flex flex-wrap items-center justify-center lg:justify-end gap-x-3 gap-y-1.5">
                    <!-- Mandatory Disclosure -->
                    <a href="{{ $topBar->mandatory_disclosure_link }}" target="_blank" class="flex items-center gap-1.5 text-slate-700 hover:text-jrs-navy transition-colors">
                        <span class="w-5 h-5 rounded-full bg-[#031c3f] text-white flex items-center justify-center shrink-0">
                            <svg class="w-2.5 h-2.5 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                        </span>
                        <span>{{ $topBar->mandatory_disclosure_title }}</span>
                    </a>

                    <span class="text-slate-300 font-bold">•</span>

                    <!-- School Prospectus -->
                    <a href="{{ $topBar->prospectus_link }}" target="_blank" class="flex items-center gap-1.5 text-slate-700 hover:text-jrs-navy transition-colors">
                        <span class="w-5 h-5 rounded-full bg-[#031c3f] text-white flex items-center justify-center shrink-0">
                            <svg class="w-2.5 h-2.5 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </span>
                        <span>{{ $topBar->prospectus_title }}</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
            <p class="font-semibold mb-1">Please fix the following issues:</p>
            <ul class="list-disc list-inside space-y-0.5 text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Settings Form -->
    <form action="{{ route('admin.top-bar.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-6 sm:p-8 bg-white border border-slate-200 rounded-2xl shadow-xs space-y-6">

            <!-- Section 1: Contact Details -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-jrs-navy/10 text-jrs-navy flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </span>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700">Contact Details (Left Section)</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="phone" class="block text-xs font-semibold text-slate-700">
                            Phone Number <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $topBar->phone) }}" required placeholder="+91 915740 43210" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy font-semibold text-rose-600">
                        <p class="text-[11px] text-slate-400">Displayed in red highlighting on the top bar.</p>
                    </div>

                    <div class="space-y-1.5">
                        <label for="phone_href" class="block text-xs font-semibold text-slate-700">
                            Phone Dial URL (tel:)
                        </label>
                        <input type="text" id="phone_href" name="phone_href" value="{{ old('phone_href', $topBar->phone_href) }}" placeholder="tel:+9191574043210" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                        <p class="text-[11px] text-slate-400">Leave blank to auto-format from phone number.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-semibold text-slate-700">
                            Email Address <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $topBar->email) }}" required placeholder="info@jrsinternationalschool.com" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>

                    <div class="space-y-1.5">
                        <label for="email_href" class="block text-xs font-semibold text-slate-700">
                            Email URL (mailto:)
                        </label>
                        <input type="text" id="email_href" name="email_href" value="{{ old('email_href', $topBar->email_href) }}" placeholder="mailto:info@jrsinternationalschool.com" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="cbse_affiliation_text" class="block text-xs font-semibold text-slate-700">
                            Affiliation Badge Text <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="cbse_affiliation_text" name="cbse_affiliation_text" value="{{ old('cbse_affiliation_text', $topBar->cbse_affiliation_text) }}" required placeholder="CBSE Affiliated School" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>

                    <div class="space-y-1.5">
                        <label for="cbse_affiliation_code" class="block text-xs font-semibold text-slate-700">
                            Affiliation Code (Optional)
                        </label>
                        <input type="text" id="cbse_affiliation_code" name="cbse_affiliation_code" value="{{ old('cbse_affiliation_code', $topBar->cbse_affiliation_code) }}" placeholder="e.g. 3630372" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 2: Mandatory Disclosure Document -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-jrs-navy/10 text-jrs-navy flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </span>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700">Mandatory Disclosure</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="mandatory_disclosure_title" class="block text-xs font-semibold text-slate-700">
                            Display Label <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="mandatory_disclosure_title" name="mandatory_disclosure_title" value="{{ old('mandatory_disclosure_title', $topBar->mandatory_disclosure_title) }}" required placeholder="Mandatory Disclosure" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>

                    <div class="space-y-1.5">
                        <label for="mandatory_disclosure_url" class="block text-xs font-semibold text-slate-700">
                            External Document URL (Optional)
                        </label>
                        <input type="url" id="mandatory_disclosure_url" name="mandatory_disclosure_url" value="{{ old('mandatory_disclosure_url', $topBar->mandatory_disclosure_url) }}" placeholder="https://..." class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                        <p class="text-[11px] text-slate-400">Used if no file is uploaded below.</p>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700">
                        Upload Mandatory Disclosure PDF
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="file" name="mandatory_disclosure_file_upload" accept=".pdf,.doc,.docx" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy/10 file:text-jrs-navy hover:file:bg-jrs-navy/20 cursor-pointer">
                        @if($topBar->mandatory_disclosure_file)
                            <a href="{{ asset(ltrim($topBar->mandatory_disclosure_file, '/')) }}" target="_blank" class="shrink-0 px-3 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Current PDF</span>
                            </a>
                        @endif
                    </div>
                    <p class="text-[11px] text-slate-400">Max size 20MB. Uploading a new PDF overrides the external URL.</p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 3: School Prospectus Document -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-jrs-navy/10 text-jrs-navy flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </span>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700">School Prospectus</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="prospectus_title" class="block text-xs font-semibold text-slate-700">
                            Display Label <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="prospectus_title" name="prospectus_title" value="{{ old('prospectus_title', $topBar->prospectus_title) }}" required placeholder="School Prospectus" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>

                    <div class="space-y-1.5">
                        <label for="prospectus_url" class="block text-xs font-semibold text-slate-700">
                            External Prospectus URL (Optional)
                        </label>
                        <input type="url" id="prospectus_url" name="prospectus_url" value="{{ old('prospectus_url', $topBar->prospectus_url) }}" placeholder="https://..." class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                        <p class="text-[11px] text-slate-400">Used if no prospectus file is uploaded below.</p>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700">
                        Upload School Prospectus PDF
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="file" name="prospectus_file_upload" accept=".pdf,.doc,.docx" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy/10 file:text-jrs-navy hover:file:bg-jrs-navy/20 cursor-pointer">
                        @if($topBar->prospectus_file)
                            <a href="{{ asset(ltrim($topBar->prospectus_file, '/')) }}" target="_blank" class="shrink-0 px-3 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Current PDF</span>
                            </a>
                        @endif
                    </div>
                    <p class="text-[11px] text-slate-400">Max size 20MB. Uploading a new PDF overrides the external URL.</p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 4: Display Status -->
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex items-start gap-3">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $topBar->is_active) ? 'checked' : '' }} class="mt-1 w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500">
                <div>
                    <label for="is_active" class="text-sm font-bold text-slate-800 cursor-pointer">
                        Enable Header Top Bar on Website
                    </label>
                    <p class="text-xs text-slate-500 mt-0.5">
                        When enabled, this bar appears at the very top of all pages across the website.
                    </p>
                </div>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-jrs-red hover:opacity-95 text-white transition-all shadow-xs flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Save Top Bar Settings</span>
            </button>
        </div>

    </form>
</div>
@endsection
