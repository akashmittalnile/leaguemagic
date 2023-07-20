@extends('layouts.admin.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/setting.css') }}">
<style>
    .top {
        background-color: darkblue;
        padding: 10px;
        color: white;
        font-weight: 600;
        font-size: 15px;
        text-align: center;
        width: 100%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        margin-bottom: 0px;
    }

    .cover {
        background-color: #fff;
        border-radius: 10x;
        padding: 10px;
        margin-top: 0px;

    }

    label {
        color: darkblue;
        font-weight: 600;
        font-size: 14px;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
@include('pages.admin.users-menu')
<div class="user-table-section">
    <div class="heading-section">
        <div class="d-flex  align-items-between">
            <div class="mr-auto">
                <h4 class="heading-title">Users Notifcation</h4>
            </div>
            <div class="w50">
                <a class="btn search-icon  mx-1 shadow border" href="{{ route('admin.userNotification.index') }}"><img src="{{asset('public/admin/images/view-icon.svg')}}" alt=""> view notification history</a>
            </div>

        </div>
    </div>

    <div class="lm-content-section">
        <form action="{{ route('admin.userNotification.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
            @csrf
            <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.userNotification.index') }}">

            <div class="row">
                <div class="col-md-5 offset-md-1 p-2">
                    <div class="cover">
                        <div class="form-group">
                            <h5>Send Notication to users</h5>
                            <div class="p-2">
                                <input type="checkbox" value="1" id="Active" name="all">
                                <label for="Active">
                                    All Active users
                                </label>
                            </div>
                        </div>
                        <div class="w-100">
                            <select name="users[]" id="participating_clubs" class="form-control" multiple multiselect-search="true">

                                @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->first_name!=""?$item->first_name." ".$item->last_name:$item->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                </div>

                <div class="col-md-4 p-2">
                    <h5 class="top">New Notification</h5>
                    <div class="cover">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" class="form-control" name="subject" placeholder="Type Here">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Announcement</label>
                                    <textarea name="notification" class="form-control" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 py-2">
                                <div class="form-group px-3 py-1">

                                    <button class="save-btn py-1 px-4" type="submit">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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



            if (parseInt(ele.getAttribute("data-status"))) {
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