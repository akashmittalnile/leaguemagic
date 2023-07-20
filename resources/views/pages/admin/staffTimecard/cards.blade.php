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

                                    <input type="date" name="start_date" class="form-control rouned mx-1" placeholder="Search users by name or status">
                                    <input type="date" name="end_date" class="form-control rouned mx-1" placeholder="Search users by name or status">
                                    <select name="status" class="form-control rouned mx-1" id="">
                                        <option value="">Show All</option>
                                        <option value="0">pending</option>
                                        <option value="1">paid</option>
                                    </select>
                                    <button class="btn search-icon bg-light mx-1 shadow " type="submit"><img src="{{ asset('public/admin/images/search-icon.svg') }}"></button>
                                    <a class="btn search-icon bg-light mx-1 shadow" href="{{ route('admin.staffTimecard.show',$user->id) }}"><img src="{{ asset('public/admin/images/reset.png') }}" height="25"></a>

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
                                ${{ $con->total_amount }}
                            </td>
                            <td>
                                <span class="lm-status-text {{$con->status?'st-active':'st-inactive'}}">{{ $con->status ? 'paid' : 'pending' }}</span>
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
<div class="modal lm-modal fade" id="AddConferences" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="lm-modal-form">
                    <h2>Add Staff Timecard </h2>
                    <form action="{{ route('admin.staffTimecard.store') }}" method="POST" enctype="multipart/form-data" id="create-form">
                        @csrf
                        <input type="hidden" name="redirect_url" id="redirect_url" value="{{ route('admin.staffTimecard.show',$user->id) }}">

                        <div class="row">

                            <div class="col-sm-12 ">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="Location">
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

                                                <input type="text" class="form-control" name="expense1" placeholder="type expense">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <input type="text" class="form-control" name="amount1" placeholder="$0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" class="form-control" name="start_time" onchange="calculateUnits('start_time',this.value)" placeholder="type amount">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" class="form-control" onchange="calculateUnits('end_time',this.value)" name="end_time" placeholder="type amount">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>work units</label>
                                    <input type="number" class="form-control" id="work_units" name="work_units" placeholder="type amount" readonly>
                                    <span class="small text-danger" id="result"></span>
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
                                    <input type="email" class="form-control" name="email" placeholder="enter email">
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="cancel-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="save-btn" type="submit">Save & Update</button>
                                </div>
                            </div>
                            <input type="text" name="expense_count" value="1" style="opacity: 0">
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
                                        placeholder="$0.00">
                                </div>
                            </div>
                        </div>`;
        $("#containers").html($("#containers").html() + html)
        count += 1;
        $("input[name=expense_count]").val(count);
    }



    var start_time = null;
    var end_time = null;

    function calculateUnits(time_var, value) {
        const resultElement = document.getElementById('result');
        if (time_var == "start_time") {
            start_time = value;
        } else {
            end_time = value;

        }
        if (!start_time || !end_time) {
            resultElement.textContent = "Please enter both start and end times.";
            return;
        }

        const startTime = convertTimeStringToTimeObject(start_time);
        const endTime = convertTimeStringToTimeObject(end_time);

        if (endTime <= startTime) {
            resultElement.textContent = "End time must be greater than start time.";
            return;
        }

        const totalHours = calculateTimeDifferenceInHours(startTime, endTime);

        $("#work_units").val(totalHours.toFixed(2))
        resultElement.textContent = "";
    }

    function convertTimeStringToTimeObject(timeString) {
        const [hours, minutes] = timeString.split(":").map(Number);
        return new Date(0, 0, 0, hours, minutes);
    }

    function calculateTimeDifferenceInHours(startTime, endTime) {
        const millisecondsInHour = 1000 * 60 * 60;
        const timeDifference = endTime - startTime;
        return timeDifference / millisecondsInHour;
    }
</script>
@endpush