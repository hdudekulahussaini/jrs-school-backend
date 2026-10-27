@extends('admin.layout')

@section('content')
<script>window.location.href = "{{ route('admin.breadcrumb-banners.edit', $banner->id) }}";</script>
@endsection
