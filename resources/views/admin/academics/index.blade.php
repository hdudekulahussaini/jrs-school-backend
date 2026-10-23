@extends('admin.layout')

@section('title', 'Academic Programmes')
@section('header', 'Academic Programmes (Stages 01, 02, 03)')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-slate-900 font-heading">Shaping Inquiring Minds at Every Stage</h3>
            <p class="text-xs text-slate-500 mt-0.5">Manage the academic divisions showcased on the homepage (Curriculum, features, grade levels)</p>
        </div>
        <span class="px-3 py-1 bg-red-50 text-jrs-red rounded-full text-xs font-bold border border-red-100">
            CBSE Progressive Syllabus
        </span>
    </div>

    <!-- Academic Stages Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @forelse($stages as $stage)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="p-5 sm:p-6">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-jrs-red bg-red-50 border border-red-200 mb-3">
                        <span>{{ $stage->stage_number }}</span>
                    </div>
                    <h4 class="text-xl font-extrabold text-jrs-navy font-heading">{{ $stage->title }}</h4>
                    <p class="text-xs font-bold text-jrs-red uppercase tracking-wider mt-0.5">{{ $stage->subtitle }}</p>
                    
                    <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed">
                        {{ $stage->description }}
                    </p>

                    <div class="mt-4 pt-3 border-t border-slate-100 space-y-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Key Learning Highlights:</span>
                        @if(is_array($stage->key_features))
                            @foreach($stage->key_features as $feature)
                                <div class="flex items-start gap-2 text-xs text-slate-700 font-medium">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $feature }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-medium">Order: <strong>{{ $stage->sort_order }}</strong></span>

                    <button onclick="openEditModal({{ $stage->id }}, '{{ addslashes($stage->stage_number) }}', '{{ addslashes($stage->title) }}', '{{ addslashes($stage->subtitle ?? '') }}', '{{ addslashes($stage->description) }}', '{{ addslashes(implode("\n", $stage->key_features ?? [])) }}', '{{ $stage->sort_order }}')" class="px-3 py-1.5 text-xs font-bold text-white bg-jrs-navy hover:bg-jrs-navy-dark rounded-lg transition-colors">
                        Edit Stage
                    </button>
                </div>
            </div>
        @empty
            <div class="lg:col-span-3 bg-white rounded-2xl p-8 text-center text-slate-500 border border-slate-200">
                No academic stages configured. Click "Seed Demo Data" on the top right to populate default stages.
            </div>
        @endforelse
    </div>

</div>

<!-- Edit Stage Modal -->
<div id="editModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 font-heading mb-1" id="modalStageTitle">Edit Academic Stage</h3>
        <p class="text-xs text-slate-500 mb-4">Update the curriculum description and key learning points</p>

        <form id="editStageForm" method="POST" action="" class="space-y-3">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Stage Number Tag</label>
                <input type="text" name="stage_number" id="inputStageNumber" required class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Title</label>
                    <input type="text" name="title" id="inputTitle" required class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Subtitle / Grades</label>
                    <input type="text" name="subtitle" id="inputSubtitle" class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Overview Description</label>
                <textarea name="description" id="inputDescription" rows="3" required class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Key Learning Highlights (One per line)</label>
                <textarea name="key_features_text" id="inputFeaturesText" rows="4" required class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm" placeholder="Phonics-based English language..."></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" id="inputSortOrder" class="w-24 p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-jrs-red hover:bg-jrs-red-dark rounded-xl shadow-md">
                    Update Stage
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, stageNumber, title, subtitle, desc, features, sortOrder) {
        document.getElementById('modalStageTitle').textContent = 'Edit Stage: ' + title;
        document.getElementById('inputStageNumber').value = stageNumber;
        document.getElementById('inputTitle').value = title;
        document.getElementById('inputSubtitle').value = subtitle;
        document.getElementById('inputDescription').value = desc;
        document.getElementById('inputFeaturesText').value = features;
        document.getElementById('inputSortOrder').value = sortOrder;
        document.getElementById('editStageForm').action = '/admin/academics/' + id;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
