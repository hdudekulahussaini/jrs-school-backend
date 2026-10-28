@extends('admin.layout')

@section('title', 'Add Press Article | JRS School Admin')
@section('header', 'Add Press Article')

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
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 mt-1 font-heading">Add Press / Media Article</h2>
            <p class="text-sm text-slate-500">Publish a new newspaper clipping or campus press coverage feature.</p>
        </div>
    </div>


    <form action="{{ route('admin.news-media.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-6 sm:p-8 bg-white border border-slate-200 rounded-2xl shadow-xs space-y-6">

            <!-- Section 1: Headline & Translation -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400">Article Headlines</h3>
                
                <div class="space-y-1.5">
                    <label for="title" class="block text-xs font-semibold text-slate-700">
                        Primary Headline (Telugu / Primary Language) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. విద్యార్థుల నైపుణ్యతను గురించి ప్రోత్సహించాలి" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    <p class="text-[11px] text-slate-400">Headline as printed on the newspaper clipping.</p>
                </div>

                <div class="space-y-1.5">
                    <label for="english_title" class="block text-xs font-semibold text-slate-700">
                        English Translation / Subtitle
                    </label>
                    <input type="text" id="english_title" name="english_title" value="{{ old('english_title') }}" placeholder="e.g. &quot;Identify and Encourage Students' Innate Talents&quot; — Actor &amp; Director Vishwak Sen at JRS Annual Day" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    <p class="text-[11px] text-slate-400">English description displayed beneath the Telugu headline on featured cards.</p>
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
                        <input type="text" id="newspaper_name" name="newspaper_name" value="{{ old('newspaper_name') }}" required placeholder="e.g. మన తెలంగాణ (Mana Telangana)" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>

                    <div class="space-y-1.5">
                        <label for="location" class="block text-xs font-semibold text-slate-700">
                            Location / Edition
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="e.g. Ghatkesar or Hyderabad" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>

                    <div class="space-y-1.5">
                        <label for="published_date" class="block text-xs font-semibold text-slate-700">
                            Publication Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="published_date" name="published_date" value="{{ old('published_date', date('Y-m-d')) }}" required class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="description" class="block text-xs font-semibold text-slate-700">
                        Body Snippet / News Highlights
                    </label>
                    <textarea id="description" name="description" rows="3" placeholder="Brief quote or summary of the news story..." class="w-full p-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">{{ old('description') }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label for="external_link" class="block text-xs font-semibold text-slate-700">
                        External Digital Article Link (Optional)
                    </label>
                    <input type="url" id="external_link" name="external_link" value="{{ old('external_link') }}" placeholder="https://..." class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 3: Newspaper Clipping Image Upload -->
            <div>
                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Newspaper Clipping Photo',
                    'aspect' => 'landscape',
                    'required' => true,
                    'help' => 'Accepted formats: JPG, PNG, WEBP. Maximum file size: 5 MB.',
                ])
            </div>

            <hr class="border-slate-100">

            <!-- Section 4: Display Options & Placement -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400">Display Settings</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Featured Toggle -->
                    <div class="p-4 rounded-xl border border-amber-200 bg-amber-50/50 flex items-start gap-3">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="mt-1 w-4 h-4 rounded text-amber-600 border-slate-300 focus:ring-amber-500">
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
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mt-1 w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500">
                        <div>
                            <label for="is_active" class="text-sm font-bold text-slate-800 cursor-pointer">
                                Published / Active
                            </label>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Immediately display this article on the public Gallery &gt; News &amp; Media webpage.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="w-full sm:w-48 space-y-1.5">
                    <label for="sort_order" class="block text-xs font-semibold text-slate-700">Display Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $nextOrder) }}" min="0" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    <p class="text-[11px] text-slate-400">Lower numbers appear first.</p>
                </div>
            </div>

        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.news-media.index') }}" class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-jrs-red hover:opacity-95 text-white transition-all shadow-xs flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Publish Press Article</span>
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
                const placeholder = document.getElementById('imagePlaceholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
