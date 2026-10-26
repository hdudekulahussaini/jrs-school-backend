@extends('admin.layout')

@section('title', 'Mandatory Disclosure | JRS School Admin')
@section('header', 'Mandatory Disclosure (About Page)')

@section('content')
<div class="space-y-6">

    <!-- Top Breadcrumb & Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-heading">Mandatory Disclosure</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-jrs-navy/10 text-jrs-navy">
                    About JRS
                </span>
            </div>
            <p class="text-sm text-slate-500">
                Manage statutory compliance, CBSE general school information, and uploaded mandatory certificates for the public Mandatory Disclosure page.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.mandatory-disclosure.create', ['category' => 'general_info']) }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add General Info</span>
            </a>
            <a href="{{ route('admin.mandatory-disclosure.create', ['category' => 'document']) }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Add Certificate / Doc</span>
            </a>
        </div>
    </div>

    <!-- Stats Pill Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Records</p>
                <p class="text-2xl font-bold text-slate-900 mt-1 font-heading">{{ $totalCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">General Information</p>
                <p class="text-2xl font-bold text-jrs-navy mt-1 font-heading">{{ $generalCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-jrs-navy flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Documents &amp; Certificates</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1 font-heading">{{ $documentCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Section 1: General Information Table -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-jrs-red"></span>
                <h3 class="text-base font-bold text-slate-900 font-heading">General Information</h3>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $generalCount }} items</span>
            </div>
            <a href="{{ route('admin.mandatory-disclosure.create', ['category' => 'general_info']) }}" class="text-xs font-semibold text-jrs-navy hover:text-jrs-red transition-colors flex items-center gap-1">
                <span>+ Add Item</span>
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-semibold text-xs">
                            <th class="h-10 px-4 w-20 text-center">S. NO.</th>
                            <th class="h-10 px-4 w-1/3">INFORMATION</th>
                            <th class="h-10 px-4">DETAILS</th>
                            <th class="h-10 px-4 w-24 text-center">Status</th>
                            <th class="h-10 px-4 w-28 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($generalInfos as $info)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="p-4 text-center font-mono text-xs font-semibold text-slate-500">
                                    {{ $info->s_no ?: ($loop->index + 1) }}
                                </td>
                                <td class="p-4 font-semibold text-slate-900 text-xs sm:text-sm">
                                    {{ $info->title }}
                                </td>
                                <td class="p-4 text-xs sm:text-sm text-slate-600">
                                    {{ $info->value }}
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <form action="{{ route('admin.mandatory-disclosure.toggle', $info->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all {{ $info->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $info->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            <span>{{ $info->is_active ? 'Active' : 'Draft' }}</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.mandatory-disclosure.edit', $info->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button type="button" onclick="confirmDelete('{{ $info->id }}', '{{ addslashes($info->title) }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <h4 class="text-sm font-semibold text-slate-800">No General Information added yet</h4>
                                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Add school registration details such as Name, Affiliation No, School Code, Email, and Landline contact numbers.</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.mandatory-disclosure.create', ['category' => 'general_info']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-jrs-navy text-white hover:opacity-95 shadow-xs">
                                            <span>+ Add General Info</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section 2: Documents And Information Table -->
    <div class="space-y-3 pt-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-jrs-navy"></span>
                <h3 class="text-base font-bold text-slate-900 font-heading">Documents And Information</h3>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $documentCount }} documents</span>
            </div>
            <a href="{{ route('admin.mandatory-disclosure.create', ['category' => 'document']) }}" class="text-xs font-semibold text-jrs-navy hover:text-jrs-red transition-colors flex items-center gap-1">
                <span>+ Add Document</span>
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-semibold text-xs">
                            <th class="h-10 px-4 w-20 text-center">S. NO.</th>
                            <th class="h-10 px-4">DOCUMENTS / INFORMATION</th>
                            <th class="h-10 px-4 w-60">UPLOAD DOCUMENTS</th>
                            <th class="h-10 px-4 w-24 text-center">Status</th>
                            <th class="h-10 px-4 w-28 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($documents as $doc)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="p-4 text-center font-mono text-xs font-semibold text-slate-500">
                                    {{ $doc->s_no ?: ($loop->index + 1) }}
                                </td>
                                <td class="p-4 font-semibold text-slate-900 text-xs sm:text-sm">
                                    {{ $doc->title }}
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    @if($doc->download_link)
                                        <a href="{{ $doc->download_link }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-jrs-navy border border-blue-200/60 hover:bg-blue-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <span>{{ $doc->button_label ?: 'View Document' }}</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">No file uploaded</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <form action="{{ route('admin.mandatory-disclosure.toggle', $doc->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all {{ $doc->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $doc->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            <span>{{ $doc->is_active ? 'Active' : 'Draft' }}</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.mandatory-disclosure.edit', $doc->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 01-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button type="button" onclick="confirmDelete('{{ $doc->id }}', '{{ addslashes($doc->title) }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <h4 class="text-sm font-semibold text-slate-800">No Documents or Certificates uploaded yet</h4>
                                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Upload Affiliation letter, Society Registration, NOC, Building Safety, Fire Safety, and Land Certificates.</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.mandatory-disclosure.create', ['category' => 'document']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-jrs-red text-white hover:opacity-95 shadow-xs">
                                            <span>+ Add Certificate / Doc</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-xs" onclick="closeDeleteModal()"></div>
        <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900" id="modal-title">Delete Entry</h3>
            <p class="text-sm text-slate-500 mt-2">
                Are you sure you want to delete <span id="deleteItemTitle" class="font-semibold text-slate-700"></span>? Any attached PDF file will also be permanently deleted.
            </p>
            <form id="deleteForm" method="POST" action="" class="mt-6 flex items-center justify-end gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-rose-600 rounded-xl hover:bg-rose-700 transition-colors shadow-xs">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, title) {
        document.getElementById('deleteItemTitle').textContent = `"${title}"`;
        document.getElementById('deleteForm').action = `{{ url('admin/mandatory-disclosure') }}/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
