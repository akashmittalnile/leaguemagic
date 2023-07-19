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
                <h4 class="heading-title">Game Dates</h4>
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
                                    Game Dates</a>
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
                            <th>Game</th>
                            <th>Status</th>
                            <th colspan="2" style="width: 200px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($programDates as $i=>$con)
                        <tr>
                            <td>
                                <span class="sno">{{ $i + 1 }}</span>
                            </td>


                            <td>
                                {{ $con->program->name }}
                            </td>

                            <td>
                                <div class="lm-status-text {{ 1 ? 'st-active' : 'st-inactive' }}">
                                    {{ 1 ? 'Active' : 'Inactive' }}
                                </div>
                            </td>


                            <td style="width: 200px;">
                                <div class="switch-toggle">
                                    <p>{{ 1 ? 'Active' : 'Inactive' }}</p>

                                    <div class="">
                                        <label class="toggle" for="myToggle{{ $con->id }}">
                                            <input class="toggle__input" name="" data-update_url="{{ route('admin.programDates.update', $con->id) }}" {{ 1 ? 'checked' : '' }} type="checkbox" id="myToggle{{ $con->id }}">
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
                                    <button onclick="edit(this)" data-program_id="{{$con->program_id}}" data-dates_regular="@foreach ($con->program->programDates as $i => $item) @if ($item->type=='regular') {{ $item->schedule_date }} @if ($i < count($con->program->programDates) - 1) , @endif @endif @endforeach" data-dates_playoff="@foreach ($con->program->programDates as $i => $item) @if ($item->type=='playoff') {{ $item->schedule_date }} @if ($i < count($con->program->programDates) - 1) , @endif @endif @endforeach" data-dates_competition="@foreach ($con->program->programDates as $i => $item) @if ($item->type=='competition') {{ $item->schedule_date }} @if ($i < count($con->program->programDates) - 1) , @endif @endif @endforeach" data-status="{{ $con->status }}" data-update_url="{{ route('admin.programDates.update', $con->id) }}" data-bs-toggle="modal" data-bs-target="#editConferences" class="edit-btn">
                                        <img src="{{ asset('public/admin/images/edit-icon.svg') }}">
                                    </button>

                                    <button type="button" class="btn  btn-xs" onclick="deletePost({{ $con->id }})">
                                        <img src="{{ asset('public/admin/images/delete-icon.svg') }}">
                                        <form action="{{ route('admin.programDates.destroy', $con->id) }}" method="POST" id="del-post-{{ $con->id }}" style="display:none;">
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
            {{ $programDates->links() }}
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
                    <form action="{{ route('admin.programDates.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
                        @csrf
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.programDates.index') }}">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Program</label>
                                    <select name="program_id" class="form-control">
                                        <option value="">--select--</option>
                                        @foreach ($programs as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>


                            <br>
                            <br>


                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p>Regular Season Game Dates</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <buttom class="btn btn-primary btn btn-sm" onclick="addRegularDates()"> Add Dates</buttom>
                                    </div>
                                </div>

                                <div class="form-group">


                                    <div class="row bg-light border-bottom m-1">
                                        <div class="col-2">
                                            <h6 class="font-bold p-0">Game</h6>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="font-bold p-0">Game Date</h6>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="font-bold p-0">Status</h6>
                                        </div>
                                    </div>
                                    <div id="regular_dates_container">
                                        <div class="row border-bottom my-1">
                                            <div class="col-2">
                                                <span class="bg-light rounded p-1">1</span>
                                            </div>
                                            <div class="col-6">
                                                <input type="date" class="form-control" name="game_dates1">
                                                <input type="hidden" value="regular" class="form-control" name="type1">
                                            </div>
                                            <div class="col-4">
                                                <div class="switch-toggle bg-light rounded p-1">
                                                    <p class="p-1">Active</p>
                                                    <label class="toggle" for="resuglarToggle1">
                                                        <input class="toggle__input" name="status1" checked type="checkbox" id="resuglarToggle1">
                                                        <div class="toggle__fill"></div>
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <br>
                            <br><br>
                            <br><br>
                            <br><br>
                            <br>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p>Playoffs Season Game Dates</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <buttom class="btn btn-primary btn btn-sm" onclick="addPlayoffDates()"> Add Dates</buttom>
                                    </div>
                                </div>

                                <div class="form-group">


                                    <div class="row bg-light border-bottom m-1">
                                        <div class="col-2">
                                            <h6 class="font-bold p-0">Game</h6>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="font-bold p-0">Game Date</h6>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="font-bold p-0">Status</h6>
                                        </div>
                                    </div>
                                    <div id="playoff_dates_container">
                                        <div class="row border-bottom my-1">
                                            <div class="col-2">
                                                <span class="bg-light rounded p-1">1</span>
                                            </div>
                                            <div class="col-6">
                                                <input type="date" class="form-control" name="game_dates2">
                                                <input type="hidden" value="playoff" class="form-control" name="type2">
                                            </div>
                                            <div class="col-4">
                                                <div class="switch-toggle bg-light rounded p-1">
                                                    <p class="p-1">Active</p>
                                                    <label class="toggle" for="resuglarToggle1">
                                                        <input class="toggle__input" name="status2" checked type="checkbox" id="resuglarToggle1">
                                                        <div class="toggle__fill"></div>
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <br>
                            <br><br>
                            <br><br>
                            <br><br>
                            <br>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p>Competition Season Game Dates</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <buttom class="btn btn-primary btn btn-sm" onclick="addCompetitionDates()"> Add Dates</buttom>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row bg-light border-bottom m-1">
                                        <div class="col-2">
                                            <h6 class="font-bold p-0">Game</h6>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="font-bold p-0">Game Date</h6>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="font-bold p-0">Status</h6>
                                        </div>
                                    </div>
                                    <div id="competition_dates_container">
                                        <div class="row border-bottom my-1">
                                            <div class="col-2">
                                                <span class="bg-light rounded p-1">1</span>
                                            </div>
                                            <div class="col-6">
                                                <input type="date" class="form-control" name="game_dates3">
                                                <input type="hidden" value="competition" class="form-control" name="type3">
                                            </div>
                                            <div class="col-4">
                                                <div class="switch-toggle bg-light rounded p-1">
                                                    <p class="p-1">Active</p>
                                                    <label class="toggle" for="resuglarToggle1">
                                                        <input class="toggle__input" name="status3" checked type="checkbox" id="resuglarToggle1">
                                                        <div class="toggle__fill"></div>
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <input type="text" value="3" name="dates_count" style="opacity: 0;">
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
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.programDates.index') }}">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Programs</label>
                                    <select name="program_id" id="edit-program_id" class="form-control">
                                        <option value="">--select--</option>
                                        @foreach ($programs as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p>Regular Season Game Dates</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <buttom class="btn btn-primary btn btn-sm" onclick="addRegularDates()"> Add Dates</buttom>
                                    </div>
                                </div>

                                <div class="form-group">


                                    <div class="row bg-light border-bottom m-1">
                                        <div class="col-2">
                                            <h6 class="font-bold p-0">Game</h6>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="font-bold p-0">Game Date</h6>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="font-bold p-0">Status</h6>
                                        </div>
                                    </div>
                                    <div id="edit_regular_dates_container">

                                    </div>

                                </div>
                            </div>
                            <br>
                            <br><br>
                            <br><br>
                            <br><br>
                            <br>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p>Playoffs Season Game Dates</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <buttom class="btn btn-primary btn btn-sm" onclick="addPlayoffDates()"> Add Dates</buttom>
                                    </div>
                                </div>

                                <div class="form-group">


                                    <div class="row bg-light border-bottom m-1">
                                        <div class="col-2">
                                            <h6 class="font-bold p-0">Game</h6>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="font-bold p-0">Game Date</h6>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="font-bold p-0">Status</h6>
                                        </div>
                                    </div>
                                    <div id="edit_playoff_dates_container">

                                    </div>

                                </div>
                            </div>
                            <br>
                            <br><br>
                            <br><br>
                            <br><br>
                            <br>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p>Competition Season Game Dates</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <buttom class="btn btn-primary btn btn-sm" onclick="addCompetitionDates()"> Add Dates</buttom>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row bg-light border-bottom m-1">
                                        <div class="col-2">
                                            <h6 class="font-bold p-0">Game</h6>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="font-bold p-0">Game Date</h6>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="font-bold p-0">Status</h6>
                                        </div>
                                    </div>
                                    <div id="edit_competition_dates_container">

                                    </div>

                                </div>
                            </div>



                            <input type="text" value="3" id="edit-dates_count" name="dates_count" style="opacity: 0;">

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
        $("#edit-program_id").val(ele.getAttribute("data-program_id"));
        $("#edit-sport_id").val(ele.getAttribute("data-sport_id"));
        $("#edit-jersey_fee").val(ele.getAttribute("data-jersey_fee"));
        $("#edit-program_fee").val(ele.getAttribute("data-program_fee"));
        $("#edit-league_age_date").val(ele.getAttribute("data-league_age_date"));

        var edit_count = 1;
        var edit_playoff = 1;
        var edit_regular = 1;
        var edit_competition = 1;

        var regular_dates = ele.getAttribute("data-dates_regular").split(",").map(ele => ele.trim()).filter(ele => ele !== "");
        var playoff_dates = ele.getAttribute("data-dates_playoff").split(",").map(ele => ele.trim()).filter(ele => ele !== "");
        var competition_dates = ele.getAttribute("data-dates_competition").split(",").map(ele => ele.trim()).filter(ele => ele !== "");
        console.log(regular_dates);
        for (var i = 0; i < regular_dates.length; i++) {
            var type = "regular";
            var date = regular_dates[i].split(" ")[0];
            var html = `<div class="row border-bottom my-1">
                            <div class="col-2">
                                <span class="bg-light rounded p-1">${edit_regular}</span>
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" value="${date}" name="game_dates${edit_count}">
                                <input type="hidden" value="${type}" class="form-control" name="type${edit_count}">
                            </div>
                            <div class="col-4">
                                <div class="switch-toggle bg-light rounded p-1">
                                    <p class="p-1">Active</p>
                                    <label class="toggle" for="resuglarToggle${edit_count}">
                                        <input class="toggle__input" name="status${edit_count}" checked type="checkbox" id="resuglarToggle${edit_count+1}">
                                        <div class="toggle__fill"></div>
                                    </label>

                                </div>
                            </div>
                        </div>`;
            $(`#edit_${type}_dates_container`).html($(`#edit_${type}_dates_container`).html() + html)
            edit_count += 1;
            edit_regular += 1;
            $("#edit-dates_count").val(edit_count);
        }
        for (var i = 0; i < playoff_dates.length; i++) {
            var type = "playoff";
            var date = playoff_dates[i].split(" ")[0];
            var html = `<div class="row border-bottom my-1">
                            <div class="col-2">
                                <span class="bg-light rounded p-1">${edit_playoff}</span>
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" value="${date}" name="game_dates${edit_count}">
                                <input type="hidden" value="${type}" class="form-control" name="type${edit_count}">
                            </div>
                            <div class="col-4">
                                <div class="switch-toggle bg-light rounded p-1">
                                    <p class="p-1">Active</p>
                                    <label class="toggle" for="resuglarToggle${edit_count}">
                                        <input class="toggle__input" name="status${edit_count}" checked type="checkbox" id="resuglarToggle${edit_count+1}">
                                        <div class="toggle__fill"></div>
                                    </label>

                                </div>
                            </div>
                        </div>`;
            $(`#edit_${type}_dates_container`).html($(`#edit_${type}_dates_container`).html() + html)
            edit_count += 1;
            edit_playoff += 1;
            $("#edit-dates_count").val(edit_count);
        }
        for (var i = 0; i < competition_dates.length; i++) {
            var type = "competition";
            var date = competition_dates[i].split(" ")[0];
            var html = `<div class="row border-bottom my-1">
                            <div class="col-2">
                                <span class="bg-light rounded p-1">${edit_competition}</span>
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" value="${date}" name="game_dates${edit_count}">
                                <input type="hidden" value="${type}" class="form-control" name="type${edit_count}">
                            </div>
                            <div class="col-4">
                                <div class="switch-toggle bg-light rounded p-1">
                                    <p class="p-1">Active</p>
                                    <label class="toggle" for="resuglarToggle${edit_count}">
                                        <input class="toggle__input" name="status${edit_count}" checked type="checkbox" id="resuglarToggle${edit_count+1}">
                                        <div class="toggle__fill"></div>
                                    </label>

                                </div>
                            </div>
                        </div>`;
            $(`#edit_${type}_dates_container`).html($(`#edit_${type}_dates_container`).html() + html)
            edit_count += 1;
            edit_competition += 1;
            $("#edit-dates_count").val(edit_count);
        }



        $("#edit-form").attr("action", ele.getAttribute("data-update_url"));

    }
    var count = 3;
    var regular = 1;
    var playoff = 1;
    var competition = 1;


    function addRegularDates() {

        var html = `<div class="row border-bottom my-1">
                                            <div class="col-2">
                                                <span class="bg-light rounded p-1">${regular+1}</span>
                                            </div>
                                            <div class="col-6">
                                                <input type="date" class="form-control" name="game_dates${count+1}">
                                                <input type="hidden" value="regular" class="form-control" name="type${count+1}">
                                            </div>
                                            <div class="col-4">
                                                <div class="switch-toggle bg-light rounded p-1">
                                                    <p class="p-1">Active</p>
                                                    <label class="toggle" for="resuglarToggle${count+1}">
                                                        <input class="toggle__input" name="status${count+1}" checked type="checkbox" id="resuglarToggle${count+1}">
                                                        <div class="toggle__fill"></div>
                                                    </label>

                                                </div>
                                            </div>
                                        </div>`;
        $("#regular_dates_container").html($("#regular_dates_container").html() + html)
        count += 1;

        regular += 1;
        $("input[name=dates_count]").val(count);
    }

    function addPlayoffDates() {

        var html = `<div class="row border-bottom my-1">
                                    <div class="col-2">
                                        <span class="bg-light rounded p-1">${playoff+1}</span>
                                    </div>
                                    <div class="col-6">
                                        <input type="date" class="form-control" name="game_dates${count+1}">
                                        <input type="hidden" value="playoff" class="form-control" name="type${count+1}">
                                    </div>
                                    <div class="col-4">
                                        <div class="switch-toggle bg-light rounded p-1">
                                            <p class="p-1">Active</p>
                                            <label class="toggle" for="resuglarToggle${count+1}">
                                                <input class="toggle__input" name="status${count+1}" checked type="checkbox" id="resuglarToggle${count+1}">
                                                <div class="toggle__fill"></div>
                                            </label>

                                        </div>
                                    </div>
                                </div>`;
        $("#playoff_dates_container").html($("#playoff_dates_container").html() + html)
        count += 1;

        playoff += 1;
        $("input[name=dates_count]").val(count);
    }

    function addCompetitionDates() {

        var html = `<div class="row border-bottom my-1">
                            <div class="col-2">
                                <span class="bg-light rounded p-1">${competition+1}</span>
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" name="game_dates${count+1}">
                                <input type="hidden" value="competition" class="form-control" name="type${count+1}">
                            </div>
                            <div class="col-4">
                                <div class="switch-toggle bg-light rounded p-1">
                                    <p class="p-1">Active</p>
                                    <label class="toggle" for="resuglarToggle${count+1}">
                                        <input class="toggle__input" name="status${count+1}" checked type="checkbox" id="resuglarToggle${count+1}">
                                        <div class="toggle__fill"></div>
                                    </label>

                                </div>
                            </div>
                        </div>`;
        $("#competition_dates_container").html($("#competition_dates_container").html() + html)
        count += 1;

        competition += 1;
        $("input[name=dates_count]").val(count);
    }
</script>
@endpush