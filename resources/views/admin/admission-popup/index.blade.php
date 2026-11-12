@extends('admin.layout')

@section('title', 'Admission Popup Image')
@section('header', 'Admission Popup Image')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
        <h2 class="text-lg font-bold text-jrs-navy">Admission Popup Image</h2>
        <p class="mt-1 text-sm text-slate-500">Upload the image displayed in the admission popup.</p>

        @if($popup?->image_full_url)
            <div class="mt-6">
                <img src="{{ $popup->image_full_url }}" alt="Current admission popup" class="mx-auto max-h-[480px] max-w-full rounded-xl border border-slate-200 object-contain">
            </div>
        @else
            <p class="mt-6 rounded-xl bg-slate-50 p-6 text-center text-sm text-slate-500">No popup image has been uploaded.</p>
        @endif

        <form action="{{ route('admin.admission-popup.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-3">
            @csrf
            <label for="image" class="block text-sm font-semibold text-slate-700">Image Upload</label>
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp" required class="block w-full rounded-xl border border-slate-200 p-2 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-slate-700">
            <p class="text-xs text-slate-500">JPEG, PNG, or WebP; maximum size 5 MB.</p>
            @error('image')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
            <button type="submit" class="inline-flex items-center rounded-xl bg-jrs-red px-4 py-2.5 text-sm font-bold text-white hover:bg-red-700">
                {{ $popup?->image_path ? 'Update Image' : 'Upload Image' }}
            </button>
        </form>

        @if($popup?->image_path)
            <form action="{{ route('admin.admission-popup.image.destroy') }}" method="POST" class="mt-3" onsubmit="return confirm('Delete the admission popup image?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-xl border border-red-200 px-4 py-2.5 text-sm font-semibold text-red-700 hover:bg-red-50">Delete Image</button>
            </form>
        @endif
    </div>
</div>
@endsection
