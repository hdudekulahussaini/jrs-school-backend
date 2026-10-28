@extends('admin.layout')

@section('title', 'Edit Policy Card - ' . $criterion->title)
@section('header', 'Edit Criteria & Guidelines Card')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Back Navigation -->
    <div>
        <a href="{{ route('admin.admission-criteria.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Back to Admission Criteria & Guidelines</span>
        </a>
    </div>

    <!-- Edit Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Admission Arrangements & Policy</span>
                <h3 class="font-bold text-jrs-navy font-heading text-base">Edit: {{ $criterion->title }}</h3>
            </div>
            <span class="text-xs font-mono font-bold text-jrs-navy bg-slate-100 px-2 py-1 rounded-md">Card #{{ $criterion->watermark_number }}</span>
        </div>

        <form action="{{ route('admin.admission-criteria.update', $criterion->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Step/Card Number -->
                <div>
                    <label for="step_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Card Number / Sequence *</label>
                    <input type="number" name="step_number" id="step_number" required min="1" max="50" value="{{ old('step_number', $criterion->step_number) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-800">
                    <span class="text-[11px] text-slate-400 mt-1 block">Displayed as watermark (e.g. 01, 02)</span>
                    @error('step_number') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Badge Tag -->
                <div>
                    <label for="badge_tag" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Badge Pill / Category Tag</label>
                    <input type="text" name="badge_tag" id="badge_tag" value="{{ old('badge_tag', $criterion->badge_tag) }}" placeholder="e.g. Early Years (Age 2+), Grades 1 to 12" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-800">
                    <span class="text-[11px] text-slate-400 mt-1 block">Upper-left pill tag inside the card</span>
                    @error('badge_tag') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Card Title -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Card Title *</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $criterion->title) }}" placeholder="e.g. Nursery Admission" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-800">
                @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Description / Policy Details</label>
                <textarea name="description" id="description" rows="3" placeholder="Enter full guidance text for parents..." class="w-full px-3.5 py-2.5 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-800 leading-relaxed">{{ old('description', $criterion->description) }}</textarea>
                @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Badge Icon Section -->
            <div class="space-y-3 pt-1 border-t border-slate-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 pt-3">
                    <label for="icon" class="text-sm font-semibold text-slate-800">
                        Badge Icon (Bootstrap Icon / FontAwesome / SVG)
                    </label>
                    <span class="text-xs text-slate-400">Navy rounded square icon</span>
                </div>

                <!-- Input row with Icon Preview Badge -->
                <div class="flex items-center gap-3">
                    <div id="icon-preview-box" class="w-12 h-12 rounded-xl bg-[#0b1c3e] text-white flex items-center justify-center text-xl shrink-0 shadow-sm transition-all">
                        @if($criterion->icon)
                            @if(str_contains($criterion->icon, '<'))
                                {!! $criterion->icon !!}
                            @elseif(str_starts_with($criterion->icon, 'bi ') || str_starts_with($criterion->icon, 'fa-'))
                                <i id="icon-preview" class="{{ $criterion->icon }}"></i>
                            @else
                                <i id="icon-preview" class="bi bi-{{ $criterion->icon }}"></i>
                            @endif
                        @else
                            <i id="icon-preview" class="bi bi-stars"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $criterion->icon) }}" placeholder="bi bi-stars or <i class='fa-solid fa-star'></i>" class="flex h-11 w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-800 shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:border-transparent font-mono">
                    </div>
                </div>

                <!-- Quick Presets -->
                <div class="space-y-2 pt-1">
                    <div class="text-xs font-semibold text-slate-600">Quick Presets (Criteria & Guidelines)</div>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" class="preset-badge inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 transition-colors text-slate-700" data-icon="bi bi-stars">
                            <i class="bi bi-stars text-blue-600"></i> Early Years / Nursery
                        </button>
                        <button type="button" class="preset-badge inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 transition-colors text-slate-700" data-icon="bi bi-clipboard-check-fill">
                            <i class="bi bi-clipboard-check-fill text-blue-600"></i> CLT / Test
                        </button>
                        <button type="button" class="preset-badge inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 transition-colors text-slate-700" data-icon="bi bi-people-fill">
                            <i class="bi bi-people-fill text-blue-600"></i> Seat Allocation
                        </button>
                        <button type="button" class="preset-badge inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 transition-colors text-slate-700" data-icon="bi bi-file-earmark-text-fill">
                            <i class="bi bi-file-earmark-text-fill text-blue-600"></i> Appeals & Support
                        </button>
                        <button type="button" class="preset-badge inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 transition-colors text-slate-700" data-icon="bi bi-shield-check">
                            <i class="bi bi-shield-check text-blue-600"></i> Policy / Verification
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bullet Checklist Points Repeater -->
            <div class="space-y-3 pt-3 border-t border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Checklist Bullet Points</label>
                        <span class="text-xs text-slate-400">Green checkmark bullets (e.g. "Proof of address required")</span>
                    </div>
                    <button type="button" id="add-point-btn" class="inline-flex items-center gap-1 text-xs font-bold text-jrs-navy hover:text-jrs-red transition-colors">
                        <i class="bi bi-plus-circle-fill"></i> Add Point
                    </button>
                </div>

                @php
                    $existingPoints = old('points', $criterion->points ?? []);
                    if (empty($existingPoints)) {
                        $existingPoints = [''];
                    }
                @endphp

                <div id="points-container" class="space-y-2">
                    @foreach($existingPoints as $pt)
                        <div class="point-row flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-emerald-500 text-sm shrink-0"></i>
                            <input type="text" name="points[]" value="{{ $pt }}" placeholder="e.g. Proof of address & birth certificate required" class="flex-1 px-3 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                            <button type="button" class="remove-point-btn p-2 text-slate-400 hover:text-red-500 transition-colors" title="Remove point">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Callout Note -->
            <div class="pt-3 border-t border-slate-100">
                <label for="note" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Callout Note Box (Optional)</label>
                <textarea name="note" id="note" rows="2" placeholder="e.g. Note: The sole purpose of CLT is to rightly assess the grade for which the child is eligible rather than to grant or refuse admission." class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-800">{{ old('note', $criterion->note) }}</textarea>
                <span class="text-[11px] text-slate-400 mt-1 block">Displayed inside a highlighted container at the bottom of the card (like in Card 02).</span>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.admission-criteria.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">Cancel</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/20">
                    Update Policy Card
                </button>
            </div>
        </form>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const iconInput = document.getElementById('icon');
    const previewBox = document.getElementById('icon-preview-box');
    const presetButtons = document.querySelectorAll('.preset-badge');

    function updatePreview(val) {
        if (!val || val.trim() === '') {
            previewBox.innerHTML = '<span class="text-xs text-white/50">None</span>';
            return;
        }
        val = val.trim();
        if (val.startsWith('<') && val.endsWith('>')) {
            previewBox.innerHTML = val;
        } else if (val.startsWith('bi ') || val.startsWith('fa-')) {
            previewBox.innerHTML = '<i class="' + val + '"></i>';
        } else {
            previewBox.innerHTML = '<i class="bi bi-' + val + '"></i>';
        }
    }

    if (iconInput) {
        iconInput.addEventListener('input', function () {
            updatePreview(this.value);
        });
    }

    presetButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const iconVal = this.getAttribute('data-icon');
            if (iconInput) {
                iconInput.value = iconVal;
                updatePreview(iconVal);
            }
        });
    });

    // Dynamic Points Repeater
    const pointsContainer = document.getElementById('points-container');
    const addPointBtn = document.getElementById('add-point-btn');

    if (addPointBtn && pointsContainer) {
        addPointBtn.addEventListener('click', function () {
            const row = document.createElement('div');
            row.className = 'point-row flex items-center gap-2';
            row.innerHTML = `
                <i class="bi bi-check-circle-fill text-emerald-500 text-sm shrink-0"></i>
                <input type="text" name="points[]" placeholder="Enter key point..." class="flex-1 px-3 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                <button type="button" class="remove-point-btn p-2 text-slate-400 hover:text-red-500 transition-colors" title="Remove point">
                    <i class="bi bi-x-lg"></i>
                </button>
            `;
            pointsContainer.appendChild(row);
        });

        pointsContainer.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.remove-point-btn');
            if (removeBtn) {
                const rows = pointsContainer.querySelectorAll('.point-row');
                if (rows.length > 1) {
                    removeBtn.closest('.point-row').remove();
                } else {
                    const input = rows[0].querySelector('input');
                    if (input) input.value = '';
                }
            }
        });
    }
});
</script>
@endsection
