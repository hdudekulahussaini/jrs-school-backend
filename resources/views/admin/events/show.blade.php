@php
    header('Location: ' . route('admin.events.edit', $event->id ?? request()->route('event')));
    exit;
@endphp
