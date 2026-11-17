@php
    $id = $id ?? $name;
    $label = $label ?? 'Image';
    $current = $current ?? null;
    $required = $required ?? false;
@endphp

<div class="space-y-2 admin-image-box">
    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
        {{ $label }} @if($required && !$current)<span class="text-red-500">*</span>@endif
    </label>

    <div class="flex flex-wrap items-center gap-4 p-3 rounded-xl border border-slate-200 bg-slate-50">
        <!-- Current Image (Edit forms) -->
        @if($current)
            <div class="space-y-1">
                <span class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Current</span>
                <div class="w-24 h-20 rounded-lg border border-slate-200 bg-white overflow-hidden shadow-xs">
                    <img src="{{ $current }}" alt="Current" class="w-full h-full object-cover">
                </div>
            </div>
        @endif

        <!-- New Image Preview -->
        <div class="space-y-1 new-preview-wrap {{ $current ? 'hidden' : '' }}">
            <span class="block text-[10px] font-bold text-emerald-600 uppercase tracking-wider">New</span>
            <div class="w-24 h-20 rounded-lg border border-slate-200 bg-white flex items-center justify-center overflow-hidden shadow-xs">
                <img src="" alt="New Preview" class="new-preview-img w-full h-full object-cover hidden">
                <span class="no-preview-text text-[10px] text-slate-400">No Image</span>
            </div>
        </div>

        <!-- File Input -->
        <div class="flex-1 min-w-[200px] space-y-1">
            <input type="file" 
                   name="{{ $name }}" 
                   id="{{ $id }}" 
                   accept="image/*" 
                   class="admin-file-input block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy file:text-white hover:file:opacity-90 cursor-pointer"
                   @if($required && !$current) required @endif>
            <p class="text-[11px] text-slate-400">{{ $current ? 'Select a file to replace current image' : 'PNG, JPG, WEBP, or SVG' }}</p>
            @error($name)
                <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

@once
<script>
document.addEventListener('change', function(e) {
    if (e.target.matches('.admin-file-input')) {
        const file = e.target.files && e.target.files[0];
        const box = e.target.closest('.admin-image-box');
        if (!box) return;

        const wrap = box.querySelector('.new-preview-wrap');
        const img = box.querySelector('.new-preview-img');
        const placeholder = box.querySelector('.no-preview-text');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                if (img) {
                    img.src = evt.target.result;
                    img.classList.remove('hidden');
                }
                if (placeholder) placeholder.classList.add('hidden');
                if (wrap) wrap.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>
@endonce
