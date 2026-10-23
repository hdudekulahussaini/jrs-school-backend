@extends('admin.layout')

@section('title', 'Campus Facilities')
@section('header', 'Campus Facilities & Infrastructure')

@section('content')
<div class="space-y-6">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add Facility Form -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-xs h-fit">
            <h3 class="text-base font-bold text-slate-900 font-heading mb-1">Add Facility</h3>
            <p class="text-xs text-slate-500 mb-4">Add a new campus amenity or lab to the infrastructure section</p>

            <form action="{{ route('admin.facilities.store') }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Facility Name *</label>
                    <input type="text" name="title" required placeholder="e.g., AI & Robotics Innovation Lab" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description *</label>
                    <textarea name="description" rows="3" required placeholder="Describe the infrastructure and benefits for students..." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Image URL / Path</label>
                    <input type="text" name="image_url" value="/images/campus-building.jpg" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Display Order</label>
                    <input type="number" name="sort_order" value="1" class="w-24 p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-jrs-red hover:bg-jrs-red-dark shadow-md shadow-red-600/30 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Save Facility</span>
                </button>
            </form>
        </div>

        <!-- Facilities List Cards -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900 font-heading">Campus Infrastructure Items ({{ $facilities->count() }})</h3>
                <span class="text-xs text-slate-500">Visible on homepage</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($facilities as $facility)
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-jrs-accent border border-blue-200">
                                    Order: {{ $facility->sort_order }}
                                </span>
                                <span class="text-xs font-bold {{ $facility->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                    {{ $facility->is_active ? '● Active' : '○ Hidden' }}
                                </span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-base font-heading">{{ $facility->title }}</h4>
                            <p class="text-xs text-slate-600 mt-2 leading-relaxed">{{ $facility->description }}</p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-end">
                            <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST" onsubmit="return confirm('Remove this facility?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-slate-400 hover:text-red-600 p-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 bg-white rounded-2xl p-8 text-center text-slate-500 border border-slate-200">
                        No facilities configured. Add one using the form on the left.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
