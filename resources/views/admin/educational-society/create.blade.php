@extends('admin.layout')

@section('title', 'Add Committee Member')
@section('header', 'Add Committee Member')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Back Navigation -->
    <div>
        <a href="{{ route('admin.educational-society.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Back to Managing Committee</span>
        </a>
    </div>

    <!-- Create Member Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Educational Society</span>
                <h3 class="font-bold text-jrs-navy font-heading text-base">New Committee Member</h3>
            </div>
            <span class="text-xs text-slate-400">Governing Body</span>
        </div>

        <form action="{{ route('admin.educational-society.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Photo Upload Box -->
            <div>
                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Member Photo',
                    'aspect' => 'avatar',
                    'help' => 'Square or portrait headshot recommended (PNG, JPG, or WebP up to 2MB).',
                ])
            </div>

            <!-- Name & Designation -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Member Name *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. Mr. C. R. Jagadish">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="designation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Designation / Role *</label>
                    <input type="text" name="designation" id="designation" required value="{{ old('designation') }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. PRESIDENT, SECRETARY, MEMBER">
                    @error('designation')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address & Phone -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Address / Locality</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. Karthikeya Nagar, Nacharam, Hyderabad">
                    @error('address')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. 9542664980">
                    @error('phone')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.educational-society.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold border border-slate-300 text-slate-700 hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold bg-jrs-red hover:bg-red-700 text-white shadow-md shadow-red-600/20 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save Member</span>
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    function previewSelectedImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                const placeholder = document.getElementById('noImagePlaceholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
