@extends('admin.layout')

@section('title', 'Admission Popup Modal')
@section('header', 'Admission Popup')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-bold text-jrs-navy">Admission Popup Modal</h1>
                @if($popup->is_active)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Active on Frontend
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        Inactive / Hidden
                    </span>
                @endif
            </div>
            <p class="text-xs text-slate-500 mt-1">Configure and manage the promotional Admission popup modal displayed to website visitors.</p>
        </div>

        <div class="flex items-center gap-2">
            <form action="{{ route('admin.admission-popup.toggle') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $popup->is_active ? 'bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs' }}">
                    <i class="bi bi-power text-sm"></i>
                    <span>{{ $popup->is_active ? 'Disable Popup' : 'Enable Popup' }}</span>
                </button>
            </form>
        </div>
    </div>



    <!-- FORM SETTINGS CARD -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/70">
            <h2 class="text-sm font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-2">
                <i class="bi bi-sliders text-jrs-red"></i>
                <span>Edit Admission Popup Settings</span>
            </h2>
        </div>

        <form action="{{ route('admin.admission-popup.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- SECTION 1: VISIBILITY TOGGLE -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                <div>
                    <label for="is_active" class="text-sm font-bold text-slate-800 cursor-pointer">Enable Popup on Website</label>
                    <p class="text-xs text-slate-500">When checked, visitors to the website will see this popup dialog.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $popup->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <!-- SECTION 2: LEFT BANNER & SCHOOL IDENTITY -->
            <div class="space-y-4 pt-2">
                <h3 class="text-xs font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i class="bi bi-image text-blue-500"></i>
                    <span>Left Banner (Photo & Overlay Details)</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Upload Left Side Image</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border border-slate-200 rounded-xl p-1.5">
                        <span class="text-[11px] text-slate-400 mt-1 block">Recommended size: 600x800px or vertical campus photo. Max: 5MB.</span>
                        @error('image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Image Path (Fallback URL) -->
                    <div>
                        <label for="image_path" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Or Image URL / Path</label>
                        <input type="text" name="image_path" id="image_path" value="{{ old('image_path', $popup->image_path) }}" placeholder="e.g. https://... or /assets/images/popup.jpg" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                        @error('image_path') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Badge Text -->
                    <div>
                        <label for="badge_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Top-Left Red Pill Badge *</label>
                        <input type="text" name="badge_text" id="badge_text" required value="{{ old('badge_text', $popup->badge_text) }}" placeholder="e.g. ADMISSIONS OPEN" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 font-semibold">
                        @error('badge_text') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- CBSE Affiliation Text -->
                    <div>
                        <label for="cbse_affiliation_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">CBSE Affiliation & Code</label>
                        <input type="text" name="cbse_affiliation_text" id="cbse_affiliation_text" value="{{ old('cbse_affiliation_text', $popup->cbse_affiliation_text) }}" placeholder="e.g. CBSE AFFILIATION: 3630478 • SCHOOL CODE: 56725" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                        @error('cbse_affiliation_text') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- School Name -->
                    <div>
                        <label for="school_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">School Name</label>
                        <input type="text" name="school_name" id="school_name" value="{{ old('school_name', $popup->school_name) }}" placeholder="e.g. JRS International School" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 font-bold">
                        @error('school_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- School Location -->
                    <div>
                        <label for="school_location" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">School Location</label>
                        <input type="text" name="school_location" id="school_location" value="{{ old('school_location', $popup->school_location) }}" placeholder="e.g. Narapally, Near Uppal, Hyderabad" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                        @error('school_location') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION 3: RIGHT SIDE CONTENT -->
            <div class="space-y-4 pt-4 border-t border-slate-200">
                <h3 class="text-xs font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i class="bi bi-card-text text-amber-500"></i>
                    <span>Right Side Content & Titles</span>
                </h3>

                <!-- Academic Year Badge -->
                <div>
                    <label for="academic_year_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Top Eyebrow Badge *</label>
                    <input type="text" name="academic_year_badge" id="academic_year_badge" required value="{{ old('academic_year_badge', $popup->academic_year_badge) }}" placeholder="e.g. Academic Year 2027 – 2028" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                    <span class="text-[11px] text-slate-400 mt-1 block">Displayed with a sparkle icon at the top of the content.</span>
                    @error('academic_year_badge') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Title Prefix -->
                    <div>
                        <label for="title_prefix" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Main Title Prefix *</label>
                        <input type="text" name="title_prefix" id="title_prefix" required value="{{ old('title_prefix', $popup->title_prefix) }}" placeholder="e.g. Admissions Open For" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 font-bold">
                        @error('title_prefix') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Academic Year Highlight -->
                    <div>
                        <label for="academic_year_highlight" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Academic Year (Red Highlight) *</label>
                        <input type="text" name="academic_year_highlight" id="academic_year_highlight" required value="{{ old('academic_year_highlight', $popup->academic_year_highlight) }}" placeholder="e.g. 2027 – 2028" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-red-600 font-black">
                        @error('academic_year_highlight') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Popup Description *</label>
                    <textarea name="description" id="description" rows="3" required placeholder="e.g. Enrolling students from Nursery to Grade XII..." class="w-full px-3.5 py-2.5 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 leading-relaxed">{{ old('description', $popup->description) }}</textarea>
                    @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- SECTION 4: FEATURES REPEATER (GREEN CHECKMARKS) -->
            <div class="space-y-4 pt-4 border-t border-slate-200">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-2">
                        <i class="bi bi-check2-circle text-emerald-500"></i>
                        <span>Checklist Features (Green Checkmarks)</span>
                    </h3>
                    <button type="button" id="add-feature-btn" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-jrs-navy hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-xs">
                        <i class="bi bi-plus-lg"></i>
                        <span>Add Feature</span>
                    </button>
                </div>

                <div id="features-container" class="space-y-2.5">
                    @php
                        $featuresList = old('features', $popup->features ?? []);
                        if (!is_array($featuresList) || empty($featuresList)) {
                            $featuresList = [
                                'CBSE Curriculum with experiential, inquiry-based learning',
                                'STEM, Robotics & Cognospace innovation labs',
                                'World-Class Sports & Co-curricular clubs',
                                'Safe GPS-Enabled Fleet & 100% CCTV secured campus',
                            ];
                        }
                    @endphp

                    @foreach($featuresList as $index => $item)
                        <div class="feature-item flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center shrink-0 text-xs font-bold">
                                <i class="bi bi-check-lg"></i>
                            </span>
                            <input type="text" name="features[]" value="{{ $item }}" placeholder="e.g. STEM, Robotics & Cognospace innovation labs" class="feature-input flex-1 px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                            <button type="button" onclick="removeFeatureRow(this)" class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                <i class="bi bi-trash3 text-sm"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- SECTION 5: CONTACT PHONE NUMBER -->
            <div class="space-y-4 pt-4 border-t border-slate-200">
                <h3 class="text-xs font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i class="bi bi-telephone-outbound text-emerald-500"></i>
                    <span>Contact Phone (Call Button)</span>
                </h3>

                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Call Dial Phone Number *</label>
                    <input type="text" name="phone_number" id="phone_number" required value="{{ old('phone_number', $popup->phone_number) }}" placeholder="e.g. +91 92814 09674" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 font-semibold">
                    <span class="text-[11px] text-slate-400 mt-1 block">Displayed on the secondary call button. The primary button remains "Enquire / Apply Online" to open the enquiry modal.</span>
                    @error('phone_number') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- SAVE BUTTON -->
            <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-jrs-red/20">
                    <i class="bi bi-check2-circle text-sm"></i>
                    <span>Save Popup Changes</span>
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Features Repeater Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addFeatureBtn = document.getElementById('add-feature-btn');
        const featuresContainer = document.getElementById('features-container');

        if (addFeatureBtn && featuresContainer) {
            addFeatureBtn.addEventListener('click', function () {
                const row = document.createElement('div');
                row.className = 'feature-item flex items-center gap-2';
                row.innerHTML = `
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center shrink-0 text-xs font-bold">
                        <i class="bi bi-check-lg"></i>
                    </span>
                    <input type="text" name="features[]" value="" placeholder="New feature point..." class="flex-1 px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                    <button type="button" onclick="removeFeatureRow(this)" class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                        <i class="bi bi-trash3 text-sm"></i>
                    </button>
                `;
                featuresContainer.appendChild(row);
            });
        }

        window.removeFeatureRow = function (btn) {
            const row = btn.closest('.feature-item');
            if (row) {
                row.remove();
            }
        };
    });
</script>
@endsection
