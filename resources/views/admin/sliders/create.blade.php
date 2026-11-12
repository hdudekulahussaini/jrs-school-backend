@extends('admin.layout')

@section('title', 'Create Hero Slider')
@section('header', 'Create Hero Slider')

@section('content')
<div class="space-y-6 w-full max-w-4xl mx-auto">

    <!-- Breadcrumb & Back Action -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.sliders.index') }}" class="hover:text-slate-900 transition-colors">Hero Sliders</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">Create</span>
        </div>
        <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors">
            &larr; Back to Hero Sliders
        </a>
    </div>

    <!-- Main Card Container -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
            <div>
                <h3 class="text-base font-bold text-slate-900">New Hero Slider Configuration</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Configure Action Buttons, Experience Badge, and Rotating Background Photographs.
                </p>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                New Configuration
            </span>
        </div>

        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/80 space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">Primary Button</span>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Text</label>
                        <input type="text" name="primary_button_text" value="{{ old('primary_button_text', 'Admissions 2027-28') }}" placeholder="e.g. Admissions 2027-28" class="w-full px-3 py-2 rounded-lg text-sm border border-slate-200 bg-white outline-none">
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/80 space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">Secondary Button</span>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Text</label>
                        <input type="text" name="secondary_button_text" value="{{ old('secondary_button_text', 'Take a Virtual Tour') }}" placeholder="e.g. Take a Virtual Tour" class="w-full px-3 py-2 rounded-lg text-sm border border-slate-200 bg-white outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Target URL</label>
                        <input type="text" name="secondary_button_url" value="{{ old('secondary_button_url', 'https://jrs-school.vercel.app/#tour') }}" placeholder="e.g. https://... or #tour" class="w-full px-3 py-2 rounded-lg text-sm border border-slate-200 bg-white outline-none">
                    </div>
                </div>
            </div>

            <!-- Experience Badge Image -->
            <div class="pt-2 border-t border-slate-100 space-y-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Experience Badge Image (Top-Right Circular Seal)
                </label>
                <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="w-16 h-16 rounded-full bg-slate-950 p-1.5 border border-amber-400 shrink-0 flex items-center justify-center shadow-xs">
                        <img id="badgePreview" src="{{ asset('images/experience-badge-38.svg') }}" alt="Badge Preview" class="w-full h-full object-contain">
                    </div>
                    <div class="flex-1 space-y-1">
                        <input type="file" name="experience_badge_image" id="badgeInput" accept="image/png,image/svg+xml,image/jpeg,image/webp" class="text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy file:text-white hover:file:bg-slate-800" onchange="previewBadge(this)">
                        <p class="text-[11px] text-slate-400">Upload custom seal (PNG, SVG, JPG up to 5MB) or leave empty for default 38 Years Experience seal.</p>
                    </div>
                </div>
            </div>

            <!-- Hero Background Images (Multiple) -->
            <div class="pt-2 border-t border-slate-100 space-y-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Hero Background Photographs (Multiple Image Slider)
                </label>
                <div class="border-2 border-dashed border-slate-300 hover:border-jrs-navy rounded-xl p-5 text-center bg-slate-50/60 cursor-pointer" onclick="document.getElementById('create_bg_input').click()">
                    <input type="file" name="background_images[]" id="create_bg_input" multiple accept="image/*" class="hidden" onchange="previewNewImages(this)">
                    <i class="bi bi-cloud-arrow-up-fill text-2xl text-slate-400 block mb-1"></i>
                    <p class="text-xs font-bold text-slate-700">Click to select multiple background photographs</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">JPG, PNG, WEBP up to 10MB each</p>
                </div>
                <div id="newImagesPreview" class="hidden grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2"></div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.sliders.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 border border-slate-200 bg-white hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-jrs-red hover:bg-red-700 text-white shadow-sm transition-colors">
                    Create Hero Slider
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function previewBadge(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('badgePreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewNewImages(input) {
    const container = document.getElementById('newImagesPreview');
    container.innerHTML = '';
    if (!input.files || input.files.length === 0) {
        container.classList.add('hidden');
        return;
    }
    container.classList.remove('hidden');

    Array.from(input.files).forEach((file, idx) => {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative aspect-video rounded-lg overflow-hidden border border-emerald-300 bg-slate-900 shadow-2xs';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover">
                <span class="absolute top-1 left-1 px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-600 text-white">#${idx + 1}</span>
            `;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
