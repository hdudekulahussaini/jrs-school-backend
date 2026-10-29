@extends('admin.layout')

@section('title', 'Admission Brochure | JRS School Admin')
@section('header', 'Admission Brochure')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500 font-semibold">Admissions</span>
                <span class="text-slate-300">/</span>
                <span class="text-xs text-slate-700 font-medium">Brochure</span>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 font-heading">Admission Brochure</h2>
        </div>
    </div>

    <!-- Management Form -->
    <form action="{{ route('admin.admission-brochure.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Container for removing PDF -->
        <input type="hidden" name="remove_pdf" id="removePdfInput" value="0">

        <!-- Brochure Card Box -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs space-y-6">

            <!-- Section Header -->
            <div class="space-y-1">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2.5 h-0.5 bg-rose-500 rounded-full inline-block"></span>
                    <span>ADMISSION BROCHURE</span>
                </h3>
                <p class="text-xs text-slate-500">
                    Upload the admission brochure PDF file or provide a direct brochure URL link.
                </p>
            </div>

            <!-- Option 1: PDF File Upload -->
            <div class="space-y-3 pt-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Brochure PDF File
                </label>

                @if($brochure->has_file)
                    <!-- Current PDF Display Card -->
                    <div id="currentPdfCard" class="flex items-center justify-between p-4 rounded-xl border border-slate-200 bg-slate-50/70">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-slate-800 truncate">
                                    {{ basename($brochure->pdf_path) }}
                                </p>
                                <p class="text-[11px] text-slate-500">
                                    Uploaded PDF @if($brochure->file_size) • {{ $brochure->file_size }} @endif
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ $brochure->pdf_full_url }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-medium shadow-2xs transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>View PDF</span>
                            </a>

                            <button type="button" onclick="removeCurrentPdf()" class="inline-flex items-center gap-1 rounded-lg bg-[#dc2626] hover:bg-red-700 text-white text-xs font-semibold px-2.5 py-1.5 shadow-2xs transition-all cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Remove</span>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Upload New PDF Area -->
                <div class="relative">
                    <label for="brochure_file" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-rose-400 rounded-xl cursor-pointer bg-slate-50/50 hover:bg-rose-50/20 transition-all text-center">
                        <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-slate-700">
                            <span class="text-rose-600">Click to upload</span> or drag and drop brochure PDF
                        </p>
                        <p class="text-[11px] text-slate-400 mt-0.5">
                            PDF format only (up to 30MB)
                        </p>
                        <p id="selectedFileName" class="hidden text-xs font-semibold text-emerald-600 mt-2 font-mono"></p>
                    </label>
                    <input type="file" id="brochure_file" name="brochure_file" accept="application/pdf" class="hidden">
                </div>
            </div>

            <!-- Divider -->
            <div class="relative flex items-center justify-center pt-2">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider absolute">OR LINK</span>
            </div>

            <!-- Option 2: Brochure URL Link -->
            <div class="space-y-1.5 pt-2">
                <label for="brochure_link" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Brochure URL Link
                </label>
                <div class="relative rounded-lg shadow-2xs">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <input type="url" 
                           id="brochure_link" 
                           name="brochure_link" 
                           value="{{ old('brochure_link', $brochure->brochure_link) }}" 
                           placeholder="https://example.com/school-brochure.pdf" 
                           class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                </div>
                <p class="text-[11px] text-slate-500">
                    If you host the brochure on Google Drive, Dropbox, or an external website, paste the direct link here.
                </p>
            </div>

        </div>

        <!-- Sticky Form Footer -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-end">
            <button type="submit" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-6 py-2 gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span>Save Brochure</span>
            </button>
        </div>

    </form>

</div>

<script>
    const fileInput = document.getElementById('brochure_file');
    const selectedFileName = document.getElementById('selectedFileName');
    const removePdfInput = document.getElementById('removePdfInput');
    const currentPdfCard = document.getElementById('currentPdfCard');

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            selectedFileName.textContent = 'Selected: ' + file.name + ' (' + (file.size / 1048576).toFixed(2) + ' MB)';
            selectedFileName.classList.remove('hidden');
        } else {
            selectedFileName.classList.add('hidden');
        }
    });

    function removeCurrentPdf() {
        if (confirm('Are you sure you want to remove the current brochure PDF?')) {
            removePdfInput.value = '1';
            if (currentPdfCard) {
                currentPdfCard.style.display = 'none';
            }
        }
    }
</script>
@endsection
