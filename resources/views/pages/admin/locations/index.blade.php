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
                <h4 class="heading-title">Locations</h4>
            </div>
            <div class="p-2">
                <a class="btn search-icon add-new-btn mx-1 shadow" href="{{route('admin.locations.index','export=true')}}">Export Locations</a>
            </div>
            <div class="btn-option-info wd50">
                <div class="search-filter">
                    <div class="row g-2">
                        <div class="col-md-7">
                            <div class="search-form-group">
                                <form class="d-flex">
                                    <input type="text" name="search" class="form-control" placeholder="Search locations by name or status">
                                    <button class="btn search-icon bg-light mx-1 shadow " type="submit"><img src="{{asset('public/admin/images/search-icon.svg')}}"></button>
                                    <a class="btn search-icon bg-light mx-1 shadow" href="{{route('admin.locations.index')}}"><img src="{{asset('public/admin/images/reset.png')}}" height="25"></a>

                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <a class="add-new-btn" data-bs-toggle="modal" data-bs-target="#AddConferences"> Add new Locations</a>
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
                            <th>Code</th>


                            <th>Name</th>
                            <th>Status</th>
                            <th colspan="2" style="width: 200px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($locations as $i=>$con)
                        <tr>
                            <td>
                                <span class="sno">{{$i+1}}</span>
                            </td>

                            <td>
                                {{$con->code}}
                            </td>
                            <td>
                                {{$con->name}}
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
                                        <img src="{{asset('public/admin/images/view-icon.svg')}}">
                                    </a> -->
                                    <button onclick="edit(this)" data-name="{{ $con->name }}" data-colortheme="{{ $con->colortheme }}" data-title="{{ $con->title }}" data-code="{{ $con->code }}" data-zipcode="{{ $con->zipcode }}" data-city="{{ $con->city }}" data-state="{{ $con->state }}" data-fields="{{ $con->fields }}" data-homeclub="{{ $con->homeclub }}" data-address="{{ $con->address }}" data-update_url="{{ route('admin.locations.update', $con->id) }}" data-bs-toggle="modal" data-bs-target="#editConferences" class="edit-btn">
                                        <img src="{{asset('public/admin/images/edit-icon.svg')}}">
                                    </button>

                                    <button type="button" class="btn  btn-xs" onclick="deletePost({{$con->id}})">
                                        <img src="{{asset('public/admin/images/delete-icon.svg')}}">
                                        <form action="{{route('admin.locations.destroy',$con->id)}}" method="POST" id="del-post-{{$con->id}}" style="display:none;">
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
            {{$locations->links()}}
        </div>
    </div>
</div>
<!-- add Locations -->
<div class="modal lm-modal fade" id="AddConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Add New Locations </h2>
                    <form action="{{route('admin.locations.store')}}" method="POST" enctype="multipart/form-data" id="create-form">
                        @csrf
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.locations.index') }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Type Here">

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Type Here">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Type Here">
                                    <span class="form-msg-text">A Numeric Value To Indicate The Order Locations Should Be Sorted.</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations City</label>
                                    <input type="text" class="form-control" name="city" placeholder="Type Here">
                                    <span class="form-msg-text">A Numeric Value To Indicate The Order Locations Should Be Sorted.</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-6 px-1">
                                        <div class="form-group">
                                            <label>Locations State</label>
                                            <select name="state" class="form-control">

                                                <option value="">Select a state</option>
                                                <option value="Alabama">Alabama</option>
                                                <option value="Alaska">Alaska</option>
                                                <option value="Arizona">Arizona</option>
                                                <option value="Arkansas">Arkansas</option>
                                                <option value="California">California</option>
                                                <option value="Colorado">Colorado</option>
                                                <option value="Connecticut">Connecticut</option>
                                                <option value="Delaware">Delaware</option>
                                                <option value="Florida">Florida</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Hawaii">Hawaii</option>
                                                <option value="Idaho">Idaho</option>
                                                <option value="Illinois">Illinois</option>
                                                <option value="Indiana">Indiana</option>
                                                <option value="Iowa">Iowa</option>
                                                <option value="Kansas">Kansas</option>
                                                <option value="Kentucky">Kentucky</option>
                                                <option value="Louisiana">Louisiana</option>
                                                <option value="Maine">Maine</option>
                                                <option value="Maryland">Maryland</option>
                                                <option value="Massachusetts">Massachusetts</option>
                                                <option value="Michigan">Michigan</option>
                                                <option value="Minnesota">Minnesota</option>
                                                <option value="Mississippi">Mississippi</option>
                                                <option value="Missouri">Missouri</option>
                                                <option value="Montana">Montana</option>
                                                <option value="Nebraska">Nebraska</option>
                                                <option value="Nevada">Nevada</option>
                                                <option value="New Hampshire">New Hampshire</option>
                                                <option value="New Jersey">New Jersey</option>
                                                <option value="New Mexico">New Mexico</option>
                                                <option value="New York">New York</option>
                                                <option value="North Carolina">North Carolina</option>
                                                <option value="North Dakota">North Dakota</option>
                                                <option value="Ohio">Ohio</option>
                                                <option value="Oklahoma">Oklahoma</option>
                                                <option value="Oregon">Oregon</option>
                                                <option value="Pennsylvania">Pennsylvania</option>
                                                <option value="Rhode Island">Rhode Island</option>
                                                <option value="South Carolina">South Carolina</option>
                                                <option value="South Dakota">South Dakota</option>
                                                <option value="Tennessee">Tennessee</option>
                                                <option value="Texas">Texas</option>
                                                <option value="Utah">Utah</option>
                                                <option value="Vermont">Vermont</option>
                                                <option value="Virginia">Virginia</option>
                                                <option value="Washington">Washington</option>
                                                <option value="West Virginia">West Virginia</option>
                                                <option value="Wisconsin">Wisconsin</option>
                                                <option value="Wyoming">Wyoming</option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 px-1">
                                        <div class="form-group">
                                            <label>Locations Zipcode</label>
                                            <input type="text" class="form-control" name="zipcode" placeholder="Type Here">
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations Code</label>
                                    <input type="text" class="form-control" name="code" placeholder="Type Here">
                                    <span class="form-msg-text">Three Digit Location Code is indentify.</span>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations Fields</label>
                                    <input type="text" class="form-control" name="fields" placeholder="Type Here">
                                    <span class="form-msg-text">Numbers of fields Available at this location.</span>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Clubs Home Fields </label>
                                    <input type="text" class="form-control" name="homeclub" placeholder="Type Here">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Location Color Scheme </label>
                                    <input type="text" class="form-control" name="colortheme" placeholder="Type Here">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <ul class="lm-Status-list">
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="1" id="Active" name="status">
                                                <label for="Active">
                                                    Active
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





<!-- Edit Locations -->
<div class="modal lm-modal fade" id="editConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Edit Locations Details </h2>
                    <form action="" method="POST" id="edit-form">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.locations.index') }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations Title</label>
                                    <input type="text" class="form-control" id="edit-title" name="title" placeholder="Type Here">

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations Name</label>
                                    <input type="text" class="form-control" id="edit-name" name="name" placeholder="Type Here">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations Address</label>
                                    <input type="text" class="form-control" id="edit-address" name="address" placeholder="Type Here">
                                    <span class="form-msg-text">A Numeric Value To Indicate The Order Locations Should Be Sorted.</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations City</label>
                                    <input type="text" class="form-control" id="edit-city" name="city" placeholder="Type Here">
                                    <span class="form-msg-text">A Numeric Value To Indicate The Order Locations Should Be Sorted.</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-6 px-1">
                                        <div class="form-group">
                                            <label>Locations State</label>
                                            <select name="state" id="edit-state" class="form-control">

                                                <option value="">Select a state</option>
                                                <option value="Alabama">Alabama</option>
                                                <option value="Alaska">Alaska</option>
                                                <option value="Arizona">Arizona</option>
                                                <option value="Arkansas">Arkansas</option>
                                                <option value="California">California</option>
                                                <option value="Colorado">Colorado</option>
                                                <option value="Connecticut">Connecticut</option>
                                                <option value="Delaware">Delaware</option>
                                                <option value="Florida">Florida</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Hawaii">Hawaii</option>
                                                <option value="Idaho">Idaho</option>
                                                <option value="Illinois">Illinois</option>
                                                <option value="Indiana">Indiana</option>
                                                <option value="Iowa">Iowa</option>
                                                <option value="Kansas">Kansas</option>
                                                <option value="Kentucky">Kentucky</option>
                                                <option value="Louisiana">Louisiana</option>
                                                <option value="Maine">Maine</option>
                                                <option value="Maryland">Maryland</option>
                                                <option value="Massachusetts">Massachusetts</option>
                                                <option value="Michigan">Michigan</option>
                                                <option value="Minnesota">Minnesota</option>
                                                <option value="Mississippi">Mississippi</option>
                                                <option value="Missouri">Missouri</option>
                                                <option value="Montana">Montana</option>
                                                <option value="Nebraska">Nebraska</option>
                                                <option value="Nevada">Nevada</option>
                                                <option value="New Hampshire">New Hampshire</option>
                                                <option value="New Jersey">New Jersey</option>
                                                <option value="New Mexico">New Mexico</option>
                                                <option value="New York">New York</option>
                                                <option value="North Carolina">North Carolina</option>
                                                <option value="North Dakota">North Dakota</option>
                                                <option value="Ohio">Ohio</option>
                                                <option value="Oklahoma">Oklahoma</option>
                                                <option value="Oregon">Oregon</option>
                                                <option value="Pennsylvania">Pennsylvania</option>
                                                <option value="Rhode Island">Rhode Island</option>
                                                <option value="South Carolina">South Carolina</option>
                                                <option value="South Dakota">South Dakota</option>
                                                <option value="Tennessee">Tennessee</option>
                                                <option value="Texas">Texas</option>
                                                <option value="Utah">Utah</option>
                                                <option value="Vermont">Vermont</option>
                                                <option value="Virginia">Virginia</option>
                                                <option value="Washington">Washington</option>
                                                <option value="West Virginia">West Virginia</option>
                                                <option value="Wisconsin">Wisconsin</option>
                                                <option value="Wyoming">Wyoming</option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 px-2">
                                        <div class="form-group">
                                            <label>Locations Zipcode</label>
                                            <input type="text" class="form-control" id="edit-zipcode" name="zipcode" placeholder="Type Here">
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations Code</label>
                                    <input type="text" class="form-control" id="edit-code" name="code" placeholder="Type Here">
                                    <span class="form-msg-text">Three Digit Location Code is indentify.</span>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Locations Fields</label>
                                    <input type="text" class="form-control" id="edit-fields" name="fields" placeholder="Type Here">
                                    <span class="form-msg-text">Numbers of fields Available at this location.</span>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Clubs Home Fields </label>
                                    <input type="text" class="form-control" id="edit-homeclub" name="homeclub" placeholder="Type Here">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Location Color Scheme </label>
                                    <input type="text" class="form-control" id="edit-colortheme" name="colortheme" placeholder="Type Here">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <ul class="lm-Status-list">
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="1" id="edit-Active" name="status">
                                                <label for="edit-Active">
                                                    Active
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


<!-- Delete Locations -->
<div class="modal lm-modal fade" id="deleteConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-content">
                    <div class="lm-modal-media">
                        <img src="{{asset('public/admin/images/delete.svg')}}">
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
        $("#edit-code").val(ele.getAttribute("data-code"));
        $("#edit-title").val(ele.getAttribute("data-title"));

        $("#edit-city").val(ele.getAttribute("data-city"));
        $("#edit-state").val(ele.getAttribute("data-state"));
        $("#edit-address").val(ele.getAttribute("data-address"));
        $("#edit-code").val(ele.getAttribute("data-code"));
        $("#edit-zipcode").val(ele.getAttribute("data-zipcode"));
        $("#edit-fields").val(ele.getAttribute("data-fields"));
        $("#edit-homeclub").val(ele.getAttribute("data-homeclub"));
        $("#edit-colortheme").val(ele.getAttribute("data-colortheme"));

        if (parseInt(ele.getAttribute("data-status"))) {
            $("#edit-Active").attr("checked", "true");

        } else {
            $("#edit-Inactive").attr("checked", "true");

        }
        $("#edit-form").attr("action", ele.getAttribute("data-update_url"));

    }
</script>
@endpush