@extends('admin.layout')

@section('title', 'Career Opportunities & How To Apply - Careers Page')
@section('header', 'How To Apply & Career Opportunities')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Status Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 rounded-2xl border border-slate-200 bg-white shadow-xs">
        <div class="space-y-1">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-jrs-navy text-white flex items-center justify-center font-bold text-sm shadow-2xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-jrs-navy font-heading">
                        Career Opportunities & How To Apply
                    </h2>
                    <p class="text-xs text-slate-500">
                        Interactive editor for the opportunities headline and the application instructions card.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Active Status Toggle Form -->
            <form action="{{ route('admin.careers-opportunities.toggle', $activeSection->id) }}" method="POST" class="inline-flex items-center">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold transition-all border {{ $activeSection->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-300 hover:bg-slate-200' }}"
                        title="Click to toggle live status">
                    <span class="w-2 h-2 rounded-full {{ $activeSection->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                    <span>{{ $activeSection->is_active ? 'Live on Site' : 'Offline / Hidden' }}</span>
                </button>
            </form>

            <!-- Save Primary Button Trigger -->
            <button type="button" 
                    onclick="document.getElementById('opportunityEditorForm').submit()" 
                    class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span>Save Changes</span>
            </button>
        </div>
    </div>

    <!-- Main Card-Based Editor Form -->
    <form id="opportunityEditorForm" action="{{ route('admin.careers-opportunities.update', $activeSection->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="is_active" value="{{ $activeSection->is_active ? '1' : '0' }}">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- Card 1: Opportunities Pitch (Left Side) - Span 6 -->
            <div class="lg:col-span-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-red-50 text-jrs-red flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-jrs-navy font-heading">Opportunities Pitch</h3>
                            <p class="text-[11px] text-slate-500">Headline and mission pitch copy</p>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded bg-slate-100 text-slate-600">Left Column</span>
                </div>

                <!-- Heading -->
                <div class="space-y-1.5">
                    <label for="title" class="text-xs font-semibold text-slate-700 flex items-center justify-between">
                        <span>Heading <span class="text-jrs-red">*</span></span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $activeSection->title) }}"
                           required
                           placeholder="e.g. Who Are Passionate About Their Field – A Great Future Awaits You At JRS"
                           class="w-full px-3.5 py-2.5 text-sm font-bold text-jrs-navy rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                    @error('title')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Paragraph -->
                <div class="space-y-1.5">
                    <label for="description" class="text-xs font-semibold text-slate-700 flex items-center justify-between">
                        <span>Paragraph <span class="text-jrs-red">*</span></span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="6"
                              required
                              placeholder="Describe the candidate mindset and core pedagogical vision..."
                              class="w-full p-3.5 text-xs text-slate-700 leading-relaxed rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">{{ old('description', $activeSection->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Card 2: How To Apply Card (Right Side) - Span 6 -->
            <div class="lg:col-span-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-jrs-navy font-heading">Application Process Card</h3>
                            <p class="text-[11px] text-slate-500">Right-side submission guide & checklist</p>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded bg-blue-50 text-blue-700 border border-blue-200">Right Card</span>
                </div>

                <!-- Heading -->
                <div class="space-y-1.5">
                    <label for="card_title" class="text-xs font-semibold text-slate-700">Heading <span class="text-jrs-red">*</span></label>
                    <input type="text" 
                           id="card_title" 
                           name="card_title" 
                           value="{{ old('card_title', $activeSection->card_title) }}"
                           required
                           placeholder="e.g. How To Apply"
                           class="w-full px-3 py-2 text-xs font-bold text-jrs-navy rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                    @error('card_title')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Paragraph -->
                <div class="space-y-1.5">
                    <label for="card_description" class="text-xs font-semibold text-slate-700">Paragraph</label>
                    <textarea id="card_description" 
                              name="card_description" 
                              rows="3"
                              placeholder="e.g. If you are looking for an opportunity to work at JRS International School, please send your resume to:"
                              class="w-full px-3 py-2 text-xs text-slate-700 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">{{ old('card_description', $activeSection->card_description) }}</textarea>
                    @error('card_description')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mail -->
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-700 flex items-center justify-between">
                        <span>Mail <span class="text-jrs-red">*</span></span>
                        <span class="text-[10px] text-blue-600 font-semibold">Clickable mailto link</span>
                    </label>
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $activeSection->email) }}"
                               required
                               placeholder="hrjrshyd@gmail.com"
                               class="w-full pl-9 pr-3 py-2 text-xs font-mono font-semibold text-blue-900 rounded-lg border border-blue-200 bg-blue-50/40 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divider -->
                <div class="border-t border-slate-100 pt-3">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold text-slate-800">
                            Tick Points
                        </label>
                        <button type="button" 
                                onclick="addChecklistItem()" 
                                class="inline-flex items-center gap-1 text-[11px] font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            <span>Add Tick Point</span>
                        </button>
                    </div>

                    <!-- Interactive Dynamic Checklist Rows -->
                    <div id="checklistContainer" class="space-y-2">
                        @php
                            $items = is_array($activeSection->checklist_items) ? $activeSection->checklist_items : [];
                        @endphp
                        @foreach($items as $index => $item)
                            <div class="checklist-row flex items-start gap-2 group p-2 rounded-lg bg-slate-50/70 border border-slate-200/80 transition-colors hover:bg-slate-50">
                                <div class="w-5 h-5 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <textarea name="checklist_items[]" 
                                          rows="2" 
                                          required 
                                          placeholder="Enter submission requirement..."
                                          class="w-full text-xs text-slate-700 bg-transparent border-0 p-0 focus:ring-0 resize-none leading-relaxed">{{ $item }}</textarea>
                                <button type="button" 
                                        onclick="removeChecklistItem(this)" 
                                        title="Remove item"
                                        class="p-1 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded transition-colors opacity-70 group-hover:opacity-100 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

        <!-- Sticky Save Footer -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-end">
            <button type="submit" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-5 py-2 gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span>Save All Changes</span>
            </button>
        </div>

    </form>

</div>

<script>
    function addChecklistItem() {
        const container = document.getElementById('checklistContainer');
        const row = document.createElement('div');
        row.className = 'checklist-row flex items-start gap-2 group p-2 rounded-lg bg-slate-50/70 border border-slate-200/80 transition-colors hover:bg-slate-50 animate-fadeIn';
        row.innerHTML = `
            <div class="w-5 h-5 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <textarea name="checklist_items[]" 
                      rows="2" 
                      required 
                      placeholder="Enter submission requirement..."
                      class="w-full text-xs text-slate-700 bg-transparent border-0 p-0 focus:ring-0 resize-none leading-relaxed"></textarea>
            <button type="button" 
                    onclick="removeChecklistItem(this)" 
                    title="Remove item"
                    class="p-1 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded transition-colors opacity-70 group-hover:opacity-100 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        `;
        container.appendChild(row);
        row.querySelector('textarea').focus();
    }

    function removeChecklistItem(btn) {
        const row = btn.closest('.checklist-row');
        const allRows = document.querySelectorAll('.checklist-row');
        if (allRows.length <= 1) {
            alert('At least one requirement item should remain.');
            return;
        }
        row.remove();
    }
</script>
@endsection
