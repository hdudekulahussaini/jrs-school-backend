@extends('admin.layout')

@section('title', 'Edit Header Top Bar | JRS School Admin')
@section('header', 'Edit Header Top Bar Settings')

@section('content')
<div class="space-y-6 max-w-5xl">

    <!-- Top Action / Back Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-jrs-navy font-heading">Edit Header Top Bar</h2>
            <p class="text-xs text-slate-500 mt-0.5">Configure phone numbers, email address, affiliation text, and prospectus link.</p>
        </div>
        <a href="{{ route('admin.top-bar.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 shadow-2xs transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Back to Table Overview</span>
        </a>
    </div>

    @php
        $hasProspectusFile = !empty($topBar->prospectus_file);
        $prospectusType = old('prospectus_type', $hasProspectusFile ? 'file' : ($topBar->prospectus_url ? 'url' : 'file'));
    @endphp

    <!-- Settings Form -->
    <form action="{{ route('admin.top-bar.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-6 sm:p-8 bg-white border border-slate-200 rounded-2xl shadow-xs space-y-8">

            <!-- Section 1: Contact & Affiliation Details -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-jrs-navy/10 text-jrs-navy flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </span>
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 font-heading">Top Bar Details</h3>
                        <p class="text-xs text-slate-400">Essential contact details and school affiliation displayed in the header top bar.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-1">
                    <!-- Phone Number (Primary) -->
                    <div class="space-y-1.5">
                        <label for="phone" class="block text-xs font-semibold text-slate-700">
                            Phone Number <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $topBar->phone) }}" required placeholder="+91 915740 43210" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy font-semibold text-rose-600">
                        @error('phone') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Additional Phone Number -->
                    <div class="space-y-1.5">
                        <label for="phone_2" class="block text-xs font-semibold text-slate-700">
                            Additional Phone Number <span class="text-slate-400 font-normal">(Optional)</span>
                        </label>
                        <input type="text" id="phone_2" name="phone_2" value="{{ old('phone_2', $topBar->phone_2) }}" placeholder="+91 915740 43211" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy font-semibold text-rose-600">
                        @error('phone_2') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-semibold text-slate-700">
                            Email Address <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $topBar->email) }}" required placeholder="info@jrsinternationalschool.com" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                        @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Affiliation Badge Text -->
                    <div class="space-y-1.5">
                        <label for="cbse_affiliation_text" class="block text-xs font-semibold text-slate-700">
                            Affiliation Badge Text <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="cbse_affiliation_text" name="cbse_affiliation_text" value="{{ old('cbse_affiliation_text', $topBar->cbse_affiliation_text) }}" required placeholder="CBSE Affiliated School" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                        @error('cbse_affiliation_text') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 2: School Prospectus -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-jrs-navy/10 text-jrs-navy flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </span>
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 font-heading">School Prospectus</h3>
                        <p class="text-xs text-slate-400">Select URL or Upload option to provide the prospectus on the header.</p>
                    </div>
                </div>

                <!-- Source Choice Segmented Radio -->
                <div class="flex flex-wrap items-center gap-3 pt-1">
                    <label id="opt_prosp_file" class="flex items-center gap-2 px-3.5 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition-all {{ $prospectusType === 'file' ? 'border-jrs-navy bg-jrs-navy/5 text-jrs-navy shadow-xs ring-1 ring-jrs-navy/20' : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300' }}">
                        <input type="radio" name="prospectus_type" value="file" {{ $prospectusType === 'file' ? 'checked' : '' }} class="text-jrs-navy focus:ring-jrs-navy">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <span>Upload File (PDF)</span>
                    </label>

                    <label id="opt_prosp_url" class="flex items-center gap-2 px-3.5 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition-all {{ $prospectusType === 'url' ? 'border-jrs-navy bg-jrs-navy/5 text-jrs-navy shadow-xs ring-1 ring-jrs-navy/20' : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300' }}">
                        <input type="radio" name="prospectus_type" value="url" {{ $prospectusType === 'url' ? 'checked' : '' }} class="text-jrs-navy focus:ring-jrs-navy">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <span>External Link (URL)</span>
                    </label>
                </div>

                <!-- File Upload Container -->
                <div id="container_prosp_file" class="space-y-2 pt-1 {{ $prospectusType === 'file' ? '' : 'hidden' }}">
                    <label class="block text-xs font-semibold text-slate-700">
                        Upload School Prospectus Document (PDF)
                    </label>
                    <div class="space-y-2">
                        <input type="file" name="prospectus_file_upload" accept=".pdf,.doc,.docx" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy/10 file:text-jrs-navy hover:file:bg-jrs-navy/20 cursor-pointer border border-slate-200 rounded-xl bg-slate-50/50 p-1.5">
                        
                        @if($topBar->prospectus_file)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-semibold text-slate-800">Current Uploaded File</div>
                                        <div class="text-[11px] text-slate-400 truncate max-w-xs sm:max-w-md">{{ basename($topBar->prospectus_file) }}</div>
                                    </div>
                                </div>
                                <a href="{{ asset(ltrim($topBar->prospectus_file, '/')) }}" target="_blank" class="shrink-0 px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition-colors flex items-center gap-1.5 shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    <span>View File</span>
                                </a>
                            </div>
                        @endif
                    </div>
                    <p class="text-[11px] text-slate-400">PDF, DOC, or DOCX formats accepted. Max size 20MB.</p>
                </div>

                <!-- URL Container -->
                <div id="container_prosp_url" class="space-y-1.5 pt-1 {{ $prospectusType === 'url' ? '' : 'hidden' }}">
                    <label for="prospectus_url" class="block text-xs font-semibold text-slate-700">
                        School Prospectus Document URL
                    </label>
                    <input type="url" id="prospectus_url" name="prospectus_url" value="{{ old('prospectus_url', $topBar->prospectus_url) }}" placeholder="https://jrsinternationalschool.com/school-prospectus.pdf" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    <p class="text-[11px] text-slate-400">Enter a direct web link or external document URL.</p>
                </div>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.top-bar.index') }}" class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-jrs-red hover:opacity-95 text-white transition-all shadow-xs flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Save Top Bar Settings</span>
            </button>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function setupRadioToggle(radioName, optFileId, optUrlId, containerFileId, containerUrlId) {
        const radios = document.querySelectorAll(`input[name="${radioName}"]`);
        const optFile = document.getElementById(optFileId);
        const optUrl = document.getElementById(optUrlId);
        const contFile = document.getElementById(containerFileId);
        const contUrl = document.getElementById(containerUrlId);

        const activeClasses = ['border-jrs-navy', 'bg-jrs-navy/5', 'text-jrs-navy', 'shadow-xs', 'ring-1', 'ring-jrs-navy/20'];
        const inactiveClasses = ['border-slate-200', 'bg-white', 'text-slate-600'];

        function refresh() {
            const selected = document.querySelector(`input[name="${radioName}"]:checked`)?.value;
            if (selected === 'file') {
                contFile.classList.remove('hidden');
                contUrl.classList.add('hidden');

                optFile.classList.add(...activeClasses);
                optFile.classList.remove(...inactiveClasses);

                optUrl.classList.remove(...activeClasses);
                optUrl.classList.add(...inactiveClasses);
            } else {
                contFile.classList.add('hidden');
                contUrl.classList.remove('hidden');

                optUrl.classList.add(...activeClasses);
                optUrl.classList.remove(...inactiveClasses);

                optFile.classList.remove(...activeClasses);
                optFile.classList.add(...inactiveClasses);
            }
        }

        radios.forEach(radio => radio.addEventListener('change', refresh));
    }

    setupRadioToggle('prospectus_type', 'opt_prosp_file', 'opt_prosp_url', 'container_prosp_file', 'container_prosp_url');
});
</script>
@endsection
