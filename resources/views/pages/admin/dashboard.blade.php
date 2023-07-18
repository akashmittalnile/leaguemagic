@extends('layouts.admin.app')

@section('content')
<div class="" id="content-body">
   <div class="body-content-heading">
      <h3>Dashboard</h3>
   </div>
   <div>
      <div class="row">
         <div class="col-md-6 col-xl-3">
            <div class="card cards-customize">
               <div class="card-body">
                  <div class="float-end mt-2" style="position: relative;">
                     <div><img class="" src="{{ asset('public/admin/images/users.png') }}" alt="" height="60px"></div>
                  </div>
                  <div class="card-content">
                     <h5 class="mb-1 mt-1"><span data-plugin="counterup">Total Users</span></h5>
                     <p class="">Active :<span> 3568</span></p>
                     <p class="mb-0">Inactive :<span class="text-danger"> 458</span></p>
                  </div>
               </div>
            </div>
         </div>
         <!-- end col-->

         <div class="col-md-6 col-xl-3">
            <div class="card cards-customize">
               <div class="card-body">
                  <div class="float-end mt-2" style="position: relative;">
                     <div><img class="" src="{{ asset('public/admin/images/players.png') }}" alt="" height="60px"></div>
                  </div>
                  <div class="card-content">
                     <h5 class="mb-1 mt-1"><span data-plugin="counterup">Total Players</span></h5>
                     <p class="">Active :<span> 456</span></p>
                     <p class="mb-0">Inactive :<span class="text-danger"> 41</span></p>
                  </div>
               </div>
            </div>
         </div>
         <!-- end col-->
         <div class="col-md-6 col-xl-3">
            <div class="card cards-customize">
               <div class="card-body">
                  <div class="float-end mt-2" style="position: relative;">
                     <div><img class="" src="{{ asset('public/admin/images/team.png') }}" alt="" height="60px"></div>
                  </div>
                  <div class="card-content">
                     <h5 class="mb-1 mt-1"><span data-plugin="counterup">Total Teams</span></h5>
                     <p class="">Active :<span> 6554</span></p>
                     <p class="mb-0">Inactive :<span class="text-danger"> 125</span></p>
                  </div>
               </div>
            </div>
         </div>
         <!-- end col-->

         <div class="col-md-6 col-xl-3">
            <div class="card cards-customize">
               <div class="card-body">
                  <div class="float-end mt-2" style="position: relative;">
                     <div><img class="" src="{{ asset('public/admin/images/region.png') }}" alt="" height="60px"></div>
                  </div>
                  <div class="card-content">
                     <h5 class="mb-1 mt-1"><span data-plugin="counterup">Total Regions</span></h5>
                     <p class="">Active :<span> 8975</span></p>
                     <p class="mb-0">Inactive :<span class="text-danger"> 65</span></p>
                  </div>
               </div>
            </div>
         </div>
         <!-- end col-->
      </div>
      <div class="row mt-4">
         <div class="col-md-6 col-xl-3">
            <div class="card cards-customize">
               <div class="card-body">
                  <div class="float-end mt-2" style="position: relative;">
                     <div><img class="" src="{{ asset('public/admin/images/season.png') }}" alt="" height="60px"></div>
                  </div>
                  <div class="card-content">
                     <h5 class="mb-1 mt-1"><span data-plugin="counterup">Total Seasons</span></h5>
                     <p class="">Active :<span> 6541</span></p>
                     <p class="mb-0">Inactive :<span class="text-danger"> 125</span></p>
                  </div>
               </div>
            </div>
         </div>
         <!-- end col-->

         <div class="col-md-6 col-xl-3">
            <div class="card cards-customize">
               <div class="card-body">
                  <div class="float-end mt-2" style="position: relative;">
                     <div><img class="" src="{{ asset('public/admin/images/sport.png') }}" alt="" height="60px"></div>
                  </div>
                  <div class="card-content">
                     <h5 class="mb-1 mt-1"><span data-plugin="counterup">Total Sports</span></h5>
                     <p class="">Active :<span> 3568</span></p>
                     <p class="mb-0">Inactive :<span class="text-danger"> 98</span></p>
                  </div>
               </div>
            </div>
         </div>
         <!-- end col-->
         <div class="col-md-6 col-xl-3">
            <div class="card cards-customize">
               <div class="card-body">
                  <div class="float-end mt-2" style="position: relative;">
                     <div><img class="" src="{{ asset('public/admin/images/club.png') }}" alt="" height="60px"></div>
                  </div>
                  <div class="card-content">
                     <h5 class="mb-1 mt-1"><span data-plugin="counterup">Total Clubs</span></h5>
                     <p class="">Active :<span> 3568</span></p>
                     <p class="mb-0">Inactive :<span class="text-danger"> 168</span></p>
                  </div>
               </div>
            </div>
         </div>
         <!-- end col-->
      </div>
   </div>
</div>
@endsection