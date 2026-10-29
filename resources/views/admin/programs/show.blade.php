@php
    header('Location: ' . route('admin.programs.edit', $program->id ?? request()->route('program')));
    exit;
@endphp
