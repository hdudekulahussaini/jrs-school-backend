@extends('admin.layout')

@section('title', 'Edit Hero Slider')
@section('header', 'Edit Hero Slider')

@section('content')
<div class="space-y-6 w-full max-w-4xl mx-auto">

    <!-- Breadcrumb & Back Action -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.sliders.index') }}" class="hover:text-slate-900 transition-colors">Hero Sliders</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">Edit #{{ $slider->id }}</span>
        </div>
        <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors">
            &larr; Back to Hero Sliders
        </a>
    </div>

    <!-- Main Card Container -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
            <div>
                <h3 class="text-base font-bold text-slate-900">Edit Hero Slider #{{ $slider->id }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Update Action Buttons and Rotating Background Photographs.
                </p>
            </div>
        </div>

        <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/80 space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">Primary Button</span>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Text</label>
                        <input type="text" name="primary_button_text" value="{{ old('primary_button_text', $slider->primary_button_text) }}" placeholder="e.g. Admissions 2027-28" class="w-full px-3 py-2 rounded-lg text-sm border border-slate-200 bg-white outline-none">
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/80 space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">Secondary Button</span>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Text</label>
                        <input type="text" name="secondary_button_text" value="{{ old('secondary_button_text', $slider->secondary_button_text) }}" placeholder="e.g. Take a Virtual Tour" class="w-full px-3 py-2 rounded-lg text-sm border border-slate-200 bg-white outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Target URL</label>
                        <input type="text" name="secondary_button_url" value="{{ old('secondary_button_url', $slider->secondary_button_url) }}" placeholder="e.g. https://... or #tour" class="w-full px-3 py-2 rounded-lg text-sm border border-slate-200 bg-white outline-none">
                    </div>
                </div>
            </div>

            <!-- Hero Background Images (Multiple) -->
            <div class="pt-2 border-t border-slate-100 space-y-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Hero Background Photographs (Multiple Image Slider)
                </label>

                @php
                    $images = $slider->background_images ?? [];
                    if (empty($images) && !empty($slider->image_path)) {
                        $images = [$slider->image_path];
                    }
                @endphp

                @if(!empty($images))
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-3">
                        @foreach($images as $idx => $img)
                            @php
                                $imgUrl = str_starts_with($img, 'http') ? $img : url($img);
                            @endphp
                            <div id="img-card-{{ $idx }}" class="relative group rounded-xl overflow-hidden aspect-video bg-slate-950 border border-slate-200 shadow-2xs">
                                <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                                <input type="hidden" name="existing_images[]" value="{{ $img }}">
                                <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 rounded text-[9px] font-bold bg-black/70 text-white">#{{ $idx + 1 }}</span>
                                <button type="button" onclick="removePhotoCard({{ $idx }}, '{{ addslashes($img) }}')" class="absolute top-1.5 right-1.5 w-6 h-6 rounded-md bg-red-600/90 text-white flex items-center justify-center hover:bg-red-700 transition-colors shadow-xs" title="Remove photograph">
                                    <i class="bi bi-x-lg text-xs"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="border-2 border-dashed border-slate-300 hover:border-jrs-navy rounded-xl p-5 text-center bg-slate-50/60 cursor-pointer" onclick="document.getElementById('edit_bg_input').click()">
                    <input type="file" name="background_images[]" id="edit_bg_input" multiple accept="image/*" class="hidden" onchange="previewNewImages(this)">
                    <i class="bi bi-cloud-arrow-up-fill text-2xl text-slate-400 block mb-1"></i>
                    <p class="text-xs font-bold text-slate-700">Add more background photographs</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">JPG, PNG, WEBP up to 10MB each</p>
                </div>
                <div id="newImagesPreview" class="hidden grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2"></div>
            </div>

            <!-- Experience Seal / Badge Image (SVG / PNG) -->
            <div class="pt-2 border-t border-slate-100 space-y-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Experience Badge Image (Optional)
                </label>
                <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50/70 border border-slate-200/80">
                    <div id="badgePreviewContainer" class="w-16 h-16 rounded-xl border border-slate-200 bg-white flex items-center justify-center overflow-hidden shrink-0 shadow-2xs">
                        @if($slider->experience_badge_image)
                            <img id="badgePreviewImg" src="{{ str_starts_with($slider->experience_badge_image, 'http') ? $slider->experience_badge_image : asset($slider->experience_badge_image) }}" class="w-full h-full object-contain" alt="Badge">
                            <i id="badgePreviewIcon" class="bi bi-award text-2xl text-slate-400 hidden"></i>
                        @else
                            <img id="badgePreviewImg" src="" class="w-full h-full object-contain hidden" alt="Badge Preview">
                            <i id="badgePreviewIcon" class="bi bi-award text-2xl text-slate-400"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" name="experience_badge_image" id="experience_badge_image" accept="image/*,.svg"
                            class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 cursor-pointer"
                            onchange="previewBadge(this)">
                        <p class="text-[11px] text-slate-400 mt-1">Upload a new circular badge or seal graphic (SVG, PNG, JPG, WebP up to 5MB) to replace</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.sliders.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 border border-slate-200 bg-white hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-jrs-red hover:bg-red-700 text-white shadow-sm transition-colors">
                    Update Hero Slider
                </button>
            </div>
        </form>
    </div>

</div>

<script>
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
                <span class="absolute top-1 left-1 px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-600 text-white">New #${idx + 1}</span>
            `;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function removePhotoCard(idx, imgPath) {
    if (!confirm('Remove this photograph from the slider?')) {
        return;
    }

    const card = document.getElementById('img-card-' + idx);
    if (card) {
        card.remove();
    }

    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('slider_id', '{{ $slider->id }}');
    formData.append('image', imgPath);

    fetch('{{ url('admin/sliders/remove-image') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).catch(err => console.log('Remove image error:', err));
}

function previewBadge(input) {
    const previewImg = document.getElementById('badgePreviewImg');
    const previewIcon = document.getElementById('badgePreviewIcon');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            if (previewIcon) previewIcon.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
