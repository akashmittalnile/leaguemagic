@extends('layouts.admin.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/setting.css') }}">
@endpush

@section('content')
@include('pages.admin.programs-menu')
<div class="user-table-section">
    <div class="heading-section">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h4 class="heading-title">Programs</h4>
            </div>
            <div class="p-2">
                <a class="btn search-icon add-new-btn mx-1 shadow" href="{{route('admin.programs.index','export=true')}}">Export programs</a>
            </div>
            <div class="btn-option-info wd50">
                <div class="search-filter">
                    <div class="row g-2">
                        <div class="col-md-7">
                            <div class="search-form-group">
                                <form class="d-flex">
                                    <input type="text" name="search" class="form-control" placeholder="Search programs by name or status">
                                    <button class="btn search-icon bg-light mx-1 shadow " type="submit"><img src="{{asset('public/admin/images/search-icon.svg')}}"></button>
                                    <a class="btn search-icon bg-light mx-1 shadow" href="{{route('admin.programs.index')}}"><img src="{{asset('public/admin/images/reset.png')}}" height="25"></a>

                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <a class="add-new-btn" data-bs-toggle="modal" data-bs-target="#AddConferences"> Add new
                                    Programs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lm-content-section">
        <div class="lm-table-card">
            <div class="table-responsive">
                <table class="table table-lm">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>

                            <th>Status</th>
                            <th colspan="2" style="width: 200px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($programs as $i=>$con)
                        <tr>
                            <td>
                                <span class="sno">{{ $i + 1 }}</span>
                            </td>


                            <td>
                                {{ $con->name }}
                            </td>

                            <td>
                                <div class="lm-status-text {{ $con->status ? 'st-active' : 'st-inactive' }}">
                                    {{ $con->status ? 'Active' : 'Inactive' }}
                                </div>
                            </td>


                            <td style="width: 200px;">
                                <div class="switch-toggle">
                                    <p>{{ $con->status ? 'Active' : 'Inactive' }}</p>
                                    <div class="">
                                        <label class="toggle" for="myToggle{{ $con->id }}">
                                            <input class="toggle__input" name="" onchange="toggleStatus(this)" data-update_url="{{ route('admin.programs.update', $con->id) }}" {{ $con->status ? 'checked' : '' }} type="checkbox" id="myToggle{{ $con->id }}">
                                            <div class="toggle__fill"></div>
                                        </label>
                                    </div>

                                </div>
                            </td>
                            <td style="width: 100px;">
                                <div class="table-action-info">
                                    <!-- <a data-bs-toggle="modal" data-bs-target="#view" class="view-btn">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <img src="{{ asset('public/admin/images/view-icon.svg') }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </a> -->
                                    <button onclick="edit(this)" data-name="{{ $con->name }}" data-season_id="{{ $con->season_id }}" data-sport_id="{{ $con->sport_id }}" data-league_age_date="{{ $con->league_age_date }}" data-program_fee="{{ $con->program_fee }}" data-participating_clubs="@foreach ($con->programClubs as $i => $item) {{ $item->club_id }} @if ($i < count($con->programClubs) - 1) , @endif @endforeach" data-jersey_fee="{{ $con->jersey_fee }}" data-status="{{ $con->status }}" data-update_url="{{ route('admin.programs.update', $con->id) }}" data-bs-toggle="modal" data-bs-target="#editConferences" class="edit-btn">
                                        <img src="{{ asset('public/admin/images/edit-icon.svg') }}">
                                    </button>

                                    <button type="button" class="btn  btn-xs" onclick="deletePost({{ $con->id }})">
                                        <img src="{{ asset('public/admin/images/delete-icon.svg') }}">
                                        <form action="{{ route('admin.programs.destroy', $con->id) }}" method="POST" id="del-post-{{ $con->id }}" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">No Records</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            {{ $programs->links() }}
        </div>
    </div>
</div>
<!-- add Programs -->
<div class="modal lm-modal fade" id="AddConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Add New Programs </h2>
                    <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
                        @csrf
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.programs.index') }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Program Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Type Here">
                                    <span class="form-msg-text">A Name That This Location Is Known By.</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Season</label>
                                    <select name="season_id" class="form-control">
                                        <option value="">--select--</option>
                                        @foreach ($seasons as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sports</label>
                                    <select name="sport_id" class="form-control">
                                        <option value="">--select--</option>
                                        @foreach ($sports as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>League Age Date</label>
                                    <input type="Date" name="league_age_date" class="form-control" placeholder="July 31 2022">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Program Fee</label>
                                    <input type="number" name="program_fee" class="form-control" placeholder="$0.00">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Program Jersey Fee</label>
                                    <input type="number" name="jersey_fee" class="form-control" placeholder="$0.00">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Participating Clubs</label>
                                    <!-- <input type="text" class="form-control" placeholder="Search Club By Name">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="tags-list">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="Tags-text">386 Cobras <img src="images/close-circle.svg"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="Tags-text">309 Duckz <img src="images/close-circle.svg"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="Tags-text">318 Rebals <img src="images/close-circle.svg"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div> -->
                                    <div class="w-100">
                                        <select name="participating_clubs[]" id="participating_clubs" class="form-control" multiple multiselect-search="true">

                                            @foreach ($clubs as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <ul class="lm-Status-list">
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" name="status" value="1" id="Active" name="Statustype">
                                                <label for="Active">
                                                    Active
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" name="status" value="0" id="Inactive" name="Statustype">
                                                <label for="Inactive">
                                                    Inactive
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="cancel-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="save-btn">Save & Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Edit Programs -->
<div class="modal lm-modal fade" id="editConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Edit Programs Details </h2>
                    <form method="POST" enctype="multipart/form-data" id="edit-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.programs.index') }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Program Name</label>
                                    <input type="text" name="name" id="edit-name" class="form-control" placeholder="Type Here">
                                    <span class="form-msg-text">A Name That This Location Is Known By.</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Season</label>
                                    <select name="season_id" id="edit-season_id" class="form-control">
                                        <option value="">--select--</option>
                                        @foreach ($seasons as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sports</label>
                                    <select name="sport_id" id="edit-sport_id" class="form-control">
                                        <option value="">--select--</option>
                                        @foreach ($sports as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>League Age Date</label>
                                    <input type="Date" name="league_age_date" id="edit-league_age_date" class="form-control" placeholder="July 31 2022">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Program Fee</label>
                                    <input type="number" name="program_fee" id="edit-program_fee" class="form-control" placeholder="$0.00">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Program Jersey Fee</label>
                                    <input type="number" name="jersey_fee" id="edit-jersey_fee" class="form-control" placeholder="$0.00">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Participating Clubs</label>
                                    <!-- <input type="text" class="form-control" placeholder="Search Club By Name">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="tags-list">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="Tags-text">386 Cobras <img src="images/close-circle.svg"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="Tags-text">309 Duckz <img src="images/close-circle.svg"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="Tags-text">318 Rebals <img src="images/close-circle.svg"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div> -->
                                    <div class="w-100">
                                        <select name="participating_clubs[]" id="edit-participating_clubs" class="form-control" multiple multiselect-search="true">
                                            @foreach ($clubs as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <ul class="lm-Status-list">
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" name="status" value="1" id="edit-Active" name="Statustype">
                                                <label for="edit-Active">
                                                    Active
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" name="status" value="0" id="edit-Inactive" name="Statustype">
                                                <label for="edit-Inactive">
                                                    Inactive
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="cancel-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="save-btn">Save & Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Delete Programs -->
<div class="modal lm-modal fade" id="deleteSeasons" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-content">
                    <div class="lm-modal-media">
                        <img src="asset('public/admin/images/delete.svg') ">
                    </div>
                    <h2>Are You Sure! Want To Delete <span id="name"></span> </h2>
                    <p>Confirm Delete Will Remove <span id="name"></span> From The System!</p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="cancel-btn" data-bs-dismiss="modal" aria-label="Close">No</button>

                                <button class="save-btn" type="submit">Confirm</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('public/admin/js/multiselect-dropdown.js') }}"></script>
<script>
    function deletePost(id) {
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                document.getElementById('del-post-' + id).submit();
                swal(
                    'Deleted!',
                    'List has been deleted.',
                    'success'
                )
            }
        })
    }

    function edit(ele) {

        $("#edit-name").val(ele.getAttribute("data-name"));
        $("#edit-season_id").val(ele.getAttribute("data-season_id"));
        $("#edit-sport_id").val(ele.getAttribute("data-sport_id"));
        $("#edit-jersey_fee").val(ele.getAttribute("data-jersey_fee"));
        $("#edit-program_fee").val(ele.getAttribute("data-program_fee"));
        $("#edit-league_age_date").val(ele.getAttribute("data-league_age_date"));


        $("#edit-participating_clubs").val(ele.getAttribute("data-participating_clubs").split(",").map(item => parseInt(
            item)));


        if (parseInt(ele.getAttribute("data-status"))) {
            $("#edit-Active").attr("checked", "true");

        } else {
            $("#edit-Inactive").attr("checked", "true");

        }



        $("#edit-form").attr("action", ele.getAttribute("data-update_url"));


    }
</script>
@endpush