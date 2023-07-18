@extends('layouts.admin.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/setting.css') }}">
<style>
    .loading {
        color: transparent;
        background: linear-gradient(100deg, #eceff1 30%, #f6f7f8 50%, #eceff1 70%);
        background-size: 400%;
        animation: loading 1.2s ease-in-out infinite;
    }

    @keyframes loading {
        0% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0 50%;
        }
    }

    .input_radio_box {
        background-color: #fff;
        border: 2px solid darkblue;
        color: darkblue;
        font-size: 13px;
        font-weight: 700;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    .input_radio_box.active {
        background-color: darkblue;
        color: #fff;
    }

    .input_radio_box.active input[type='radio'] {
        accent-color: green;
    }

    .containers {
        display: none;
    }



    .form-group label {
        color: black;
        font-weight: 600;
    }

    .lm-radio {
        border: 2px solid darkblue;
        padding: 8px;
        border-radius: 5px;

    }
</style>
@endpush

@section('content')
@include('pages.admin.users-menu')
<div class="user-table-section">
    <div class="heading-section">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h4 class="heading-title">Users Access</h4>
            </div>

            <div class="btn-option-info wd50">
                <div class="search-filter">
                    <div class="row g-2">
                        <div class="col-md-7">
                            <div class="search-form-group">
                                <form class="d-flex">
                                    <input type="text" name="search" class="form-control" placeholder="Search users by name or status">
                                    <button class="btn search-icon bg-light mx-1 shadow " type="submit"><img src="{{ asset('public/admin/images/search-icon.svg') }}"></button>
                                    <a class="btn search-icon bg-light mx-1 shadow" href="{{ route('admin.userAccess.index') }}"><img src="{{ asset('public/admin/images/reset.png') }}" height="25"></a>

                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <!-- <div class="form-group">
                                <a class="add-new-btn" data-bs-toggle="modal" data-bs-target="#AddConferences"> Add new
                                    User</a>
                            </div> -->
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
                                @if ($con->first_name!="")
                                {{ $con->first_name." ".$con->last_name }}
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
                                    <button onclick="edit(this)" data-update_url="{{ route('admin.userAccess.update', $con->id) }}" data-edit_url="{{ route('admin.userAccess.edit', $con->id) }}" data-first_name="{{$con->first_name}}" data-bs-toggle="modal" data-bs-target="#editConferences" class="edit-btn">
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
                    <h2>Edit User <span id="user_id"></span> Access </h2>
                    <form method="POST" enctype="multipart/form-data" id="edit-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.userAccess.index') }}">
                        <div id="userAccessForm">

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


        var editUrl = ele.getAttribute("data-edit_url");

        $("#userAccessForm").html(`<label class="loading"></label> <li class='loading' >Loading</li>`)
        $.get(editUrl, function(data, status) {
            $("#userAccessForm").html(data.data)
            MultiselectDropdown(window.MultiselectDropdownOptions);
            $("#league_container").show();
        });

        $("#user_id", ele.getAttribute("data-first_name"))

        $("#edit-form").attr("action", ele.getAttribute("data-update_url"));

    }

    function switchTab(val) {
        $(".input_radio_box").removeClass("active");
        $(`#${val}_authority_box`).addClass("active");

        $(".containers").hide();
        $(`#${val}_container`).show();

    }
</script>
@endpush