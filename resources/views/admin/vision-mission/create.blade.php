@extends('admin.layout')

@section('title', 'Add Vision & Mission Card')
@section('header', 'Add Vision / Mission')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-800">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.vision-mission.index') }}" class="hover:text-slate-800">Vision & Mission</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">New Card</span>
        </div>
        <a href="{{ route('admin.vision-mission.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors inline-flex items-center gap-1.5 shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <h3 class="text-lg font-bold text-slate-900 font-heading mb-6 pb-4 border-b border-slate-100">
            Create Vision / Mission Card
        </h3>

        <form action="{{ route('admin.vision-mission.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Card Type & Eyebrow Badge -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Card Type <span class="text-red-500">*</span>
                    </label>
                    <select name="type" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red bg-white">
                        <option value="vision" {{ old('type') == 'vision' ? 'selected' : '' }}>Vision</option>
                        <option value="mission" {{ old('type') == 'mission' ? 'selected' : '' }}>Mission</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Badge / Eyebrow Text <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="eyebrow" value="{{ old('eyebrow', 'OUR VISION') }}" required placeholder="e.g. OUR VISION or OUR MISSION" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Card Icon
                    </label>
                    <select name="icon" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red bg-white">
                        <option value="eye" {{ old('icon') == 'eye' ? 'selected' : '' }}>Eye (Vision)</option>
                        <option value="rocket" {{ old('icon') == 'rocket' ? 'selected' : '' }}>Rocket (Mission)</option>
                        <option value="target" {{ old('icon') == 'target' ? 'selected' : '' }}>Target (Goal)</option>
                        <option value="star" {{ old('icon') == 'star' ? 'selected' : '' }}>Star (Excellence)</option>
                    </select>
                </div>
            </div>

            <!-- Title -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Heading Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. To Be A Foremost Learning Institution In Hyderabad." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Description Content <span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="4" required placeholder="Write the full description for this card..." class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red leading-relaxed">{{ old('description') }}</textarea>
            </div>

            <!-- Background Image File Upload -->
            <div>
                @include('admin.partials.image-upload', [
                    'name' => 'image_file',
                    'id' => 'image_file',
                    'label' => 'Card Background Image',
                    'aspect' => 'landscape',
                    'help' => 'Upload a background image file (JPG, PNG, WebP).',
                ])
            </div>

            <!-- Sort Order & Active -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Display Order
                    </label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                    <p class="text-[11px] text-slate-400 mt-1">Lower numbers display first (e.g. 1 for Vision, 2 for Mission).</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.vision-mission.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-jrs-red hover:bg-jrs-red-dark text-white shadow-md shadow-red-600/30 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save Card</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
