@extends('admin.layout')

@section('title', 'Edit Principal of JRS')
@section('header', 'Edit Principal Sections')

@section('content')
<div class="space-y-6 max-w-5xl">

    <!-- Back Navigation -->
    <div>
        <a href="{{ route('admin.principal.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Back to Principal Records</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <form action="{{ route('admin.principal.update', $principal->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- SECTION 1: Document Header Details -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Document Layout</span>
                    <h3 class="font-bold text-jrs-navy font-heading text-base">Top Document Header & Academic Year</h3>
                </div>
                <span class="text-xs text-slate-400">Official Letterhead</span>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="desk_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Desk Title</label>
                    <input type="text" name="desk_title" id="desk_title" value="{{ old('desk_title', $principal->desk_title) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. FROM THE DESK OF">
                </div>

                <div>
                    <label for="desk_subtitle" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Desk Subtitle / Role</label>
                    <input type="text" name="desk_subtitle" id="desk_subtitle" value="{{ old('desk_subtitle', $principal->desk_subtitle) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. The Principal, JRS International School">
                </div>

                <div>
                    <label for="official_address_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Official Address Label</label>
                    <input type="text" name="official_address_badge" id="official_address_badge" value="{{ old('official_address_badge', $principal->official_address_badge) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. OFFICIAL ADDRESS">
                </div>

                <div>
                    <label for="academic_year" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Academic Year</label>
                    <input type="text" name="academic_year" id="academic_year" value="{{ old('academic_year', $principal->academic_year) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. Academic Year 2026 – 2027">
                </div>
            </div>
        </div>

        <!-- SECTION 2: Academic Leadership Profile Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Profile Card</span>
                    <h3 class="font-bold text-jrs-navy font-heading text-base">Academic Leadership Profile & Portrait Photo</h3>
                </div>
                <span class="text-xs text-slate-400">Left Card Column</span>
            </div>

            <div class="p-6 space-y-6">
                <!-- Photo Upload Box -->
                <div>
                    @include('admin.partials.image-upload', [
                        'name' => 'image',
                        'id' => 'image',
                        'label' => 'Portrait Photo',
                        'current' => $principal->image_full_url ?? null,
                        'currentPath' => $principal->image_path ?? null,
                        'removeName' => 'remove_image',
                        'aspect' => 'portrait',
                        'help' => 'Recommended: High quality executive portrait photo (JPG, PNG, or WebP up to 3MB).',
                    ])
                </div>

                <!-- Profile Text Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="card_badge" class="block text-xs font-semibold text-slate-600 mb-1">Photo Badge</label>
                        <input type="text" name="card_badge" id="card_badge" value="{{ old('card_badge', $principal->card_badge) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. PRINCIPAL">
                    </div>

                    <div>
                        <label for="profile_badge" class="block text-xs font-semibold text-slate-600 mb-1">Sub-badge / Category</label>
                        <input type="text" name="profile_badge" id="profile_badge" value="{{ old('profile_badge', $principal->profile_badge) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. ACADEMIC LEADERSHIP">
                    </div>

                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-600 mb-1">Principal Name *</label>
                        <input type="text" name="name" id="name" required value="{{ old('name', $principal->name) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. Mrs. Marlene Mannas">
                    </div>

                    <div>
                        <label for="sub_title" class="block text-xs font-semibold text-slate-600 mb-1">Designation / Subtitle</label>
                        <input type="text" name="sub_title" id="sub_title" value="{{ old('sub_title', $principal->sub_title) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. Principal, JRS International School">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: Principal's Address & Body Content -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Message Body</span>
                    <h3 class="font-bold text-jrs-navy font-heading text-base">Address, Salutation & Highlight Quote</h3>
                </div>
                <span class="text-xs text-slate-400">Right Column</span>
            </div>

            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="section_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Section Badge</label>
                        <input type="text" name="section_badge" id="section_badge" value="{{ old('section_badge', $principal->section_badge) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. PRINCIPAL'S MESSAGE">
                    </div>

                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Main Heading *</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $principal->title) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. Empowering Minds And Enriching Lives">
                    </div>

                    <div>
                        <label for="salutation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Salutation</label>
                        <input type="text" name="salutation" id="salutation" value="{{ old('salutation', $principal->salutation) }}" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors" placeholder="e.g. Dear Parents, Students And Well-Wishers,">
                    </div>
                </div>

                <!-- Single Address Paragraph Textarea -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="paragraph" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Address Paragraph</label>
                        <span class="text-[11px] text-slate-400 font-medium">Use blank lines between paragraphs</span>
                    </div>
                    <textarea name="paragraph" id="paragraph" rows="8" class="w-full p-4 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors leading-relaxed font-sans" placeholder="Write the principal's address here...">{{ old('paragraph', $principal->paragraph) }}</textarea>
                </div>

                <!-- Highlight Quote Callout -->
                <div>
                    <label for="quote" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Highlight Quote (Red Callout)</label>
                    <textarea name="quote" id="quote" rows="2" class="w-full px-3.5 py-2.5 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors font-medium text-slate-800" placeholder="e.g. “At JRS, we don't just prepare students for the future—we empower them to shape it.”">{{ old('quote', $principal->quote) }}</textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 4: Sign-off & Stamp -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Sign-off</span>
                    <h3 class="font-bold text-jrs-navy font-heading text-base">Signature, Designation & Closing Note</h3>
                </div>
                <span class="text-xs text-slate-400">Footer Details</span>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="signoff_note" class="block text-xs font-semibold text-slate-600 mb-1">Closing Note</label>
                    <input type="text" name="signoff_note" id="signoff_note" value="{{ old('signoff_note', $principal->signoff_note) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. WARM REGARDS,">
                </div>

                <div>
                    <label for="signoff_signature" class="block text-xs font-semibold text-slate-600 mb-1">Signature Font Text</label>
                    <input type="text" name="signoff_signature" id="signoff_signature" value="{{ old('signoff_signature', $principal->signoff_signature) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. Marlene Mannas">
                </div>

                <div>
                    <label for="signoff_name" class="block text-xs font-semibold text-slate-600 mb-1">Sign-off Full Name</label>
                    <input type="text" name="signoff_name" id="signoff_name" value="{{ old('signoff_name', $principal->signoff_name) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. Mrs. Marlene Mannas">
                </div>

                <div>
                    <label for="signoff_sub" class="block text-xs font-semibold text-slate-600 mb-1">Sign-off Subtitle / Designation</label>
                    <input type="text" name="signoff_sub" id="signoff_sub" value="{{ old('signoff_sub', $principal->signoff_sub) }}" class="w-full px-3 py-1.5 rounded-lg text-xs border border-slate-200 bg-white" placeholder="e.g. Principal, JRS International School">
                </div>
            </div>
        </div>

        <!-- SECTION 5: Status & Submit -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $principal->is_active) ? 'checked' : '' }} class="w-4 h-4 text-jrs-red rounded border-slate-300 focus:ring-jrs-red">
                <label for="is_active" class="text-xs font-bold text-slate-700 cursor-pointer">
                    Publish this page actively on the React website
                </label>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.principal.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold border border-slate-300 text-slate-700 hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold bg-jrs-red hover:bg-red-700 text-white shadow-md shadow-red-600/20 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>

    </form>
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
