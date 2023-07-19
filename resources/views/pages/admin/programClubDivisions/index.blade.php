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
                <h4 class="heading-title">Team Divisions</h4>
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
                                    Team Divisions</a>
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
                        @forelse($programClubDivisions as $i=>$con)
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
                                            <input class="toggle__input" name="" _onchange="toggleStatus(this)" data-update_url="{{ route('admin.locations.update', $con->id) }}" {{ 1 ? 'checked' : '' }} type="checkbox" id="myToggle{{ $con->id }}">
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
                                    <button onclick="edit(this)" data-program_id="{{ $con->program_id }}" data-club_id="{{ $con->club_id }}" data-club_divisions="@foreach ($con->program->programClubDivisions as $i => $item) {{$item->description}}  @if ($i < count($con->program->programClubDivisions) - 1) , @endif @endforeach" data-update_url="{{ route('admin.programClubDivisions.update', $con->id) }}" data-bs-toggle="modal" data-bs-target="#editConferences" class="edit-btn">
                                        <img src="{{ asset('public/admin/images/edit-icon.svg') }}">
                                    </button>

                                    <button type="button" class="btn  btn-xs" onclick="deletePost({{ $con->id }})">
                                        <img src="{{ asset('public/admin/images/delete-icon.svg') }}">
                                        <form action="{{ route('admin.programClubDivisions.destroy', $con->id) }}" method="POST" id="del-post-{{ $con->id }}" style="display:none;">
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
            {{ $programClubDivisions->links() }}
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
                    <form action="{{ route('admin.programClubDivisions.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
                        @csrf
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.programClubDivisions.index') }}">

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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Club</label>
                                    <select name="club_id" class="form-control">
                                        <option value="">--select--</option>
                                        @foreach ($clubs as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>




                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Club Divisions</label>
                                    <div class="w-100">
                                        <select name="club_divisions[]" id="club_divisions" class="form-control" multiple multiselect-search="true">

                                            @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->name }} </option>

                                            @foreach ($levels as $level)
                                            <option value="{{ $division->id }}-{{ $level->id }}">{{ $division->name }} {{ $level->name }}</option>

                                            @foreach ($groups as $group)

                                            <option value="{{ $division->id }}-{{ $level->id }}-{{ $group->id }}">{{ $division->name }} {{ $level->name }} {{ $group->name }}</option>
                                            @endforeach
                                            @endforeach
                                            @endforeach


                                        </select>
                                    </div>
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
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.programClubDivisions.index') }}">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Program</label>
                                    <select name="program_id" id="edit-program_id" class="form-control">
                                        <option value="">--select--</option>
                                        @foreach ($programs as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Club</label>
                                    <select name="club_id" id="edit-club_id" class="form-control">
                                        <option value="">--select--</option>
                                        @foreach ($clubs as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>




                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Club Divisions</label>
                                    <div class="w-100">
                                        <select name="club_divisions[]" id="edit-club_divisions" class="form-control" multiselect-search="true">

                                            @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->name }} </option>

                                            @foreach ($levels as $level)
                                            <option value="{{ $division->id }}-{{ $level->id }}">{{ $division->name }} {{ $level->name }}</option>

                                            @foreach ($groups as $group)

                                            <option value="{{ $division->id }}-{{ $level->id }}-{{ $group->id }}">{{ $division->name }} {{ $level->name }} {{ $group->name }}</option>
                                            @endforeach
                                            @endforeach
                                            @endforeach



                                        </select>
                                    </div>
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

        $("#edit-program_id").val(ele.getAttribute("data-program_id"));
        $("#edit-club_id").val(ele.getAttribute("data-club_id"));
        $("#edit-club_divisions").attr("multiple", "true")
        $("#edit-club_divisions").val(ele.getAttribute("data-club_divisions").split(",").map(item => item.trim()));

        // console.log(ele.getAttribute("data-club_divisions").split(",").map(item => item.trim()));
        $("#edit-form").attr("action", ele.getAttribute("data-update_url"));
        MultiselectDropdown(window.MultiselectDropdownOptions);

    }
</script>
@endpush