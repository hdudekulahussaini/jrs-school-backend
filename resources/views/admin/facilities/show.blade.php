@php
    header('Location: ' . route('admin.facilities.edit', $facility->id ?? request()->route('facility')));
    exit;
@endphp
