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
                <h4 class="heading-title">Game Times</h4>
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
                                    Game Times</a>
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
                            <th>Program</th>
                            <th>Status</th>
                            <th colspan="2" style="width: 200px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($programSlots as $i=>$con)
                        <tr>
                            <td>
                                <span class="sno">{{ $i + 1 }}</span>
                            </td>


                            <td>
                                {{ $con->program->name }}
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
                                            <input class="toggle__input" name="" onchange="toggleStatus(this)" data-update_url="{{ route('admin.programSlots.update', $con->id) }}" {{ $con->status ? 'checked' : '' }} type="checkbox" id="myToggle{{ $con->id }}">
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
                                    <button onclick="edit(this)" data-program_id="{{$con->program_id}}" data-custom_slots="{{$con->custom_slots}}" data-status="{{ $con->status }}" data-from_time="{{ $con->from_time }}" data-to_time="{{ $con->to_time }}" data-apply_time="{{ $con->apply_time }}" data-custom_slots="{{ $con->custom_slots }}" data-update_url="{{ route('admin.programSlots.update', $con->id) }}" data-bs-toggle="modal" data-bs-target="#editConferences" class="edit-btn">
                                        <img src="{{ asset('public/admin/images/edit-icon.svg') }}">
                                    </button>

                                    <button type="button" class="btn  btn-xs" onclick="deletePost({{ $con->id }})">
                                        <img src="{{ asset('public/admin/images/delete-icon.svg') }}">
                                        <form action="{{ route('admin.programSlots.destroy', $con->id) }}" method="POST" id="del-post-{{ $con->id }}" style="display:none;">
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
            {{ $programSlots->links() }}
        </div>
    </div>
</div>
<!-- add Programs -->
<div class="modal lm-modal fade" id="AddConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Add Game Times</h2>
                    <form action="{{ route('admin.programSlots.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
                        @csrf
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.programSlots.index') }}">

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
                                    <h3>Game Slots</h3>
                                    <input type="time" class="form-control" name="from_time">
                                    <div class="text-center">To</div>
                                    <input type="time" class="form-control" name="to_time">

                                </div>
                                <div class="d-flex justify-between">
                                    <span class="m-3"><input type="radio" name="apply_time" value="15" id="15"> <label for="15">Apply 15 Minues</label> </span>
                                    <span class="m-3"><input type="radio" name="apply_time" value="30" id="30"> <label for="30">Apply 30 Minues</label> </span>
                                    <span class="m-3"><input type="radio" name="apply_time" value="45" id="45"> <label for="45">Apply 45 Minues</label> </span>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <h3>Custom Time Slots</h3>
                                    <div class="d-flex justify-between">
                                        <span class="m-3"><input type="checkbox" name="custom_slots[]" value="8:00am" id="8"> <label for="8" class="px-4 px-2 bg-light rounded-pill">8:00 AM</label> </span>
                                        <span class="m-3"><input type="checkbox" name="custom_slots[]" value="8:30am" id="8-3"> <label for="8-3" class="px-4 px-2 bg-light rounded-pill">8:30 AM</label> </span>
                                        <span class="m-3"><input type="checkbox" name="custom_slots[]" value="9:30am" id="9"> <label for="9" class="px-4 px-2 bg-light rounded-pill">9:30 AM</label> </span>
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
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.programSlots.index') }}">

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
                                    <label>Game Times</label>
                                    <input type="time" class="form-control" id="edit-from_time" name="from_time">
                                    <div class="text-center">To</div>
                                    <input type="time" class="form-control" id="edit-to_time" name="to_time">

                                </div>
                                <div class="d-flex justify-between">
                                    <span class="m-3"><input type="radio" class="apply_time" name="apply_time" value="15" id="15"> <label for="15">15 Minues</label> </span>
                                    <span class="m-3"><input type="radio" class="apply_time" name="apply_time" value="30" id="30"> <label for="30">30 Minues</label> </span>
                                    <span class="m-3"><input type="radio" class="apply_time" name="apply_time" value="45" id="45"> <label for="45">45 Minues</label> </span>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <h3>Custom Time Slots</h3>
                                    <div class="d-flex justify-between">
                                        <span class="m-3"><input type="checkbox" class="custom_slots" name="custom_slots[]" value="8:00am" id="8"> <label for="8" class="px-4 px-2 bg-light rounded-pill">8:00 AM</label> </span>
                                        <span class="m-3"><input type="checkbox" class="custom_slots" name="custom_slots[]" value="8:30am" id="8-3"> <label for="8-3" class="px-4 px-2 bg-light rounded-pill">8:30 AM</label> </span>
                                        <span class="m-3"><input type="checkbox" class="custom_slots" name="custom_slots[]" value="9:30am" id="9"> <label for="9" class="px-4 px-2 bg-light rounded-pill">9:30 AM</label> </span>
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


        $("#edit-program_id").val(ele.getAttribute("data-program_id"));
        $("#edit-from_time").val(ele.getAttribute("data-from_time"));
        $("#edit-to_time").val(ele.getAttribute("data-to_time"));

        $(".apply_time").each(
            function() {
                if ($(this).attr("value") == ele.getAttribute("data-apply_time")) {
                    $(this).attr("checked", "true");
                }
            }
        );
        $(".custom_slots").each(
            function() {
                var custom_slots = ele.getAttribute("data-custom_slots").split(",");
                if (custom_slots.includes($(this).attr("value"))) {
                    $(this).attr("checked", "true");
                }
            }
        );




        if (parseInt(ele.getAttribute("data-status"))) {
            $("#edit-Active").attr("checked", "true");

        } else {
            $("#edit-Inactive").attr("checked", "true");

        }



        $("#edit-form").attr("action", ele.getAttribute("data-update_url"));

    }
</script>
@endpush