@php
    header('Location: ' . route('admin.tickers.edit', $ticker->id ?? request()->route('ticker')));
    exit;
@endphp
