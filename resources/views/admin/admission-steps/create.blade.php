@extends('admin.layout')

@section('title', 'Add Admission Process Step')
@section('header', 'Add Admission Step')

@section('content')
<div class="space-y-6 w-full">

    <!-- Back Navigation -->
    <div>
        <a href="{{ route('admin.admission-steps.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Back to Admission Process Steps</span>
        </a>
    </div>

    <!-- Create Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Steps of Admission Process</span>
                <h3 class="font-bold text-jrs-navy font-heading text-base">New Process Step</h3>
            </div>
            <span class="text-xs text-slate-400">Step #{{ $nextStep }}</span>
        </div>

        <form action="{{ route('admin.admission-steps.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Step Number -->
            <div class="max-w-xs">
                <label for="step_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Step Number *</label>
                <input type="number" name="step_number" id="step_number" required min="1" max="20" value="{{ old('step_number', $nextStep) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-800">
                @error('step_number') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Step Title -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Step Title *</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="e.g. Meet The Admission Officer" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-800">
                @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Step Guidance / Description</label>
                <textarea name="description" id="description" rows="3" placeholder="e.g. Visit the school campus and meet our admission officer for guidance." class="w-full px-3.5 py-2.5 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-800 leading-relaxed">{{ old('description') }}</textarea>
                @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Badge Icon Section matching user format -->
            <div class="space-y-3 pt-1">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <label for="icon" class="text-sm font-semibold text-slate-800">
                        Badge Icon (Bootstrap Icon / FontAwesome / SVG) <span class="text-rose-500">*</span>
                    </label>
                    <span class="text-xs text-slate-400">Overlapping badge icon displayed on the approach card</span>
                </div>

                <!-- Input row with Icon Preview Badge -->
                <div class="flex items-center gap-3">
                    <div id="icon-preview-box" class="w-12 h-12 rounded-xl bg-rose-50/80 border border-rose-200/80 flex items-center justify-center text-rose-600 text-2xl shrink-0 shadow-2xs transition-all">
                        <i id="icon-preview" class="bi bi-person-badge-fill"></i>
                    </div>
                    <div class="flex-1">
                        <input type="text" name="icon" id="icon" value="{{ old('icon', 'bi bi-person-badge-fill') }}" placeholder="bi bi-person-badge-fill or <i class='fa-solid fa-laptop-file'></i>" class="flex h-11 w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-800 shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:border-transparent font-mono">
                    </div>
                </div>

                <!-- Quick Presets -->
                <div class="space-y-2 pt-1">
                    <div class="text-xs font-semibold text-slate-600">Quick Presets (Admission Process & School)</div>
                    <div class="flex flex-wrap gap-2" id="icon-presets">
                        <button type="button" data-icon="bi bi-person-badge-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-person-badge-fill text-slate-600"></i>
                            <span>01. Meet Admission Officer</span>
                        </button>
                        <button type="button" data-icon="bi bi-file-earmark-text-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-file-earmark-text-fill text-slate-600"></i>
                            <span>02. Procure Application Form</span>
                        </button>
                        <button type="button" data-icon="bi bi-person-vcard-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-person-vcard-fill text-slate-600"></i>
                            <span>03. Register With Us</span>
                        </button>
                        <button type="button" data-icon="bi bi-pencil-square" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-pencil-square text-slate-600"></i>
                            <span>04. Admission Test</span>
                        </button>
                        <button type="button" data-icon="bi bi-chat-quote-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-chat-quote-fill text-slate-600"></i>
                            <span>05. Personal Interview</span>
                        </button>
                        <button type="button" data-icon="bi bi-credit-card-2-front-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-credit-card-2-front-fill text-slate-600"></i>
                            <span>06. Pay Fee</span>
                        </button>
                        <button type="button" data-icon="bi bi-mortarboard-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-mortarboard-fill text-slate-600"></i>
                            <span>Academic Enrollment</span>
                        </button>
                        <button type="button" data-icon="bi bi-clipboard2-check-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-clipboard2-check-fill text-slate-600"></i>
                            <span>Document Verification</span>
                        </button>
                        <button type="button" data-icon="bi bi-cash-coin" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-cash-coin text-slate-600"></i>
                            <span>Fee Counter</span>
                        </button>
                        <button type="button" data-icon="bi bi-buildings-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-buildings-fill text-slate-600"></i>
                            <span>Campus Visit</span>
                        </button>
                        <button type="button" data-icon="bi bi-trophy-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-trophy-fill text-slate-600"></i>
                            <span>Admission Granted</span>
                        </button>
                    </div>
                </div>
                @error('icon') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.admission-steps.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">Cancel</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/20">Create Step</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const iconInput = document.getElementById('icon');
    const previewBox = document.getElementById('icon-preview-box');
    const presetBtns = document.querySelectorAll('.icon-preset-btn');

    function updatePreview(val) {
        val = (val || '').trim();
        if (!val) {
            previewBox.innerHTML = '<i class="bi bi-stars"></i>';
            return;
        }

        if (val.startsWith('<')) {
            previewBox.innerHTML = val;
            return;
        }

        let iconClass = val;
        const aliasMap = {
            'officer': 'bi bi-person-badge-fill',
            'form': 'bi bi-file-earmark-text-fill',
            'register': 'bi bi-person-vcard-fill',
            'test': 'bi bi-pencil-square',
            'interview': 'bi bi-chat-quote-fill',
            'fee': 'bi bi-credit-card-2-front-fill',
            'trophy': 'bi bi-trophy-fill',
            'book': 'bi bi-book-half',
        };

        if (aliasMap[val]) {
            iconClass = aliasMap[val];
        } else if (!val.includes(' ') && !val.includes('-')) {
            iconClass = 'bi bi-' + val;
        }

        previewBox.innerHTML = '<i class="' + iconClass + '"></i>';

        presetBtns.forEach(btn => {
            const dataIcon = btn.getAttribute('data-icon');
            if (dataIcon === val || dataIcon === iconClass) {
                btn.classList.add('bg-rose-50', 'border-rose-300', 'text-rose-700', 'font-semibold');
                btn.classList.remove('bg-white', 'text-slate-700');
            } else {
                btn.classList.remove('bg-rose-50', 'border-rose-300', 'text-rose-700', 'font-semibold');
                btn.classList.add('bg-white', 'text-slate-700');
            }
        });
    }

    presetBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const iconVal = this.getAttribute('data-icon');
            iconInput.value = iconVal;
            updatePreview(iconVal);
        });
    });

    iconInput.addEventListener('input', function () {
        updatePreview(this.value);
    });

    updatePreview(iconInput.value);
});
</script>
@endsection
