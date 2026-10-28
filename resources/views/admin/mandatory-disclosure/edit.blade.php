@extends('admin.layout')

@section('title', 'Edit Mandatory Disclosure Entry | JRS School Admin')
@section('header', 'Edit Mandatory Disclosure Entry')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.mandatory-disclosure.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
                    &larr; Back to Mandatory Disclosure
                </a>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 mt-1 font-heading">Edit Mandatory Disclosure Entry</h2>
            <p class="text-sm text-slate-500">Update general information or replace certificate document.</p>
        </div>
        <form action="{{ route('admin.mandatory-disclosure.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this entry?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                <span>Delete</span>
            </button>
        </form>
    </div>


    <form action="{{ route('admin.mandatory-disclosure.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-6 sm:p-8 bg-white border border-slate-200 rounded-2xl shadow-xs space-y-6">

            <!-- Category Selection -->
            <div class="space-y-1.5">
                <label for="category" class="block text-xs font-semibold text-slate-700">
                    Entry Category <span class="text-rose-500">*</span>
                </label>
                <select id="category" name="category" onchange="toggleCategoryFields(this.value)" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy font-semibold text-slate-800">
                    <option value="general_info" {{ old('category', $item->category) === 'general_info' ? 'selected' : '' }}>General Information (Table 1: Name, Affiliation, Code, Email, Contacts)</option>
                    <option value="document" {{ old('category', $item->category) === 'document' ? 'selected' : '' }}>Documents And Information (Table 2: Statutory Certificates &amp; PDFs)</option>
                    <option value="infrastructure" {{ old('category', $item->category) === 'infrastructure' ? 'selected' : '' }}>School Infrastructure (Table 3: Campus Area, Rooms, Labs, Video Link)</option>
                    <option value="smc" {{ old('category', $item->category) === 'smc' ? 'selected' : '' }}>School Management Committee (Table 4: SMC Details &amp; Documents)</option>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="space-y-1.5">
                    <label for="s_no" class="block text-xs font-semibold text-slate-700">S. NO.</label>
                    <input type="text" id="s_no" name="s_no" value="{{ old('s_no', $item->s_no) }}" placeholder="e.g. 1" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                </div>

                <div class="sm:col-span-3 space-y-1.5">
                    <label for="title" class="block text-xs font-semibold text-slate-700">
                        <span id="titleLabel">Information Title</span> <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $item->title) }}" required placeholder="e.g. Name of the School or Total Campus Area" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                </div>
            </div>

            <!-- General Info / Details Field -->
            <div id="generalInfoFields" class="space-y-1.5">
                <label for="value" class="block text-xs font-semibold text-slate-700">
                    <span id="valueLabel">Details / Value</span> <span id="valueRequiredStar" class="text-rose-500">*</span>
                </label>
                <textarea id="value" name="value" rows="3" placeholder="e.g. JRS INTERNATIONAL SCHOOL or 12,477 Sq. Mtr. (3.08 Acres) or 22 Classrooms (48 Sq. Mtr. each)" class="w-full p-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">{{ old('value', $item->value) }}</textarea>
            </div>

            <!-- Document / Action Button Upload Fields -->
            <div id="documentFields" class="space-y-4">
                <div class="space-y-1.5">
                    <label for="button_label" class="block text-xs font-semibold text-slate-700">
                        <span id="buttonLabelText">Document Button Label</span>
                    </label>
                    <input type="text" id="button_label" name="button_label" value="{{ old('button_label', $item->button_label) }}" placeholder="e.g. Building Safety Certificate, Land Certificate, or Watch Video" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    <p class="text-[11px] text-slate-400">Label shown on the document/action button (e.g. "Land Certificate", "Watch Video", "View SMC Details").</p>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700">
                        Upload Certificate PDF / Document (Leave empty to keep current)
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="file" name="file_upload" accept=".pdf,.doc,.docx,.jpg,.png" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy/10 file:text-jrs-navy hover:file:bg-jrs-navy/20 cursor-pointer">
                        @if($item->file_path)
                            <a href="{{ asset(ltrim($item->file_path, '/')) }}" target="_blank" class="shrink-0 px-3 py-2 rounded-xl text-xs font-semibold bg-blue-50 text-jrs-navy border border-blue-200 hover:bg-blue-100 transition-colors flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Current File</span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="file_url" class="block text-xs font-semibold text-slate-700">
                        <span id="fileUrlLabel">External Document or Video URL (Optional)</span>
                    </label>
                    <input type="url" id="file_url" name="file_url" value="{{ old('file_url', $item->file_url) }}" placeholder="https://youtube.com/watch?v=... or https://..." class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    <p class="text-[11px] text-slate-400">For YouTube inspection video, enter YouTube URL here and set button label to "Watch Video".</p>
                </div>
            </div>

            <hr class="border-slate-100">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                <div class="space-y-1.5">
                    <label for="sort_order" class="block text-xs font-semibold text-slate-700">Display Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" min="0" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                </div>

                <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/50 flex items-start gap-3 mt-4 sm:mt-0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }} class="mt-0.5 w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500">
                    <div>
                        <label for="is_active" class="text-xs font-bold text-slate-800 cursor-pointer">Published / Active</label>
                        <p class="text-[11px] text-slate-400">Display this row on the public website table.</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.mandatory-disclosure.index') }}" class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-jrs-navy hover:opacity-95 text-white transition-all shadow-xs flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Save Changes</span>
            </button>
        </div>

    </form>
</div>

<script>
    function toggleCategoryFields(category) {
        const generalFields = document.getElementById('generalInfoFields');
        const documentFields = document.getElementById('documentFields');
        const titleLabel = document.getElementById('titleLabel');
        const titleInput = document.getElementById('title');
        const valueLabel = document.getElementById('valueLabel');
        const buttonLabelText = document.getElementById('buttonLabelText');
        const valueRequiredStar = document.getElementById('valueRequiredStar');

        if (category === 'general_info') {
            generalFields.classList.remove('hidden');
            documentFields.classList.add('hidden');
            titleLabel.textContent = 'Information';
            titleInput.placeholder = 'e.g. Name of the School or Affiliation No';
            valueLabel.textContent = 'Details / Value';
            valueRequiredStar.classList.remove('hidden');
        } else if (category === 'document') {
            generalFields.classList.add('hidden');
            documentFields.classList.remove('hidden');
            titleLabel.textContent = 'Documents / Information Name';
            titleInput.placeholder = 'e.g. Copies of Affiliation / Upgradation Letter';
            buttonLabelText.textContent = 'Upload Documents Button Label';
            valueRequiredStar.classList.add('hidden');
        } else if (category === 'infrastructure') {
            generalFields.classList.remove('hidden');
            documentFields.classList.remove('hidden');
            titleLabel.textContent = 'Infrastructure Information';
            titleInput.placeholder = 'e.g. Total Campus Area of the School, No. and Size of Classrooms, or Link of YouTube Video';
            valueLabel.textContent = 'Details (e.g. 12,477 Sq. Mtr., 22 Classrooms, Yes, 20)';
            buttonLabelText.textContent = 'Action Button Label (Optional, e.g. Land Certificate or Watch Video)';
            valueRequiredStar.classList.add('hidden');
        } else if (category === 'smc') {
            generalFields.classList.add('hidden');
            documentFields.classList.remove('hidden');
            titleLabel.textContent = 'Documents / Information Name';
            titleInput.placeholder = 'e.g. School Management Committee (SMC)';
            buttonLabelText.textContent = 'Action Button Label (e.g. View SMC Details)';
            valueRequiredStar.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleCategoryFields(document.getElementById('category').value);
    });
</script>
@endsection
