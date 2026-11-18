@extends('admin.layout')

@section('title', 'Admission Popup')
@section('header', 'Admission Popup')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-bold text-jrs-navy">Admission Popup</h1>
                @if($popup && $popup->is_active)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Active on Website
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        Inactive / Hidden
                    </span>
                @endif
            </div>
            <p class="text-xs text-slate-500 mt-1">Upload and manage the promotional Admission popup image displayed to website visitors.</p>
        </div>

        <div class="flex items-center gap-2">
            <form action="{{ route('admin.admission-popup.toggle') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ ($popup && $popup->is_active) ? 'bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs' }}">
                    <i class="bi bi-power text-sm"></i>
                    <span>{{ ($popup && $popup->is_active) ? 'Disable Popup' : 'Enable Popup' }}</span>
                </button>
            </form>
        </div>
    </div>

    <!-- FORM SETTINGS CARD -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden max-w-4xl">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/70">
            <h2 class="text-sm font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-2">
                <i class="bi bi-image text-jrs-red"></i>
                <span>Popup Image Settings</span>
            </h2>
        </div>

        <form action="{{ route('admin.admission-popup.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- VISIBILITY TOGGLE -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                <div>
                    <label for="is_active" class="text-sm font-bold text-slate-800 cursor-pointer">Enable Popup on Website</label>
                    <p class="text-xs text-slate-500 mt-0.5">When enabled, visitors will see this popup dialog on the frontend.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $popup->is_active ?? true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <!-- OPTIONAL IMAGE UPLOAD -->
            <div class="space-y-4">
                <div>
                    <label for="image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Upload Popup Image <span class="text-slate-400 font-normal lowercase">(optional)</span>
                    </label>
                    <input type="file" name="image" id="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border border-slate-200 rounded-xl p-2 cursor-pointer">
                    <span class="text-[11px] text-slate-400 mt-1.5 block">Supported: JPG, PNG, WEBP, GIF. Max: 5MB.</span>
                    @error('image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- OR IMAGE URL -->
                <div>
                    <label for="image_path" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Or Image URL / Path <span class="text-slate-400 font-normal lowercase">(optional)</span>
                    </label>
                    <input type="text" name="image_path" id="image_path" value="{{ old('image_path', $popup->image_path ?? '') }}" placeholder="e.g. https://... or uploads/admission-popup/example.jpg" class="w-full px-3.5 py-2.5 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                    @error('image_path') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                @if(!empty($popup->image_path))
                    <!-- CURRENT IMAGE PREVIEW & REMOVAL OPTION -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <div class="flex items-start gap-4">
                            <div class="w-24 h-24 rounded-lg overflow-hidden border border-slate-200 shrink-0 bg-white">
                                <img src="{{ str_starts_with($popup->image_path, 'http') ? $popup->image_path : asset($popup->image_path) }}" alt="Current Popup Image" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-xs font-bold text-slate-800">Current Image</h4>
                                <p class="text-[11px] text-slate-500 break-all mt-0.5">{{ $popup->image_path }}</p>
                                <label class="inline-flex items-center gap-2 mt-3 cursor-pointer">
                                    <input type="checkbox" name="remove_image" value="1" class="rounded text-red-600 focus:ring-red-500 border-slate-300">
                                    <span class="text-xs text-red-600 font-semibold hover:underline">Remove / Delete Current Image</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- SAVE BUTTON -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-jrs-red/20">
                    <i class="bi bi-check2-circle text-sm"></i>
                    <span>Save Popup Settings</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
