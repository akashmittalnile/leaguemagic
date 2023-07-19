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
                    <h4 class="heading-title">{{ $user->first_name . ' ' . $user->last_name }} Timecard</h4>
                </div>

                <div class="btn-option-info wd70">
                    <div class="search-filter">
                        <div class="row g-2">
                            <div class="col-md-8">
                                <div class="search-form-group">
                                    <form class="d-flex">

                                        <input type="date" name="start_date" class="form-control rouned mx-1"
                                            placeholder="Search users by name or status">
                                        <input type="date" name="end_date" class="form-control rouned mx-1"
                                            placeholder="Search users by name or status">
                                        <select name="status" class="form-control rouned mx-1" id="">
                                            <option value="">Show All</option>
                                            <option value="0">pending</option>
                                            <option value="1">paid</option>
                                        </select>
                                        <button class="btn search-icon bg-light mx-1 shadow " type="submit"><img
                                                src="{{ asset('public/admin/images/search-icon.svg') }}"></button>
                                        <a class="btn search-icon bg-light mx-1 shadow"
                                            href="{{ route('admin.users.reject') }}"><img
                                                src="{{ asset('public/admin/images/reset.png') }}" height="25"></a>

                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group px-1">
                                    <a class="add-new-btn" data-bs-toggle="modal" data-bs-target="#AddConferences"> Add new
                                        Timecard</a>
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
                                <th>Submitted Date & Time</th>

                                <th>Check-in Date & Time</th>
                                <th>Check-out Date & Time</th>
                                <th>Payment</th>
                                <th>Status</th>

                            </tr>
                        </thead>

                        <tbody>
                            @forelse($time_cards as $i=>$con)
                                <tr>
                                    <td>
                                        <span class="sno">{{ $i + 1 }}</span>
                                    </td>
                                    <td>
                                        {{ date('d/m/Y - h:i a', strtotime($con->created_at)) }}
                                    </td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($con->workdate)) . ' ' . date('h:i a', strtotime($con->start_time)) }}
                                    </td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($con->workdate)) . ' ' . date('h:i a', strtotime($con->end_time)) }}
                                    </td>
                                    <td>
                                        {{ $user->hourly_rate * $con->work_units }}
                                    </td>
                                    <td>
                                        {{ $con->status ? 'paid' : 'pending' }}
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
                {{ $time_cards->links() }}
            </div>
        </div>
    </div>
    <!-- add Users -->
    <div class="modal lm-modal fade" id="AddConferences" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="lm-modal-form">
                        <h2>Add Staff Timecard </h2>
                        <form action="{{ route('admin.staffTimecard.store') }}" method="POST"
                            enctype="multipart/form-data" id="create-form">
                            @csrf
                            <input type="hidden" name="redirect_url" id="redirect_url"
                                value="{{ route('admin.staffTimecard.index') }}">

                            <div class="row">

                                <div class="col-sm-12 ">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select name="location_id" class="form-control">

                                            <option value="">Select a location</option>
                                            @foreach ($locations as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Work Date (MM/DD/YY)</label>
                                        <input type="date" class="form-control" name="workdate" placeholder="Work date">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Mileage</label>
                                        <input type="text" class="form-control" name="mileage" placeholder="mileage">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group d-flex justify-content-between my-1 py-1">
                                        <label>Miscellanious Expenses</label>
                                        <button class="btn btn-primary" type="button" onclick="addPlayoffDates()">Add
                                            Expenses</button>
                                    </div>
                                    <div id="containers">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" name="expense1"
                                                        placeholder="type expense">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" name="amount1"
                                                        placeholder="type amount">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Time</label>
                                        <input type="time" class="form-control" name="start_time"
                                            placeholder="type amount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Time</label>
                                        <input type="time" class="form-control" name="end_time"
                                            placeholder="type amount">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>work units</label>
                                        <input type="number" class="form-control" name="end_time"
                                            placeholder="type amount" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea name="comments" class="form-control" id="" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Enter Email Address To Recive Confirmation</label>
                                        <input type="email" class="form-control" name="email"
                                            placeholder="type amount">
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="cancel-btn" data-bs-dismiss="modal"
                                            aria-label="Close">Cancel</button>
                                        <button class="save-btn" type="submit">Save & Update</button>
                                    </div>
                                </div>
                                <input type="text" name="dates_count" value="1" style="opacity: 0">
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
        var count = 1;

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

        function addPlayoffDates() {

            var html = `<div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <input type="text" class="form-control" name="expense${count+1}"
                                        placeholder="type expense">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">

                                    <input type="text" class="form-control" name="amount${count+1}"
                                        placeholder="type amount">
                                </div>
                            </div>
                        </div>`;
            $("#containers").html($("#containers").html() + html)
            count += 1;
            $("input[name=dates_count]").val(count);
        }
    </script>
@endpush
