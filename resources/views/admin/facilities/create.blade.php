@extends('admin.layout')

@section('title', 'Add New Facility')
@section('header', 'Create Facility')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Breadcrumb (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.facilities.index') }}" class="hover:text-slate-900 transition-colors">Facilities</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">New Facility</span>
        </div>
        <a href="{{ route('admin.facilities.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors">
            &larr; Back to list
        </a>
    </div>

    <!-- Main Card Container (shadcn/ui Card) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-semibold leading-none tracking-tight text-slate-900 font-heading">New Facility Card</h3>
            <p class="text-sm text-slate-500 mt-1.5">
                Add an infrastructure card for the World-Class Facilities section with photo, wave theme, and icon.
            </p>
        </div>

        <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Section 1: Title & Description -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">1. Basic Information</h4>
                </div>

                <div class="space-y-2">
                    <label for="title" class="text-sm font-medium leading-none text-slate-700">Facility Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="e.g. Smart Classrooms, Science & Computer Labs" class="flex h-9 w-full rounded-md border @error('title') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                    @error('title')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-sm font-medium leading-none text-slate-700">Short Description</label>
                    <textarea name="description" id="description" rows="2" placeholder="e.g. Modern and interactive learning spaces" class="flex min-h-[70px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">{{ old('description') }}</textarea>
                    <p class="text-xs text-slate-500">Brief one-line summary displayed beneath the facility card title.</p>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 2: Visual Styling & Icon -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">2. Card Design & Floating Icon</h4>
                    <p class="text-xs text-slate-500">Matches the curved bottom wave and floating circular icon in the website design.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Wave Accent Color -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none text-slate-700">Bottom Wave Accent Color</label>
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <label class="relative flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-slate-900 has-[:checked]:ring-1 has-[:checked]:ring-slate-900">
                                <input type="radio" name="theme_color" value="navy" {{ old('theme_color', 'navy') === 'navy' ? 'checked' : '' }} class="text-slate-900">
                                <div class="flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-jrs-navy shrink-0"></span>
                                    <span class="text-xs font-semibold text-slate-800">Navy Wave</span>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-slate-900 has-[:checked]:ring-1 has-[:checked]:ring-slate-900">
                                <input type="radio" name="theme_color" value="red" {{ old('theme_color') === 'red' ? 'checked' : '' }} class="text-slate-900">
                                <div class="flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-red-600 shrink-0"></span>
                                    <span class="text-xs font-semibold text-slate-800">Red Wave</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Icon Preset -->
                    <div class="space-y-2">
                        <label for="icon" class="text-sm font-medium leading-none text-slate-700">Circular Icon Symbol</label>
                        <select name="icon" id="icon" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                            <option value="monitor" {{ old('icon') == 'monitor' ? 'selected' : '' }}>🖥️ Smart Classroom / Monitor</option>
                            <option value="flask" {{ old('icon') == 'flask' ? 'selected' : '' }}>🧪 Science & Computer Labs (Flask)</option>
                            <option value="book" {{ old('icon') == 'book' ? 'selected' : '' }}>📖 Library (Open Book)</option>
                            <option value="trophy" {{ old('icon') == 'trophy' ? 'selected' : '' }}>🏃 Sports Facilities (Athletics / Running)</option>
                            <option value="bus" {{ old('icon') == 'bus' ? 'selected' : '' }}>🚌 School Transport (Bus)</option>
                            <option value="school" {{ old('icon') == 'school' ? 'selected' : '' }}>🏫 Campus / General Infrastructure</option>
                        </select>
                        <p class="text-xs text-slate-500">Floating badge icon centered on the bottom wave.</p>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 3: Facility Photograph -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">3. Facility Photograph</h4>
                    <p class="text-xs text-slate-500">Upload a crisp photo showing students or the facility in action.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="image" class="text-sm font-medium leading-none text-slate-700">Upload Photo File</label>
                        <input type="file" name="image" id="image" accept="image/*" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs text-slate-600 shadow-xs file:border-0 file:bg-transparent file:text-xs file:font-medium file:text-slate-900 cursor-pointer">
                        @error('image')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="image_url" class="text-sm font-medium leading-none text-slate-700">Or Image URL</label>
                        <input type="text" name="image_url" id="image_url" value="{{ old('image_url') }}" placeholder="https://..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 4: Display Order & Status -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">4. Display Settings</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                    <div class="space-y-2">
                        <label for="sort_order" class="text-sm font-medium leading-none text-slate-700">Display Order</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                        <p class="text-xs text-slate-500">Cards sequence in the carousel (1, 2, 3...).</p>
                    </div>

                    <!-- Switch -->
                    <div class="sm:pt-3">
                        <div class="flex items-center space-x-3 rounded-lg border border-slate-200 p-3 shadow-2xs bg-white">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-slate-900"></div>
                            </label>
                            <div class="space-y-0.5">
                                <span class="text-xs font-semibold text-slate-900">Publish Immediately</span>
                                <p class="text-[11px] text-slate-500">Visible in facilities showcase</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-2">
                <a href="{{ route('admin.facilities.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 h-9 px-4 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-slate-900 text-white shadow-xs hover:bg-slate-800 h-9 px-4 transition-colors gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Create Facility</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
