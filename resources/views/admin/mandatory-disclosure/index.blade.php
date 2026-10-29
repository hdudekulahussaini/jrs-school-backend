@extends('admin.layout')

@section('title', 'Mandatory Disclosure | JRS School Admin')
@section('header', 'Mandatory Disclosure (About Page)')

@section('content')
<div class="space-y-6">

    <!-- Top Bar: Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 font-heading">
                @if($activeTab === 'general_info')
                    Table 1: General Information
                @elseif($activeTab === 'document')
                    Table 2: Documents &amp; Information
                @elseif($activeTab === 'infrastructure')
                    Table 3: School Infrastructure
                @elseif($activeTab === 'smc')
                    Table 4: School Management Committee (SMC)
                @endif
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                @if($activeTab === 'general_info')
                    School affiliation, registration code, contacts, and campus principal details.
                @elseif($activeTab === 'document')
                    CBSE statutory certificates, NOC, building/fire safety, and regulatory PDFs.
                @elseif($activeTab === 'infrastructure')
                    School campus area, classrooms, science/computer labs, and inspection video tour.
                @elseif($activeTab === 'smc')
                    School Management Committee and Parents Teachers Association documents.
                @endif
            </p>
        </div>

        <!-- Add Actions -->
        <div class="flex flex-wrap items-center gap-2.5">
            @if($activeTab === 'general_info')
                <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'table', 'table' => 'general_info', 'category' => 'general_info']) }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-navy hover:bg-slate-800 text-white shadow-xs h-9 px-4 gap-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Add General Info Item</span>
                </a>
            @elseif($activeTab === 'document')
                <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'feature', 'table' => 'document', 'category' => 'document']) }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-navy hover:bg-slate-800 text-white shadow-xs h-9 px-4 gap-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Add Certificate / Document</span>
                </a>
            @elseif($activeTab === 'infrastructure')
                <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'table', 'table' => 'infrastructure', 'category' => 'infrastructure']) }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-navy hover:bg-slate-800 text-white shadow-xs h-9 px-4 gap-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Add Infrastructure Item</span>
                </a>
            @elseif($activeTab === 'smc')
                <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'feature', 'table' => 'smc', 'category' => 'smc']) }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-navy hover:bg-slate-800 text-white shadow-xs h-9 px-4 gap-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Add SMC Item</span>
                </a>
            @endif
        </div>
    </div>

    <!-- 4 Separate Tables Navigation Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3">
        <a href="{{ route('admin.mandatory-disclosure.index', ['table' => 'general_info']) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all {{ ($activeTab === 'general_info') ? 'bg-jrs-navy text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            <span>1. General Information</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($activeTab === 'general_info') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $generalCount }}</span>
        </a>

        <a href="{{ route('admin.mandatory-disclosure.index', ['table' => 'document']) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all {{ ($activeTab === 'document') ? 'bg-jrs-navy text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            <span>2. Documents &amp; Info</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($activeTab === 'document') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $documentCount }}</span>
        </a>

        <a href="{{ route('admin.mandatory-disclosure.index', ['table' => 'infrastructure']) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all {{ ($activeTab === 'infrastructure') ? 'bg-jrs-navy text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span>3. Infrastructure</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($activeTab === 'infrastructure') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $infrastructureCount }}</span>
        </a>

        <a href="{{ route('admin.mandatory-disclosure.index', ['table' => 'smc']) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all {{ ($activeTab === 'smc') ? 'bg-jrs-navy text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
            <span>4. SMC Committee</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ ($activeTab === 'smc') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $smcCount }}</span>
        </a>
    </div>

    <!-- Section 1: General Information Table -->
    @if($activeTab === 'general_info')
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-6 rounded-full bg-blue-500"></span>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 font-heading">General Information</h3>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $generalCount }} items</span>
            </div>
            <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'table', 'table' => 'general_info', 'category' => 'general_info']) }}" class="text-xs font-semibold text-jrs-navy hover:text-jrs-red transition-colors flex items-center gap-1">
                <span>+ Add Table Item</span>
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
                                <td colspan="4" class="p-8 text-center">
                                    <h4 class="text-xs sm:text-sm font-semibold text-slate-700">No General Information added yet</h4>
                                    <p class="text-xs text-slate-400 mt-1">Add school details (Name, Affiliation No, School Code, Email, Contacts).</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'table', 'table' => 'general_info', 'category' => 'general_info']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-jrs-navy text-white hover:opacity-95 shadow-xs">
                                            <span>+ Add Table Item</span>
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
    @endif

    <!-- Section 2: Documents And Information Table -->
    @if($activeTab === 'document')
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-6 rounded-full bg-amber-500"></span>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 font-heading">Documents And Information</h3>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $documentCount }} documents</span>
            </div>
            <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'feature', 'table' => 'document', 'category' => 'document']) }}" class="text-xs font-semibold text-jrs-navy hover:text-jrs-red transition-colors flex items-center gap-1">
                <span>+ Add Feature / Document</span>
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-semibold text-xs">
                            <th class="h-10 px-4 w-20 text-center">S. NO.</th>
                            <th class="h-10 px-4">DOCUMENTS / INFORMATION</th>
                            <th class="h-10 px-4 w-64">UPLOAD DOCUMENTS</th>
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
                                    @if($doc->file_path || $doc->download_link)
                                        <a href="{{ $doc->download_link }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/60 hover:bg-rose-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            <span>View PDF</span>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.mandatory-disclosure.edit', $doc->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                            <span>+ Upload PDF</span>
                                        </a>
                                    @endif
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.mandatory-disclosure.edit', $doc->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button type="button" onclick="confirmDelete('{{ $doc->id }}', '{{ addslashes($doc->title) }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center">
                                    <h4 class="text-xs sm:text-sm font-semibold text-slate-700">No Documents or Certificates added yet</h4>
                                    <p class="text-xs text-slate-400 mt-1">Upload Affiliation letter, Society Registration, NOC, Safety Certificates, etc.</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'feature', 'table' => 'document', 'category' => 'document']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-jrs-navy text-white hover:opacity-95 shadow-xs">
                                            <span>+ Add Feature / Document</span>
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
    @endif

    <!-- Section 3: School Infrastructure Table -->
    @if($activeTab === 'infrastructure')
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-6 rounded-full bg-emerald-500"></span>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 font-heading">School Infrastructure</h3>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $infrastructureCount }} records</span>
            </div>
            <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'table', 'table' => 'infrastructure', 'category' => 'infrastructure']) }}" class="text-xs font-semibold text-jrs-navy hover:text-jrs-red transition-colors flex items-center gap-1">
                <span>+ Add Table Item</span>
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-semibold text-xs">
                            <th class="h-10 px-4 w-20 text-center">S.NO.</th>
                            <th class="h-10 px-4 w-1/3">INFORMATION</th>
                            <th class="h-10 px-4">DETAILS</th>
                            <th class="h-10 px-4 w-28 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($infrastructures as $infra)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="p-4 text-center font-mono text-xs font-semibold text-slate-500">
                                    {{ $infra->s_no ?: ($loop->index + 1) }}
                                </td>
                                <td class="p-4 font-semibold text-slate-900 text-xs sm:text-sm">
                                    {{ $infra->title }}
                                </td>
                                <td class="p-4 text-xs sm:text-sm text-slate-700">
                                    <div class="flex flex-wrap items-center justify-between gap-3">
                                        @if($infra->value)
                                            <span class="font-medium text-slate-800">{{ $infra->value }}</span>
                                        @endif

                                        @if($infra->download_link || $infra->button_label)
                                            @php
                                                $isVideo = Str::contains(strtolower($infra->button_label . ' ' . $infra->title . ' ' . $infra->file_url), ['video', 'youtube', 'youtu.be']);
                                            @endphp
                                            @if($isVideo)
                                                <a href="{{ $infra->download_link ?: '#' }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-200/80 hover:bg-rose-100 transition-colors shrink-0">
                                                    <svg class="w-3.5 h-3.5 text-rose-600 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                    <span>{{ $infra->button_label ?: 'Watch Video' }}</span>
                                                </a>
                                            @else
                                                <a href="{{ $infra->download_link ?: '#' }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-jrs-navy border border-blue-200/60 hover:bg-blue-100 transition-colors shrink-0">
                                                    <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    <span>{{ $infra->button_label ?: 'Land Certificate' }}</span>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.mandatory-disclosure.edit', $infra->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button type="button" onclick="confirmDelete('{{ $infra->id }}', '{{ addslashes($infra->title) }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center">
                                    <h4 class="text-xs sm:text-sm font-semibold text-slate-700">No School Infrastructure details added yet</h4>
                                    <p class="text-xs text-slate-400 mt-1">Add campus area, number of classrooms, laboratories, toilets, and YouTube inspection video link.</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'table', 'table' => 'infrastructure', 'category' => 'infrastructure']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-jrs-navy text-white hover:opacity-95 shadow-xs">
                                            <span>+ Add Table Item</span>
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
    @endif

    <!-- Section 4: School Management Committee Table -->
    @if($activeTab === 'smc')
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-1.5 h-6 rounded-full bg-purple-500"></span>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 font-heading">School Management Committee</h3>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">{{ $smcCount }} records</span>
            </div>
            <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'feature', 'table' => 'smc', 'category' => 'smc']) }}" class="text-xs font-semibold text-jrs-navy hover:text-jrs-red transition-colors flex items-center gap-1">
                <span>+ Add Feature / Document</span>
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-semibold text-xs">
                            <th class="h-10 px-4 w-20 text-center">S.NO.</th>
                            <th class="h-10 px-4">DOCUMENTS / INFORMATION</th>
                            <th class="h-10 px-4 w-64">UPLOAD DOCUMENTS</th>
                            <th class="h-10 px-4 w-24 text-center">Status</th>
                            <th class="h-10 px-4 w-28 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($smcItems as $smc)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="p-4 text-center font-mono text-xs font-semibold text-slate-500">
                                    {{ $smc->s_no ?: ($loop->index + 1) }}
                                </td>
                                <td class="p-4 font-semibold text-slate-900 text-xs sm:text-sm">
                                    {{ $smc->title }}
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    @if($smc->download_link || $smc->button_label)
                                        <a href="{{ $smc->download_link ?: '#' }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-jrs-navy border border-blue-200/60 hover:bg-blue-100 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            <span>{{ $smc->button_label ?: 'View SMC Details' }}</span>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">No file attached</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <form action="{{ route('admin.mandatory-disclosure.toggle', $smc->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all {{ $smc->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $smc->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            <span>{{ $smc->is_active ? 'Active' : 'Draft' }}</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.mandatory-disclosure.edit', $smc->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button type="button" onclick="confirmDelete('{{ $smc->id }}', '{{ addslashes($smc->title) }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center">
                                    <h4 class="text-xs sm:text-sm font-semibold text-slate-700">No School Management Committee details added yet</h4>
                                    <p class="text-xs text-slate-400 mt-1">Add School Management Committee document or link for the public disclosure page.</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.mandatory-disclosure.create', ['type' => 'feature', 'table' => 'smc', 'category' => 'smc']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-jrs-navy text-white hover:opacity-95 shadow-xs">
                                            <span>+ Add Feature / Document</span>
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
    @endif

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
                Are you sure you want to delete <span id="deleteItemTitle" class="font-semibold text-slate-700"></span>? Any attached file will also be permanently deleted.
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
