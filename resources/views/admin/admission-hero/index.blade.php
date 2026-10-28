@extends('admin.layout')

@section('title', 'Admission Open')
@section('header', 'Admission Open')

@section('content')
<div class="space-y-6">


    <!-- Edit Form Card with Tabs -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        
        <!-- Navigation Tabs -->
        <div class="flex border-b border-slate-200 bg-slate-50/70 p-2 gap-2">
            <button type="button" id="tab-btn-hero" onclick="switchSection('hero')" class="tab-button active flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all bg-white text-jrs-navy shadow-xs border border-slate-200">
                <i class="bi bi-stars text-amber-500"></i>
                <span>Hero Banner & Features</span>
            </button>
            <button type="button" id="tab-btn-form" onclick="switchSection('form')" class="tab-button flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all text-slate-500 hover:text-slate-800 hover:bg-white/60">
                <i class="bi bi-ui-checks text-jrs-red"></i>
                <span>Enquiry Form & Dropdowns</span>
            </button>
        </div>

        <form action="{{ route('admin.admission-hero.update') }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- ============================================================ -->
            <!-- SECTION 1: HERO SHOWCASE (HEADER, CONTACTS, FEATURES, BADGES) -->
            <!-- ============================================================ -->
            <div id="section-hero" class="space-y-6">
                <!-- Location Badge Tag -->
                <div>
                    <label for="location_tag" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Location Badge Tag *</label>
                    <input type="text" name="location_tag" id="location_tag" required value="{{ old('location_tag', $hero->location_tag) }}" placeholder="e.g. NARAPALLY, HYDERABAD" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                    <span class="text-[11px] text-slate-400 mt-1 block">Displayed with a location pin at the top-left badge.</span>
                    @error('location_tag') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Main Title Prefix -->
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Section Title Prefix *</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $hero->title) }}" placeholder="e.g. Admission Open For" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                        @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Academic Year Highlight -->
                    <div>
                        <label for="academic_year" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Academic Year (Gold Highlight) *</label>
                        <input type="text" name="academic_year" id="academic_year" required value="{{ old('academic_year', $hero->academic_year) }}" placeholder="e.g. 2026 – 2027" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 font-bold text-amber-600">
                        @error('academic_year') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Description *</label>
                    <textarea name="description" id="description" rows="3" required placeholder="e.g. Give your child the right foundation for a brighter future..." class="w-full px-3.5 py-2.5 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 leading-relaxed">{{ old('description', $hero->description) }}</textarea>
                    @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Quick Contacts Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Contact Phone *</label>
                        <input type="text" name="phone" id="phone" required value="{{ old('phone', $hero->phone) }}" placeholder="e.g. +91 915740 43210" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                        @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Contact Email *</label>
                        <input type="email" name="email" id="email" required value="{{ old('email', $hero->email) }}" placeholder="e.g. info@jrsinternationalschool.com" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                        @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- DYNAMIC FEATURES SECTION WITH (+) PLUS BUTTON -->
                <div class="pt-6 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-xs font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-1.5">
                                <i class="bi bi-stars text-amber-500"></i>
                                Highlight Features (+) Repeater
                            </span>
                            <p class="text-[11px] text-slate-500 mt-0.5">Custom highlight badges displayed on the left banner (e.g. CBSE Curriculum, Holistic Growth, Top Faculty).</p>
                        </div>

                        <!-- (+) Plus Add Feature Button -->
                        <button type="button" id="add-feature-btn" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-jrs-navy hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
                            <i class="bi bi-plus-lg text-sm font-bold"></i>
                            <span>Add Feature</span>
                        </button>
                    </div>

                    @php
                        $featuresList = old('features', $hero->features ?? []);
                        if (!is_array($featuresList)) {
                            $featuresList = [];
                        }
                    @endphp

                    <div id="features-container" class="space-y-3">
                        @forelse($featuresList as $index => $feature)
                            <div class="feature-item p-4 rounded-xl border border-slate-200 bg-slate-50/60 relative group hover:border-slate-300 transition-colors">
                                <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-200/80">
                                    <span class="feature-badge-num text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="bi bi-grid-fill text-slate-400 text-xs"></i>
                                        Feature #{{ $loop->iteration }}
                                    </span>
                                    <button type="button" class="remove-feature-btn text-slate-400 hover:text-red-600 text-xs font-bold px-2 py-1 rounded-lg hover:bg-red-50 transition-colors inline-flex items-center gap-1">
                                        <i class="bi bi-trash3"></i>
                                        <span>Remove</span>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start">
                                    <div class="md:col-span-5">
                                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Title *</label>
                                        <input type="text" name="features[{{ $index }}][title]" required value="{{ $feature['title'] ?? '' }}" placeholder="e.g. CBSE Curriculum" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 text-slate-800 focus:border-jrs-navy outline-none bg-white font-medium">
                                    </div>

                                    <div class="md:col-span-4">
                                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Subtitle</label>
                                        <input type="text" name="features[{{ $index }}][subtitle]" value="{{ $feature['subtitle'] ?? '' }}" placeholder="e.g. National standards" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 text-slate-800 focus:border-jrs-navy outline-none bg-white">
                                    </div>

                                    <div class="md:col-span-3">
                                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Icon Class</label>
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-jrs-navy text-sm shadow-2xs icon-preview">
                                                <i class="{{ !empty($feature['icon']) ? $feature['icon'] : 'bi bi-award-fill' }}"></i>
                                            </div>
                                            <input type="text" name="features[{{ $index }}][icon]" value="{{ $feature['icon'] ?? 'bi bi-award-fill' }}" placeholder="bi bi-stars" class="feature-icon-input w-full px-2.5 py-1.5 rounded-lg text-xs border border-slate-200 font-mono text-slate-800 focus:border-jrs-navy outline-none bg-white">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2.5 flex items-center gap-1.5 flex-wrap pt-2 border-t border-dashed border-slate-200">
                                    <span class="text-[10px] text-slate-400 font-medium mr-1">Presets:</span>
                                    <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-mortarboard-fill">🎓 Graduation</button>
                                    <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-stars">✨ Stars</button>
                                    <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-award-fill">🏆 Award</button>
                                    <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-book-half">📖 Book</button>
                                    <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-trophy-fill">🥇 Trophy</button>
                                    <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-shield-check">🛡️ Shield</button>
                                </div>
                            </div>
                        @empty
                            <div id="no-features-msg" class="p-6 rounded-xl border border-dashed border-slate-200 text-center text-slate-400 text-xs">
                                No features added yet. Click <span class="font-bold text-jrs-navy">+ Add Feature</span> above to add your first highlight.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- DYNAMIC TRUST BADGES WITH (+) PLUS BUTTON -->
                <div class="pt-6 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-xs font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-1.5">
                                <i class="bi bi-shield-check text-emerald-500"></i>
                                Trust Badges (+) Repeater
                            </span>
                            <p class="text-[11px] text-slate-500 mt-0.5">Reassurance pills at the bottom (e.g. 100% Confidential, Quick 24-hr Response).</p>
                        </div>

                        <button type="button" id="add-badge-btn" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all border border-slate-200">
                            <i class="bi bi-plus-lg text-sm font-bold"></i>
                            <span>Add Badge</span>
                        </button>
                    </div>

                    @php
                        $badgesList = old('trust_badges', $hero->trust_badges ?? []);
                        if (!is_array($badgesList)) {
                            $badgesList = [];
                        }
                    @endphp

                    <div id="badges-container" class="space-y-2.5">
                        @forelse($badgesList as $badge)
                            <div class="badge-item flex items-center gap-2">
                                <div class="flex-1">
                                    <input type="text" name="trust_badges[]" value="{{ $badge }}" placeholder="e.g. 100% Confidential" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 text-slate-800 focus:border-jrs-navy outline-none bg-white">
                                </div>
                                <button type="button" class="remove-badge-btn px-2.5 py-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 text-xs font-bold transition-colors">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        @empty
                            <div id="no-badges-msg" class="p-4 rounded-xl border border-dashed border-slate-200 text-center text-slate-400 text-xs">
                                No trust badges added yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- SECTION 2: ENQUIRY FORM & DROPDOWNS CONFIGURATION            -->
            <!-- ============================================================ -->
            <div id="section-form" class="space-y-6 hidden">
                <div class="bg-amber-50/50 border border-amber-200/80 rounded-xl p-4 text-xs text-amber-900 flex items-start gap-3">
                    <i class="bi bi-info-circle-fill text-amber-600 text-base shrink-0 mt-0.5"></i>
                    <div>
                        <span class="font-bold">Website Enquiry Form Dropdowns:</span>
                        <p class="text-[11px] text-amber-800 mt-0.5">Customize the selectable dropdown options for Academic Years and Admission Types on the website enquiry form using the (+) buttons.</p>
                    </div>
                </div>

                <!-- 1. ACADEMIC YEARS REPEATER -->
                @php
                    $enquiryYears = old('enquiry_academic_years', $hero->enquiry_academic_years ?? ['2026-2027', '2027-2028']);
                    if (!is_array($enquiryYears) || empty($enquiryYears)) {
                        $enquiryYears = ['2026-2027', '2027-2028'];
                    }
                @endphp
                <div class="pt-4 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <span class="text-xs font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-1.5">
                                <i class="bi bi-calendar3 text-indigo-500"></i>
                                Academic Years Dropdown Options
                            </span>
                            <p class="text-[11px] text-slate-500">Available years selectable by parents (e.g. 2026-2027, 2027-2028).</p>
                        </div>
                        <button type="button" id="add-year-btn" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold transition-all border border-indigo-200">
                            <i class="bi bi-plus-lg"></i>
                            <span>Add Year</span>
                        </button>
                    </div>

                    <div id="years-container" class="space-y-2">
                        @foreach($enquiryYears as $year)
                            <div class="year-item flex items-center gap-2">
                                <input type="text" name="enquiry_academic_years[]" value="{{ $year }}" required placeholder="e.g. 2026-2027" class="flex-1 px-3 py-1.5 rounded-lg text-xs border border-slate-200 text-slate-800 bg-white">
                                <button type="button" class="remove-simple-btn px-2.5 py-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 text-xs font-bold">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 2. ADMISSION TYPES REPEATER -->
                @php
                    $enquiryTypes = old('enquiry_admission_types', $hero->enquiry_admission_types ?? ['DAY SCHOLAR', 'DAY BOARDING', 'RESIDENTIAL']);
                    if (!is_array($enquiryTypes) || empty($enquiryTypes)) {
                        $enquiryTypes = ['DAY SCHOLAR', 'DAY BOARDING', 'RESIDENTIAL'];
                    }
                @endphp
                <div class="pt-4 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <span class="text-xs font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-1.5">
                                <i class="bi bi-tag-fill text-emerald-500"></i>
                                Admission Types Dropdown Options
                            </span>
                            <p class="text-[11px] text-slate-500">e.g. DAY SCHOLAR, DAY BOARDING, RESIDENTIAL.</p>
                        </div>
                        <button type="button" id="add-type-btn" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold transition-all border border-emerald-200">
                            <i class="bi bi-plus-lg"></i>
                            <span>Add Type</span>
                        </button>
                    </div>

                    <div id="types-container" class="space-y-2">
                        @foreach($enquiryTypes as $type)
                            <div class="type-item flex items-center gap-2">
                                <input type="text" name="enquiry_admission_types[]" value="{{ $type }}" required placeholder="e.g. DAY SCHOLAR" class="flex-1 px-3 py-1.5 rounded-lg text-xs border border-slate-200 text-slate-800 bg-white">
                                <button type="button" class="remove-simple-btn px-2.5 py-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 text-xs font-bold">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Submit Button (Always Visible at bottom) -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">All changes will take effect immediately on the live website and API.</span>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/20">
                    <i class="bi bi-check2"></i>
                    <span>Save All Changes</span>
                </button>
            </div>
        </form>
    </div>

</div>

<!-- JavaScript for Tab Switching and Dynamic Repeaters -->
<script>
function switchSection(section) {
    const secHero = document.getElementById('section-hero');
    const secForm = document.getElementById('section-form');
    const btnHero = document.getElementById('tab-btn-hero');
    const btnForm = document.getElementById('tab-btn-form');

    if (section === 'hero') {
        secHero.classList.remove('hidden');
        secForm.classList.add('hidden');
        btnHero.classList.add('bg-white', 'text-jrs-navy', 'shadow-xs', 'border', 'border-slate-200');
        btnHero.classList.remove('text-slate-500');
        btnForm.classList.remove('bg-white', 'text-jrs-navy', 'shadow-xs', 'border', 'border-slate-200');
        btnForm.classList.add('text-slate-500');
    } else {
        secForm.classList.remove('hidden');
        secHero.classList.add('hidden');
        btnForm.classList.add('bg-white', 'text-jrs-navy', 'shadow-xs', 'border', 'border-slate-200');
        btnForm.classList.remove('text-slate-500');
        btnHero.classList.remove('bg-white', 'text-jrs-navy', 'shadow-xs', 'border', 'border-slate-200');
        btnHero.classList.add('text-slate-500');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // --------------------------------------------------
    // FEATURES REPEATER
    // --------------------------------------------------
    let featureIndex = {{ count($featuresList) + 10 }};
    const featuresContainer = document.getElementById('features-container');
    const addFeatureBtn = document.getElementById('add-feature-btn');

    function reindexFeatures() {
        const items = featuresContainer.querySelectorAll('.feature-item');
        items.forEach((item, idx) => {
            const badge = item.querySelector('.feature-badge-num');
            if (badge) {
                badge.innerHTML = `<i class="bi bi-grid-fill text-slate-400 text-xs"></i> Feature #${idx + 1}`;
            }
        });
        const noMsg = document.getElementById('no-features-msg');
        if (noMsg) {
            noMsg.style.display = items.length === 0 ? 'block' : 'none';
        }
    }

    if (addFeatureBtn) {
        addFeatureBtn.addEventListener('click', function () {
            const noMsg = document.getElementById('no-features-msg');
            if (noMsg) noMsg.remove();

            featureIndex++;
            const itemHtml = `
                <div class="feature-item p-4 rounded-xl border border-slate-200 bg-slate-50/60 relative group hover:border-slate-300 transition-colors animate-fade-in">
                    <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-200/80">
                        <span class="feature-badge-num text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="bi bi-grid-fill text-slate-400 text-xs"></i>
                            Feature
                        </span>
                        <button type="button" class="remove-feature-btn text-slate-400 hover:text-red-600 text-xs font-bold px-2 py-1 rounded-lg hover:bg-red-50 transition-colors inline-flex items-center gap-1">
                            <i class="bi bi-trash3"></i>
                            <span>Remove</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start">
                        <div class="md:col-span-5">
                            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Title *</label>
                            <input type="text" name="features[${featureIndex}][title]" required placeholder="e.g. CBSE Curriculum" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 text-slate-800 focus:border-jrs-navy outline-none bg-white font-medium">
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Subtitle</label>
                            <input type="text" name="features[${featureIndex}][subtitle]" placeholder="e.g. National standards" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 text-slate-800 focus:border-jrs-navy outline-none bg-white">
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Icon Class</label>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-jrs-navy text-sm shadow-2xs icon-preview">
                                    <i class="bi bi-award-fill"></i>
                                </div>
                                <input type="text" name="features[${featureIndex}][icon]" value="bi bi-award-fill" placeholder="bi bi-stars" class="feature-icon-input w-full px-2.5 py-1.5 rounded-lg text-xs border border-slate-200 font-mono text-slate-800 focus:border-jrs-navy outline-none bg-white">
                            </div>
                        </div>
                    </div>

                    <div class="mt-2.5 flex items-center gap-1.5 flex-wrap pt-2 border-t border-dashed border-slate-200">
                        <span class="text-[10px] text-slate-400 font-medium mr-1">Presets:</span>
                        <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-mortarboard-fill">🎓 Graduation</button>
                        <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-stars">✨ Stars</button>
                        <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-award-fill">🏆 Award</button>
                        <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-book-half">📖 Book</button>
                        <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-trophy-fill">🥇 Trophy</button>
                        <button type="button" class="preset-icon-btn px-2 py-0.5 rounded-md text-[10px] bg-white border border-slate-200 text-slate-600 hover:border-jrs-navy hover:text-jrs-navy transition-colors" data-icon="bi bi-shield-check">🛡️ Shield</button>
                    </div>
                </div>
            `;
            featuresContainer.insertAdjacentHTML('beforeend', itemHtml);
            reindexFeatures();
        });

        featuresContainer.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.remove-feature-btn');
            if (removeBtn) {
                const item = removeBtn.closest('.feature-item');
                if (item) {
                    item.remove();
                    reindexFeatures();
                }
            }

            const presetBtn = e.target.closest('.preset-icon-btn');
            if (presetBtn) {
                const item = presetBtn.closest('.feature-item');
                const iconClass = presetBtn.getAttribute('data-icon');
                const iconInput = item.querySelector('.feature-icon-input');
                const iconPreview = item.querySelector('.icon-preview i');
                if (iconInput && iconClass) iconInput.value = iconClass;
                if (iconPreview && iconClass) iconPreview.className = iconClass;
            }
        });

        featuresContainer.addEventListener('input', function (e) {
            if (e.target.classList.contains('feature-icon-input')) {
                const item = e.target.closest('.feature-item');
                const iconPreview = item ? item.querySelector('.icon-preview i') : null;
                if (iconPreview) {
                    iconPreview.className = e.target.value.trim() || 'bi bi-award-fill';
                }
            }
        });
    }

    // --------------------------------------------------
    // TRUST BADGES REPEATER
    // --------------------------------------------------
    const badgesContainer = document.getElementById('badges-container');
    const addBadgeBtn = document.getElementById('add-badge-btn');

    if (addBadgeBtn) {
        addBadgeBtn.addEventListener('click', function () {
            const noMsg = document.getElementById('no-badges-msg');
            if (noMsg) noMsg.remove();

            const badgeHtml = `
                <div class="badge-item flex items-center gap-2 animate-fade-in">
                    <div class="flex-1">
                        <input type="text" name="trust_badges[]" placeholder="e.g. 100% Confidential" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 text-slate-800 focus:border-jrs-navy outline-none bg-white">
                    </div>
                    <button type="button" class="remove-badge-btn px-2.5 py-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 text-xs font-bold transition-colors">
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
            `;
            badgesContainer.insertAdjacentHTML('beforeend', badgeHtml);
        });

        badgesContainer.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.remove-badge-btn');
            if (removeBtn) {
                const item = removeBtn.closest('.badge-item');
                if (item) item.remove();
            }
        });
    }

    // --------------------------------------------------
    // ENQUIRY FORM DROPDOWN REPEATERS
    // --------------------------------------------------
    // Helper for simple item repeaters
    function setupSimpleRepeater(btnId, containerId, inputName, placeholder, itemClass, isGrid) {
        const btn = document.getElementById(btnId);
        const container = document.getElementById(containerId);
        if (!btn || !container) return;

        btn.addEventListener('click', function () {
            let html = '';
            if (isGrid) {
                html = `
                    <div class="${itemClass} flex items-center gap-1.5 bg-slate-50 p-1.5 rounded-lg border border-slate-200 animate-fade-in">
                        <input type="text" name="${inputName}" required placeholder="${placeholder}" class="flex-1 px-2.5 py-1 rounded text-xs border border-slate-200 text-slate-800 bg-white">
                        <button type="button" class="remove-simple-btn px-2 py-1 rounded text-slate-400 hover:text-red-600 hover:bg-red-50 text-xs font-bold">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                `;
            } else {
                html = `
                    <div class="${itemClass} flex items-center gap-2 animate-fade-in">
                        <input type="text" name="${inputName}" required placeholder="${placeholder}" class="flex-1 px-3 py-1.5 rounded-lg text-xs border border-slate-200 text-slate-800 bg-white">
                        <button type="button" class="remove-simple-btn px-2.5 py-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 text-xs font-bold">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                `;
            }
            container.insertAdjacentHTML('beforeend', html);
        });

        container.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.remove-simple-btn');
            if (removeBtn) {
                const item = removeBtn.closest(`.${itemClass}`);
                if (item) item.remove();
            }
        });
    }

    setupSimpleRepeater('add-year-btn', 'years-container', 'enquiry_academic_years[]', 'e.g. 2026-2027', 'year-item', false);
    setupSimpleRepeater('add-type-btn', 'types-container', 'enquiry_admission_types[]', 'e.g. DAY SCHOLAR', 'type-item', false);
});
</script>
@endsection
