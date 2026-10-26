@extends('admin.layout')

@section('title', 'Edit Committee Member')
@section('header', 'Edit Committee Member')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Back Navigation -->
    <div>
        <a href="{{ route('admin.educational-society.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Back to Managing Committee</span>
        </a>
    </div>

    <!-- Edit Member Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Educational Society</span>
                <h3 class="font-bold text-jrs-navy font-heading text-base">Edit: {{ $member->name }}</h3>
            </div>
            <span class="text-xs text-slate-400">ID: #{{ $member->id }}</span>
        </div>

        <form action="{{ route('admin.educational-society.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Photo Upload Box -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Member Photo</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 p-4 rounded-xl border border-slate-200 bg-slate-50/60">
                    <!-- Preview Circle -->
                    <div class="w-20 h-20 rounded-full bg-slate-200 border-2 border-white shadow-sm overflow-hidden flex items-center justify-center shrink-0 relative">
                        <img id="imagePreview" 
                             src="{{ $member->image_full_url ?? '' }}" 
                             alt="Preview" 
                             class="w-full h-full object-cover {{ $member->image_full_url ? '' : 'hidden' }}">
                        <div id="noImagePlaceholder" class="flex items-center justify-center text-slate-400 {{ $member->image_full_url ? 'hidden' : '' }}">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Upload Controls -->
                    <div class="space-y-2 flex-1">
                        <div>
                            <label for="image" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 cursor-pointer transition-colors shadow-2xs">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>Change Photo</span>
                            </label>
                            <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="previewSelectedImage(event)">
                        </div>

                        @if($member->image_path)
                            <div class="flex items-center gap-2 pt-1">
                                <input type="checkbox" name="remove_image" id="remove_image" value="1" class="w-4 h-4 text-jrs-red rounded border-slate-300 focus:ring-jrs-red">
                                <label for="remove_image" class="text-xs text-red-600 font-medium cursor-pointer">Remove uploaded photo (use default placeholder)</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Name & Designation -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Member Name *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $member->name) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. Mr. C. R. Jagadish">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="designation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Designation / Role *</label>
                    <input type="text" name="designation" id="designation" required value="{{ old('designation', $member->designation) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. PRESIDENT, SECRETARY, MEMBER">
                    @error('designation')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address & Phone -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Address / Locality</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $member->address) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. Karthikeya Nagar, Nacharam, Hyderabad">
                    @error('address')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $member->phone) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. 9542664980">
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
                    <span>Update Member</span>
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
