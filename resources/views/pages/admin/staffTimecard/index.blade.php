@extends('layouts.admin.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/setting.css') }}">
<style>
    .form-control {
        border-radius: 1px solid red !important;
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
                    Staff Timecard
                </h4>
            </div>

            <div class="btn-option-info wd70">
                <div class="search-filter">
                    <div class="row g-2">
                        <div class="col-md-10">
                            <div class="search-form-group">
                                <form class="d-flex">
                                    <input type="text" name="search" class="form-control rouned mx-1" placeholder="Search users by name or status">

                                    <button class="btn search-icon bg-light mx-1 shadow " type="submit"><img src="{{ asset('public/admin/images/search-icon.svg') }}"></button>
                                    <a class="btn search-icon bg-light mx-1 shadow" href="{{ route('admin.staffTimecard.index') }}"><img src="{{ asset('public/admin/images/reset.png') }}" height="25"></a>

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
                                    <a href="{{route('admin.staffTimecard.show',$con->id)}}" class="btn"> <img src="{{ asset('public/admin/images/view-icon.svg') }}"></a>
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
</script>

@endpush