@extends('layouts.admin.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/setting.css') }}">
@endpush

@section('content')
@include('pages.admin.users-menu')
<div class="user-table-section">
    <div class="heading-section">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h4 class="heading-title">Users Account</h4>
            </div>

            <div class="btn-option-info wd50">
                <div class="search-filter">
                    <div class="row g-2">
                        <div class="col-md-7">
                            <div class="search-form-group">
                                <form class="d-flex">
                                    <input type="text" name="search" class="form-control" placeholder="Search users by name or status">
                                    <button class="btn search-icon bg-light mx-1 shadow " type="submit"><img src="{{ asset('public/admin/images/search-icon.svg') }}"></button>
                                    <a class="btn search-icon bg-light mx-1 shadow" href="{{ route('admin.users.index') }}"><img src="{{ asset('public/admin/images/reset.png') }}" height="25"></a>

                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <a class="btn search-icon add-new-btn mx-1 shadow" href="{{ route('admin.users.reject') }}">Rejected User Account</a>
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
                            <th>UserName</th>

                            <th>Name</th>

                            <th>Status</th>
                            <th colspan="2" style="width: 200px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $i=>$con)
                        <tr>
                            <td>
                                <span class="sno">{{ $i + 1 }}</span>
                            </td>
                            <td>
                                {{ $con->username }}
                            </td>


                            <td>
                                @if ($con->first_name != '')
                                {{ $con->first_name . ' ' . $con->last_name }}
                                @else
                                {{ $con->name }}
                                @endif
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
                                            <input class="toggle__input" name="" onchange="toggleStatus(this)" data-update_url="{{ route('admin.users.update', $con->id) }}" {{ $con->status ? 'checked' : '' }} type="checkbox" id="myToggle{{ $con->id }}">
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
                                    <button onclick="edit(this)" data-first_name="{{ $con->name ? $con->name : $con->first_name }}" \ data-last_name="{{ $con->name ? '' : $con->last_name }}" data-email="{{ $con->email }}" data-contact_number="{{ $con->contact_number }}" data-city="{{ $con->city }}" data-state_id="{{ $con->state_id }}" data-address_line1="{{ $con->address_line1 }}" data-address_line2="{{ $con->address_line2 }}" data-zipcode="{{ $con->zipcode }}" data-position_id="{{ $con->position_id }}" data-isActive="{{ $con->isActive }}" data-update_url="{{ route('admin.users.update', $con->id) }}" data-bs-toggle="modal" data-bs-target="#editConferences" class="edit-btn">
                                        <img src="{{ asset('public/admin/images/edit-icon.svg') }}">
                                    </button>

                                    <button type="button" class="btn  btn-xs" onclick="deletePost({{ $con->id }})">
                                        <img src="{{ asset('public/admin/images/delete-icon.svg') }}">
                                        <form action="{{ route('admin.users.destroy', $con->id) }}" method="POST" id="del-post-{{ $con->id }}" style="display:none;">
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
            {{ $users->links() }}
        </div>
    </div>
</div>






<!-- Edit Users -->
<div class="modal lm-modal fade" id="editConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Edit Admin Details </h2>
                    <form method="POST" enctype="multipart/form-data" id="edit-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.users.pending') }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> First Name</label>
                                            <input type="text" class="form-control" name="first_name" id="edit-first_name" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" name="last_name" id="edit-last_name" placeholder="Last Name">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <div class="row">
                                        <div class="col-sm-12 p-2">
                                            <input type="text" class="form-control" name="address_line1" id="edit-address_line1" placeholder="Address Line 1">
                                        </div>
                                        <div class="col-sm-12 p-2">
                                            <input type="text" class="form-control" name="address_line2" id="edit-address_line2" placeholder="Address Line 2">
                                        </div>

                                        <div class="col-sm-6 p-2">
                                            <input type="text" class="form-control" name="city" id="edit-city" placeholder="city">
                                        </div>


                                        <div class="col-sm-6 p-2">
                                            <select name="state_id" class="form-control" id="edit-state_id">
                                                <option value="">Select a state</option>
                                                @foreach ($states as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-sm-6 p-2">
                                            <input type="number" class="form-control" name="zipcode" id="edit-zipcode" placeholder="zipcode">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" id="edit-email" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="contact_number" id="edit-contact_number" placeholder="Phone">
                                </div>
                            </div>

                            <div class="col-sm-12 ">
                                <div class="form-group">
                                    <label>Position</label>
                                    <select name="position_id" id="edit-position_id" class="form-control">

                                        <option value="">Select a position</option>
                                        @foreach ($positions as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <ul class="lm-Status-list">
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="active" checked id="edit-Approve" name="isActive">
                                                <label for="edit-Approve">
                                                    Approve
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="reject" id="edit-Reject" name="isActive">
                                                <label for="edit-Reject">
                                                    Reject
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="cancel-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="save-btn" type="submit">Save & Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Delete Users -->
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

        $("#edit-first_name").val(ele.getAttribute("data-first_name"));
        $("#edit-last_name").val(ele.getAttribute("data-last_name"));
        $("#edit-city").val(ele.getAttribute("data-city"));
        $("#edit-state_id").val(ele.getAttribute("data-state_id"));
        $("#edit-email").val(ele.getAttribute("data-email"));
        $("#edit-contact_number").val(ele.getAttribute("data-contact_number"));
        $("#edit-address_line1").val(ele.getAttribute("data-address_line1"));
        $("#edit-address_line2").val(ele.getAttribute("data-address_line2"));
        $("#edit-zipcode").val(ele.getAttribute("data-zipcode"));
        $("#edit-position_id").val(ele.getAttribute("data-position_id"));



        if (ele.getAttribute("data-isActive") == "rejected") {
            $("#edit-Active").attr("checked", "true");
        } else {
            $("#edit-Inactive").attr("checked", "true");
        }

        $("#edit-form").attr("action", ele.getAttribute("data-update_url"));

    }

    function CheckPassword(ele) {
        if (ele.checked) {
            $("#passchange").show();

        } else {
            $("#passchange").hide();

        }
    }
</script>
@endpush