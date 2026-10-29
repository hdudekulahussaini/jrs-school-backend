@extends('admin.layout')

@section('title', 'Add Opportunities & Application Section - Careers Page')
@section('header', 'Add Opportunities Section')

@section('content')
<div class="space-y-6 w-full">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.careers-opportunities.index') }}" class="text-xs text-slate-500 hover:text-jrs-navy font-medium flex items-center gap-1">
                    &larr; Back to Sections
                </a>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-jrs-navy font-heading">Add Career Opportunities & How To Apply Section</h2>
            <p class="text-xs text-slate-500">
                Configure the two-column section: Left pitch ("Who Are Passionate...") and Right card ("How To Apply").
            </p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.careers-opportunities.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Left Column: Opportunities Pitch -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-jrs-navy font-heading border-b border-slate-100 pb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-jrs-red"></span>
                    <span>Left Column: Career Opportunities</span>
                </h3>

                <!-- Heading -->
                <div class="space-y-1.5">
                    <label for="title" class="text-xs font-semibold text-slate-700">Heading <span class="text-jrs-red">*</span></label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', 'Who Are Passionate About Their Field – A Great Future Awaits You At JRS') }}" 
                           required
                           class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                    @error('title')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description / Paragraph -->
                <div class="space-y-1.5">
                    <label for="description" class="text-xs font-semibold text-slate-700">Paragraph <span class="text-jrs-red">*</span></label>
                    <textarea id="description" 
                              name="description" 
                              rows="6"
                              required
                              class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">{{ old('description', "At JRS we are looking for professionals who understand and believe in our philosophy. People who are genuinely interested in creating students who are world-ready, in sync with today's technology and backed by the Indian value system.") }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column: How To Apply Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-jrs-navy font-heading border-b border-slate-100 pb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>Right Card: How To Apply Card</span>
                </h3>

                <!-- Heading -->
                <div class="space-y-1.5">
                    <label for="card_title" class="text-xs font-semibold text-slate-700">Heading <span class="text-jrs-red">*</span></label>
                    <input type="text" 
                           id="card_title" 
                           name="card_title" 
                           value="{{ old('card_title', 'How To Apply') }}" 
                           required
                           class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>

                <!-- Paragraph -->
                <div class="space-y-1.5">
                    <label for="card_description" class="text-xs font-semibold text-slate-700">Paragraph</label>
                    <input type="text" 
                           id="card_description" 
                           name="card_description" 
                           value="{{ old('card_description', 'If you are looking for an opportunity to work at JRS International School, please send your resume to:') }}" 
                           class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>

                <!-- Mail -->
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-700">Mail <span class="text-jrs-red">*</span></label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', 'hrjrshyd@gmail.com') }}" 
                           required
                           class="w-full px-3 py-2 text-sm font-mono rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                    @error('email')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tick Points -->
                <div class="space-y-1.5">
                    <label for="checklist_text" class="text-xs font-semibold text-slate-700">
                        Tick Points (One item per line)
                    </label>
                    <textarea id="checklist_text" 
                              name="checklist_text" 
                              rows="4"
                              class="w-full px-3 py-2 text-xs font-sans rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">{{ old('checklist_text', implode("\n", $defaultChecklist)) }}</textarea>
                    <p class="text-[11px] text-slate-500">Each non-empty line renders with a blue checkmark icon.</p>
                </div>

            </div>

        </div>

        <!-- Active Status -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-sm font-bold text-jrs-navy">Active Status</div>
                <div class="text-xs text-slate-500">Activating this section will make it live on the Careers page.</div>
            </div>
            <label class="relative inline-flex items-center gap-2 cursor-pointer select-none">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                <span class="text-xs font-semibold text-slate-700">Live on Site</span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.careers-opportunities.index') }}" class="px-4 py-2 text-xs font-semibold rounded-md border border-slate-200 text-slate-700 hover:bg-slate-50">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2 text-xs font-semibold rounded-md bg-jrs-red text-white hover:opacity-90 shadow-xs">
                Save Section Copy
            </button>
        </div>
    </form>

</div>
@endsection
