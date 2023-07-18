@extends('layouts.admin.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/setting.css') }}">
@endpush

@section('content')
@include('pages.admin.setting-menu')
<div class="user-table-section">
    <div class="heading-section">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h4 class="heading-title">Positions</h4>
            </div>
            <div class="p-2">
                <a class="btn search-icon add-new-btn mx-1 shadow" href="{{route('admin.positions.index','export=true')}}">Export positions</a>
            </div>
            <div class="btn-option-info wd50">
                <div class="search-filter">
                    <div class="row g-2">
                        <div class="col-md-7">
                            <div class="search-form-group">
                                <form class="d-flex">
                                    <input type="text" name="search" class="form-control" placeholder="Search positions by name or status">
                                    <button class="btn search-icon bg-light mx-1 shadow " type="submit"><img src="{{asset('public/admin/images/search-icon.svg')}}"></button>
                                    <a class="btn search-icon bg-light mx-1 shadow" href="{{route('admin.positions.index')}}"><img src="{{asset('public/admin/images/reset.png')}}" height="25"></a>

                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <a class="add-new-btn" data-bs-toggle="modal" data-bs-target="#AddConferences"> Add new
                                    Positions</a>
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
                        @forelse($positions as $i=>$con)
                        <tr>
                            <td>
                                <span class="sno">{{ $i + 1 }}</span>
                            </td>


                            <td>
                                {{ $con->name }}
                            </td>

                            <td>
                                <div class="lm-status-text {{$con->status?'st-active':'st-inactive'}}">
                                    {{$con->status?"Active":"Inactive"}}
                                </div>
                            </td>


                            <td style="width: 200px;">
                                <div class="switch-toggle">
                                    <p>{{$con->status?"Active":"Inactive"}}</p>
                                    <div class="">
                                        <label class="toggle" for="myToggle{{$con->id}}">
                                            <input class="toggle__input" name="" onchange="toggleStatus(this)" data-update_url="{{route('admin.locations.update',$con->id)}}" {{$con->status?"checked":""}} type="checkbox" id="myToggle{{$con->id}}">
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
                                    <button onclick="edit(this)" data-name="{{ $con->name }}" data-sort_order="{{ $con->sort_order }}" data-badge_color="{{ $con->badge_color }}" data-badge_color_hex="{{ $con->badge_color_hex }}" data-admin_access="{{ $con->admin_access }}" data-admin_badge="{{ $con->admin_badge }}" data-position_ratio="{{ $con->position_ratio }}" data-text_color="{{ $con->text_color }}" data-name="{{ $con->name }}" data-status="{{ $con->status }}" data-update_url="{{ route('admin.positions.update', $con->id) }}" data-bs-toggle="modal" data-bs-target="#editConferences" class="edit-btn">
                                        <img src="{{ asset('public/admin/images/edit-icon.svg') }}">
                                    </button>

                                    <button type="button" class="btn  btn-xs" onclick="deletePost({{ $con->id }})">
                                        <img src="{{ asset('public/admin/images/delete-icon.svg') }}">
                                        <form action="{{ route('admin.positions.destroy', $con->id) }}" method="POST" id="del-post-{{ $con->id }}" style="display:none;">
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
            {{$positions->links()}}
        </div>
    </div>
</div>
<!-- add Positions -->
<div class="modal lm-modal fade" id="AddConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Add New Positions </h2>
                    <form action="{{ route('admin.positions.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
                        @csrf
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.positions.index') }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Position Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Type Here">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="region_container">
                                        <label class="form-label">Position Account Access</label>
                                        <ul class="lm-Status-list">
                                            <p class="text-bold font-bold">Will this posistion require an Account on the team management console</p>

                                            <li>
                                                <div class="lm-radio">
                                                    <input type="radio" value="1" id="account_access_yes" name="account_access">
                                                    <label for="account_access_yes">
                                                        Yes
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="lm-radio">
                                                    <input type="radio" value="0" id="account_access_no" name="account_access">
                                                    <label for="account_access_no">
                                                        No
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="region_container">
                                        <label class="form-label">Position Admin Badge</label>
                                        <ul class="lm-Status-list">
                                            <p class="text-bold font-bold">Will this posistion require an Admin Level Badge For Field Access </p>

                                            <li>
                                                <div class="lm-radio">
                                                    <input type="radio" value="1" id="admin_badge_yes" name="admin_badge">
                                                    <label for="admin_badge_yes">
                                                        Yes
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="lm-radio">
                                                    <input type="radio" value="0" id="admin_badge_no" name="admin_badge">
                                                    <label for="admin_badge_no">
                                                        No
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Position Sort Order</label>
                                    <input type="number" class="form-control" name="sort_order" placeholder="Type Here">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Maximum Positions</label>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="row">

                                                <div class="col-sm-12 ">
                                                    <input type="text" class="form-control" name="left_position_ratio" placeholder="Type Here">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-2">Per</div>
                                        <div class="col-sm-5">
                                            <div class="row">

                                                <div class="col-sm-12 ">
                                                    <input type="text" class="form-control" name="right_position_ratio" placeholder="Type Here">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Position Badge Color</label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-sm-6 pt-2">
                                                    <label for="">RED</label>
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <input type="text" class="form-control" name="RED" placeholder="Type Here">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-sm-6 pt-2">
                                                    <label for="">GREEN</label>
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <input type="text" class="form-control" name="GREEN" placeholder="Type Here">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-sm-6 pt-2">
                                                    <label for="">BLUE</label>
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <input type="text" class="form-control" name="BLUE" placeholder="Type Here">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-center font-bold text-small">OR</div>
                                    <div class="d-flex p-1 ">
                                        <label class="text-bold mr-3 mt-2">HEX</label> <span class="p-1"></span>
                                        <input type="text" class="form-control flex-1" name="badge_color_hex" placeholder="Type Here">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>TEXT COLOR</label>
                                    <ul class="lm-Status-list">
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="white" id="WHITE" name="text_color">
                                                <label for="WHITE">
                                                    WHITE
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="black" id="BLACK" name="text_color">
                                                <label for="BLACK">
                                                    BLACK
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <ul class="lm-Status-list">
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="1" id="ACTIVE" name="status">
                                                <label for="ACTIVE">
                                                    ACTIVE
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="0" id="Inactive" name="status">
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
                                    <button class="save-btn" type="submit">Save & Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Edit Positions -->
<div class="modal lm-modal fade" id="editConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Edit Positions Details </h2>
                    <form method="POST" enctype="multipart/form-data" id="edit-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.positions.index') }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Position Name</label>
                                    <input type="text" class="form-control" name="name" id="edit-name" placeholder="Type Here">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="region_container">
                                        <label class="form-label">Position Account Access</label>
                                        <ul class="lm-Status-list">
                                            <p class="text-bold font-bold">Will this posistion require an Account on the team management console</p>

                                            <li>
                                                <div class="lm-radio">
                                                    <input type="radio" value="1" id="edit-account_access_yes" name="account_access">
                                                    <label for="edit-account_access_yes">
                                                        Yes
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="lm-radio">
                                                    <input type="radio" value="0" id="edit-account_access_no" name="account_access">
                                                    <label for="edit-account_access_no">
                                                        No
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="region_container">
                                        <label class="form-label">Position Admin Badge</label>
                                        <ul class="lm-Status-list">
                                            <p class="text-bold font-bold">Will this posistion require an Admin Level Badge For Field Access </p>

                                            <li>
                                                <div class="lm-radio">
                                                    <input type="radio" value="1" id="edit-admin_badge_yes" name="admin_badge">
                                                    <label for="edit-admin_badge_yes">
                                                        Yes
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="lm-radio">
                                                    <input type="radio" value="0" id="edit-admin_badge_no" name="admin_badge">
                                                    <label for="edit-admin_badge_no">
                                                        No
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Position Sort Order</label>
                                    <input type="number" class="form-control" id="edit-sort_order" name="sort_order" placeholder="Type Here">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Maximum Positions</label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="row">

                                                <div class="col-sm-6 ">
                                                    <input type="text" class="form-control" id="edit-left_position_ratio" name="left_position_ratio" placeholder="Type Here">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row">

                                                <div class="col-sm-6 ">
                                                    <input type="text" class="form-control" id="edit-right_position_ratio" name="right_position_ratio" placeholder="Type Here">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Position Badge Color</label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-sm-6 pt-2">
                                                    <label for="">RED</label>
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <input type="text" class="form-control" id="edit-RED" name="RED" placeholder="Type Here">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-sm-6 pt-2">
                                                    <label for="">GREEN</label>
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <input type="text" class="form-control" id="edit-GREEN" name="GREEN" placeholder="Type Here">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-sm-6 pt-2">
                                                    <label for="">BLUE</label>
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <input type="text" class="form-control" id="edit-BLUE" name="BLUE" placeholder="Type Here">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-center font-bold text-small">OR</div>
                                    <div class="d-flex p-1 ">
                                        <label class="text-bold mr-3 mt-2">HEX</label>
                                        <input type="text" class="form-control flex-1" id="edit-badge_color_hex" name="badge_color_hex" placeholder="Type Here">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>TEXT COLOR</label>
                                    <ul class="lm-Status-list">
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="white" id="edit-WHITE" name="text_color">
                                                <label for="edit-WHITE">
                                                    WHITE
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="black" id="edit-BLACK" name="text_color">
                                                <label for="edit-BLACK">
                                                    BLACK
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <ul class="lm-Status-list">
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="1" id="edit-ACTIVE" name="status">
                                                <label for="edit-ACTIVE">
                                                    ACTIVE
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="0" id="edit-Inactive" name="status">
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


<!-- Delete Positions -->
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

        $("#edit-sort_order").val(ele.getAttribute("data-sort_order"));

        $("#edit-badge_color_hex").val(ele.getAttribute("data-badge_color_hex"));

        var position_ration = ele.getAttribute("data-position_ratio").split("/");
        $("#edit-left_position_ratio").val(position_ration[0]);
        $("#edit-right_position_ratio").val(position_ration[1]);
        var badge_color = ele.getAttribute("data-badge_color").split(",");
        $("#edit-RED").val(badge_color[0]);
        $("#edit-GREEN").val(badge_color[1]);
        $("#edit-BLUE").val(badge_color[2]);






        if (parseInt(ele.getAttribute("data-status"))) {
            $("#edit-ACTIVE").attr("checked", "true");

        } else {
            $("#edit-Inactive").attr("checked", "true");

        }


        if (ele.getAttribute("data-text_color") == "white") {
            $("#edit-WHITE").attr("checked", "true");

        } else {
            $("#edit-BLACK").attr("checked", "true");

        }

        if (parseInt(ele.getAttribute("data-admin_badge"))) {
            $("#edit-admin_badge_yes").attr("checked", "true");

        } else {
            $("#edit-admin_badge_no").attr("checked", "true");

        }
        if (parseInt(ele.getAttribute("data-account_access"))) {
            $("#edit-account_access_yes").attr("checked", "true");

        } else {
            $("#edit-account_access_no").attr("checked", "true");

        }

        $("#edit-form").attr("action", ele.getAttribute("data-update_url"));

    }
</script>
@endpush