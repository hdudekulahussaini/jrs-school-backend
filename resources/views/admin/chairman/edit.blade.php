@extends('admin.layout')

@section('title', 'Edit Chairman of JRS')
@section('header', 'Edit Chairman Sections')

@section('content')
<div class="space-y-6 w-full">

    <!-- Back Navigation -->
    <div>
        <a href="{{ route('admin.chairman.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Back to Chairman Records</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <form action="{{ route('admin.chairman.update', $chairman->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- SECTION 1: Chairman's Address & Leadership Profile -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Section 1</span>
                    <h3 class="font-bold text-jrs-navy font-heading text-base">Chairman's Address & Profile Card</h3>
                </div>
                <span class="text-xs text-slate-400">Card & Address Layout</span>
            </div>

            <div class="p-6 space-y-6">
                <!-- Address Section Header -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="section_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Section Badge / Category</label>
                        <input type="text" name="section_badge" id="section_badge" value="{{ old('section_badge', $chairman->section_badge) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. CHAIRMAN'S ADDRESS">
                    </div>

                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Main Heading *</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $chairman->title) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. Empowering Young Minds For A Changing World">
                    </div>
                </div>

                <!-- Left Profile Card Settings -->
                <div class="p-4 rounded-xl border border-slate-200/80 bg-slate-50/70 space-y-4">
                    <h4 class="text-xs font-bold text-jrs-navy uppercase tracking-wider">Founding Leadership Profile Card (Left Column)</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="profile_badge" class="block text-xs font-semibold text-slate-600 mb-1">Badge</label>
                            <input type="text" name="profile_badge" id="profile_badge" value="{{ old('profile_badge', $chairman->profile_badge) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. FOUNDING LEADERSHIP">
                        </div>

                        <div>
                            <label for="name" class="block text-xs font-semibold text-slate-600 mb-1">Chairman Name / Title *</label>
                            <input type="text" name="name" id="name" required value="{{ old('name', $chairman->name) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. Chairman Of JRS">
                        </div>

                        <div>
                            <label for="sub_title" class="block text-xs font-semibold text-slate-600 mb-1">Institution / Subtitle</label>
                            <input type="text" name="sub_title" id="sub_title" value="{{ old('sub_title', $chairman->sub_title) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. JRS International School • Hyderabad">
                        </div>
                    </div>

                    <div>
                        <label for="quote" class="block text-xs font-semibold text-slate-600 mb-1">Chairman's Motto / Quote</label>
                        <input type="text" name="quote" id="quote" value="{{ old('quote', $chairman->quote) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. “Nurturing Tomorrow's Leaders with Global Competence & Indian Values”">
                    </div>

                    <!-- Photo Upload with Live Preview -->
                    <div>
                        @include('admin.partials.image-upload', [
                            'name' => 'image',
                            'id' => 'image',
                            'label' => 'Portrait Photo',
                            'current' => $chairman->image_full_url ?? null,
                            'currentPath' => $chairman->image_path ?? null,
                            'removeName' => 'remove_image',
                            'aspect' => 'portrait',
                            'help' => 'Supports JPG, PNG, WEBP, GIF (Max: 10MB). Best size: 400x500px portrait.',
                        ])
                    </div>
                </div>

                <!-- Message Paragraph -->
                <div class="space-y-2">
                    <label for="paragraph" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Address Message / Paragraph *</label>
                    <textarea name="paragraph" id="paragraph" rows="8" required class="w-full px-3.5 py-2.5 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors leading-relaxed" placeholder="Write or paste the Chairman's complete address here...">{{ old('paragraph', $chairman->paragraph) }}</textarea>
                    <span class="text-[11px] text-slate-400">You can format your text with blank lines/line breaks.</span>
                </div>

                <!-- Sign-off Details -->
                <div class="pt-2 border-t border-slate-100 max-w-xl space-y-3">
                    <h4 class="text-xs font-bold text-jrs-navy uppercase tracking-wider">Sign-off Details</h4>
                    <div>
                        <label for="signoff_note" class="block text-xs text-slate-600 mb-1">Salutation / Note</label>
                        <input type="text" name="signoff_note" id="signoff_note" value="{{ old('signoff_note', $chairman->signoff_note) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200" placeholder="e.g. WITH WARM WISHES & COMMITMENT,">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="signoff_name" class="block text-xs text-slate-600 mb-1">Name</label>
                            <input type="text" name="signoff_name" id="signoff_name" value="{{ old('signoff_name', $chairman->signoff_name) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200" placeholder="e.g. Chairman">
                        </div>
                        <div>
                            <label for="signoff_sub" class="block text-xs text-slate-600 mb-1">Institution</label>
                            <input type="text" name="signoff_sub" id="signoff_sub" value="{{ old('signoff_sub', $chairman->signoff_sub) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200" placeholder="e.g. JRS International School, Hyderabad">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- SECTION 2: Strategic Commitment Banner -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-blue-600 tracking-wider uppercase font-heading">Section 2</span>
                    <h3 class="font-bold text-jrs-navy font-heading text-base">Our Strategic Commitment Banner</h3>
                </div>
                <span class="text-xs text-slate-400">Navy Background CTA Block</span>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="commitment_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Commitment Badge</label>
                        <input type="text" name="commitment_badge" id="commitment_badge" value="{{ old('commitment_badge', $chairman->commitment_badge) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. OUR STRATEGIC COMMITMENT">
                    </div>

                    <div>
                        <label for="commitment_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Commitment Heading *</label>
                        <input type="text" name="commitment_title" id="commitment_title" required value="{{ old('commitment_title', $chairman->commitment_title) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. Building An Empowered Generation For Tomorrow">
                    </div>
                </div>

                <div>
                    <label for="commitment_description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Commitment Description</label>
                    <textarea name="commitment_description" id="commitment_description" rows="3" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors">{{ old('commitment_description', $chairman->commitment_description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Visibility & Form Submit Bar -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $chairman->is_active) ? 'checked' : '' }} class="w-4 h-4 text-jrs-red rounded border-slate-300 focus:ring-jrs-red">
                <div>
                    <span class="text-sm font-bold text-slate-900 block">Published / Active</span>
                    <span class="text-xs text-slate-400">When checked, this content is published to the React website API</span>
                </div>
            </label>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.chairman.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold border border-slate-300 text-slate-700 hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold bg-jrs-red hover:bg-red-700 text-white shadow-md shadow-red-600/30 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>
    </form>

</div>

<script>
function previewChairmanPhoto(event) {
    const input = event.target;
    const previewImg = document.getElementById('chairman-preview-img');
    const placeholder = document.getElementById('chairman-preview-placeholder');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            if (placeholder) {
                placeholder.classList.add('hidden');
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
