@extends('layouts.admin.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/setting.css') }}">
@endpush

@section('content')
@include('pages.admin.setting-menu')

<div class="user-table-section">`
    <div class="heading-section">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h4 class="heading-title">Conferences</h4>
            </div>
            <div class="p-2">
                <a class="btn search-icon add-new-btn mx-1 shadow" href="{{route('admin.conference.index','export=true')}}">Export Conferences</a>
            </div>
            <div class="btn-option-info wd50">
                <div class="search-filter">
                    <div class="row g-2">
                        <div class="col-md-7">
                            <div class="search-form-group">
                                <form class="d-flex">
                                    <input type="text" name="search" class="form-control" placeholder="Search divisions by name or status">
                                    <button class="btn search-icon bg-light mx-1 shadow " type="submit"><img src="{{asset('public/admin/images/search-icon.svg')}}"></button>
                                    <a class="btn search-icon bg-light mx-1 shadow" href="{{route('admin.conference.index')}}"><img src="{{asset('public/admin/images/reset.png')}}" height="25"></a>

                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <a class="add-new-btn" data-bs-toggle="modal" data-bs-target="#AddConferences"> Add new Conferences</a>
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
                            <th>Title</th>

                            <th>Name</th>
                            <th>Status</th>
                            <th colspan="2" style="width: 200px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($conference as $i=>$con)
                        <tr>
                            <td>
                                <span class="sno">{{$i+1}}</span>
                            </td>

                            <td>
                                {{$con->title}}
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
                                    {{$con->status?"Active":"Inactive"}}
                                    <div class="">
                                        <label class="toggle" for="myToggle{{$con->id}}">
                                            <input class="toggle__input" name="" onchange="toggleStatus(this)" data-update_url="{{route('admin.conference.update',$con->id)}}" {{$con->status?"checked":""}} type="checkbox" id="myToggle{{$con->id}}">
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
                                    <button onclick="edit('{{route('admin.conference.update',$con->id)}}','{{$con->name}}','{{$con->title}}','{{$con->status}}','{{$con->sort_order}}')" data-bs-toggle="modal" data-bs-target="#editConferences" class="edit-btn">
                                        <img src="{{asset('public/admin/images/edit-icon.svg')}}">
                                    </button>

                                    <button type="button" class="btn  btn-xs" onclick="deletePost({{$con->id}})">
                                        <img src="{{asset('public/admin/images/delete-icon.svg')}}">
                                        <form action="{{route('admin.conference.destroy',$con->id)}}" method="POST" id="del-post-{{$con->id}}" style="display:none;">
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
            {{$conference->links()}}
        </div>
    </div>
</div>
<!-- add Conference -->
<div class="modal lm-modal fade" id="AddConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Add New Conference </h2>
                    <form action="{{route('admin.conference.store')}}" method="POST" enctype="multipart/form-data" id="create-form">
                        @csrf
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.conference.index') }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Conference Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Type Here">
                                    <span class="form-msg-text">A Name That This Location Is Known By.</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Conference Short Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Type Here">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Conference Sort Order</label>
                                    <input type="text" class="form-control" name="sort_order" placeholder="Type Here">
                                    <span class="form-msg-text">A Numeric Value To Indicate The Order Conferences Should Be Sorted.</span>
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





<!-- Edit Conference -->
<div class="modal lm-modal fade" id="editConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Edit Conference Details </h2>
                    <form class="edit-form" method="POST" id="edit-form">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.conference.index') }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Conference Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Type Here" id="edit-title">
                                    <span class="form-msg-text">A Name That This Location Is Known By.</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Conference Name</label>
                                    <input type="text" class="form-control" name="name" id="edit-name" placeholder="Type Here">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Conference Sort Order</label>
                                    <input type="text" class="form-control" name="sort-order" id="edit-sort-order" placeholder="Type Here">
                                    <span class="form-msg-text">A Numeric Value To Indicate The Order Conferences Should Be Sorted.</span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <ul class="lm-Status-list">
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="1" id="ACTIVE_" name="status">
                                                <label for="ACTIVE_">
                                                    ACTIVE
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="lm-radio">
                                                <input type="radio" value="0" id="Inactive_" name="status">
                                                <label for="Inactive_">
                                                    Inactive

                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="cancel-btn" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="save-btn" type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Delete Conference -->
<div class="modal lm-modal fade" id="deleteConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-content">
                    <div class="lm-modal-media">
                        <img src="images/delete.svg">
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

    function edit(update_url, name, title, status, sort_order) {

        $("#edit-name").val(name);
        $("#edit-title").val(title);
        $("#edit-sort-order").val(sort_order);
        if (parseInt(status)) {
            $("#ACTIVE_").attr("checked", "true");

        } else {
            $("#Inactive_").attr("checked", "true");

        }
        $("#edit-form").attr("action", update_url);

    }
</script>
@endpush