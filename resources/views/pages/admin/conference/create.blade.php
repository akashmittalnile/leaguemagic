@extends('layouts.admin.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/setting.css') }}">
@endpush

@section('content')
<div class="" id="content-body">
    <div class="body-content-heading">
        <h3>Settings</h3>
    </div>

    <div class="container-fluid p-0 mt-3 mb-3" data-aos="fade-up">
        @include('pages.admin.setting-menu')
    </div>

    <div class="body-content-heading d-flex justify-content-between align-items-center">
        <h3>Create Conferences</h3>
    </div>
    <div class="listing-table mt-4">
        <form action="{{route('admin.conference.store')}}" method="POST" enctype="multipart/form-data" id="create-form">
            @csrf
            <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.conference.index') }}">
            <div class="row">
                <div class="col-lg-8 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group form-float col-md-12">
                                    <div class="form-line">
                                        <label class="form-label">Conference Title</label>
                                        <input type="text" name="title" class="form-control" value="{{old('title')}}">
                                    </div>
                                </div>

                                <div class="form-group form-float col-md-12">
                                    <div class="form-line">
                                        <label class="form-label">Conference Name</label>
                                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                                    </div>
                                </div>

                                <div class="form-group form-float col-md-12">
                                    <div class="form-line">
                                        <label class="form-label">Conference Sort Order</label>
                                        <input type="number" name="sort_order" class="form-control" value="{{old('sort_order')}}">
                                    </div>
                                </div>

                                <div class="form-group form-float col-md-12">
                                    <div class="form-line">
                                        <label class="form-label">Status</label>
                                    </div>
                                </div>
                                <div class="form-group form-float col-md-12">
                                    <div class="form-line">
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="1" checked>Active
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="2">Inactive
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card card-danger">
                                <div class="card-body">
                                    <a href="{{route('admin.conference.index')}}" class="btn btn-danger btn-md">
                                        <span>BACK</span>
                                    </a>

                                    <button type="submit" class="btn btn-dark btn-md add-btn add-podcast-btn">
                                        <span>SAVE</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection