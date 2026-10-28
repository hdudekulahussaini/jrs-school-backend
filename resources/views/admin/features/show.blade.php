@php
    header('Location: ' . route('admin.features.edit', $feature->id ?? request()->route('feature')));
    exit;
@endphp
