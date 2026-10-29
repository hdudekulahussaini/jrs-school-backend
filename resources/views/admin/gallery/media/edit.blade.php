@extends('admin.layout')

@section('title', 'Edit Press Article | JRS School Admin')
@section('header', 'Edit Press Article')

@section('content')
<div class="space-y-6 w-full">

    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.news-media.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
                    &larr; Back to News &amp; Media
                </a>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 mt-1 font-heading">Edit Press Article</h2>
            <p class="text-sm text-slate-500">Update newspaper clipping information and display options.</p>
        </div>
        <form action="{{ route('admin.news-media.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this press article?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                <span>Delete</span>
            </button>
        </form>
    </div>


    <form action="{{ route('admin.news-media.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-6 sm:p-8 bg-white border border-slate-200 rounded-2xl shadow-xs space-y-6">

            <!-- Section 1: Headline & Translation -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400">Article Headlines</h3>
                
                <div class="space-y-1.5">
                    <label for="title" class="block text-xs font-semibold text-slate-700">
                        Primary Headline (Telugu / Primary Language) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $item->title) }}" required placeholder="e.g. విద్యార్థుల నైపుణ్యతను గురించి ప్రోత్సహించాలి" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                </div>

                <div class="space-y-1.5">
                    <label for="english_title" class="block text-xs font-semibold text-slate-700">
                        English Translation / Subtitle
                    </label>
                    <input type="text" id="english_title" name="english_title" value="{{ old('english_title', $item->english_title) }}" placeholder="e.g. &quot;Identify and Encourage Students' Innate Talents&quot; — Actor &amp; Director Vishwak Sen at JRS Annual Day" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 2: Publication Source & Date -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400">Publication &amp; Origin</h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1.5">
                        <label for="newspaper_name" class="block text-xs font-semibold text-slate-700">
                            Newspaper / Publication <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="newspaper_name" name="newspaper_name" value="{{ old('newspaper_name', $item->newspaper_name) }}" required placeholder="e.g. మన తెలంగాణ (Mana Telangana)" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>

                    <div class="space-y-1.5">
                        <label for="location" class="block text-xs font-semibold text-slate-700">
                            Location / Edition
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location', $item->location) }}" placeholder="e.g. Ghatkesar or Hyderabad" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>

                    <div class="space-y-1.5">
                        <label for="published_date" class="block text-xs font-semibold text-slate-700">
                            Publication Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="published_date" name="published_date" value="{{ old('published_date', $item->published_date ? $item->published_date->format('Y-m-d') : '') }}" required class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="description" class="block text-xs font-semibold text-slate-700">
                        Body Snippet / News Highlights
                    </label>
                    <textarea id="description" name="description" rows="3" placeholder="Brief quote or summary of the news story..." class="w-full p-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">{{ old('description', $item->description) }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label for="external_link" class="block text-xs font-semibold text-slate-700">
                        External Digital Article Link (Optional)
                    </label>
                    <input type="url" id="external_link" name="external_link" value="{{ old('external_link', $item->external_link) }}" placeholder="https://..." class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 3: Newspaper Clipping Image Upload -->
            <div>
                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Newspaper Clipping Photo',
                    'current' => $item->image_url ?? null,
                    'aspect' => 'landscape',
                    'help' => 'Leave empty to keep existing photo. Accepted formats: JPG, PNG, WEBP. Max 5 MB.',
                ])
            </div>

            <hr class="border-slate-100">

            <!-- Section 4: Display Options & Placement -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400">Display Settings</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Featured Toggle -->
                    <div class="p-4 rounded-xl border border-amber-200 bg-amber-50/50 flex items-start gap-3">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }} class="mt-1 w-4 h-4 rounded text-amber-600 border-slate-300 focus:ring-amber-500">
                        <div>
                            <label for="is_featured" class="text-sm font-bold text-slate-800 cursor-pointer flex items-center gap-1.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500 text-white uppercase tracking-wider">Featured News</span>
                                Top Section Card
                            </label>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Highlight prominently inside the "Our Achievements In The News" top section with yellow badge.
                            </p>
                        </div>
                    </div>

                    <!-- Active Toggle -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex items-start gap-3">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }} class="mt-1 w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500">
                        <div>
                            <label for="is_active" class="text-sm font-bold text-slate-800 cursor-pointer">
                                Published / Active
                            </label>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Display this article on the public Gallery &gt; News &amp; Media webpage.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="w-full sm:w-48 space-y-1.5">
                    <label for="sort_order" class="block text-xs font-semibold text-slate-700">Display Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" min="0" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    <p class="text-[11px] text-slate-400">Lower numbers appear first.</p>
                </div>
            </div>

        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.news-media.index') }}" class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-jrs-navy hover:opacity-95 text-white transition-all shadow-xs flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Save Changes</span>
            </button>
        </div>

    </form>
</div>

<script>
    function previewSelectedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
