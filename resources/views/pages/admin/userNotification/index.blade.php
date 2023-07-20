@extends('layouts.admin.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/setting.css') }}">
    <style>
        .form-control {
            border-radius: 1px solid red !important;
        }

        .content {
            font-size: 15px;
            font-weight: 500;
            margin-top: 1px;
        }

        .content {
            font-size: 15px;
            font-weight: 500;
            margin-top: 1px;
        }

        h5 {
            margin-bottom: 0px;
        }

        #edit-form {
            background-color: white;
            border: 2px solid darkblue;
            border-radius: 10px;
            padding: 10px 15px;
        }
    </style>
@endpush

@section('content')
    @include('pages.admin.users-menu')
    <div class="user-table-section">
        <div class="heading-section">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h4 class="heading-title">
                        <a class="btn  mx-1" href="{{ route('admin.userNotification.create') }}">
                            <img src="{{ asset('public/admin/images/back.png') }}" height="30">
                        </a>
                        Notification History
                    </h4>
                </div>

                <div class="btn-option-info wd70">
                    <div class="search-filter">
                        <div class="row g-2">
                            <div class="col-md-10">
                                <div class="search-form-group">
                                    <form class="d-flex">

                                        <input type="date" name="start_date" class="form-control rouned mx-1"
                                            placeholder="Search users by name or status">
                                        <input type="date" name="end_date" class="form-control rouned mx-1"
                                            placeholder="Search users by name or status">

                                        <button class="btn search-icon bg-light mx-1 shadow " type="submit"><img
                                                src="{{ asset('public/admin/images/search-icon.svg') }}"></button>
                                        <a class="btn search-icon bg-light mx-1 shadow"
                                            href="{{ route('admin.userNotification.index') }}"><img
                                                src="{{ asset('public/admin/images/reset.png') }}" height="25"></a>

                                    </form>
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
                                <th>User Group name</th>

                                <th>Subject</th>


                                <th colspan="2" style="width: 200px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($userNotifications as $i=>$con)
                                <tr>
                                    <td>
                                        <span class="sno">{{ $i + 1 }}</span>
                                    </td>
                                    <td>
                                        {{ count(explode(',', $con->object_type)) > 1 ? 'sent to ' . count(explode(',', $con->object_type)) . ' users' : 'sent to ' . $con->object_type . ' users' }}
                                    </td>


                                    <td>
                                        {{ $con->subject }}
                                    </td>





                                    <td style="width: 100px;">
                                        <div class="table-action-info">
                                            <!-- <a data-bs-toggle="modal" data-bs-target="#view" class="view-btn">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <img src="{{ asset('public/admin/images/view-icon.svg') }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </a> -->
                                            <button onclick="edit(this)" data-subject="{{ $con->subject }}"
                                                data-created_at="{{ 'Notification sent on : ' . date('d/m/Y - h:i a ', strtotime($con->created_at)) }}"
                                                data-object_type="{{ count(explode(',', $con->object_type)) > 1 ? 'sent to ' . count(explode(',', $con->object_type)) . ' users' : 'sent to ' . $con->object_type . ' users' }}"
                                                data-notification="{{ $con->notification }}" data-bs-toggle="modal"
                                                data-bs-target="#editConferences" class="edit-btn">
                                                <img src="{{ asset('public/admin/images/view-icon.svg') }}">
                                            </button>

                                            <!-- <button type="button" class="btn  btn-xs" onclick="deletePost({{ $con->id }})">
                                                                                <img src="{{ asset('public/admin/images/delete-icon.svg') }}">
                                                                                <form action="{{ route('admin.users.destroy', $con->id) }}" method="POST" id="del-post-{{ $con->id }}" style="display:none;">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                </form>
                                                                            </button> -->
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
                {{ $userNotifications->links() }}
            </div>
        </div>
    </div>






    <!-- Edit Users -->
    <div class="modal lm-modal fade" id="editConferences" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="lm-modal-form">

                        <h2 class="alert-warning p-1"> <button class="btn" data-bs-dismiss="modal" aria-label="Close">
                                <img src="{{ asset('public/admin/images/back.png') }}" height="30"></button> View
                            Notification Details </h2>
                        <form method="POST" enctype="multipart/form-data" id="edit-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="redirect_url" id="redirect_url"
                                value="{{ route('admin.users.pending') }}">

                            <div class="row">
                                <div class="col-md-12 p-2">
                                    <p class="p-1 my-2 text-center rounded-pill alert h6 alert-success"
                                        id="edit-created_at"> </p>
                                    <h5 class="mt-4">Subject</h5>
                                    <p class="content" id="edit-subject"></p>
                                    <h5 class="mt-4">Announcement</h5>
                                    <p class="content" id="edit-notification"></p>
                                    <h5 class="mt-4">User group</h5>
                                    <p class="content" id="edit-object_type"></p>
                                </div>
                            </div>
                        </form>
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

            $("#edit-subject").text(ele.getAttribute("data-subject"));
            $("#edit-notification").text(ele.getAttribute("data-notification"));
            $("#edit-object_type").text(ele.getAttribute("data-object_type"));

            $("#edit-created_at").text(ele.getAttribute("data-created_at"));

        }
    </script>
@endpush
