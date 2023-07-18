@extends('layouts.admin.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/setting.css') }}">
@endpush

@section('content')
<div class="" id="content-body">
    @include('pages.admin.setting-menu')


</div>
@endsection