<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\StaffTimeCard;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffTimecardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = env('PAGINATE');

        if (request()->has('search')) {
            $keyword = request("search");
            $users = User::where("user_type", "staff")->where('first_name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.staffTimecard.index', compact('users'));
        }

        $users = User::where("user_type", "staff")->paginate($paginate);
        return view('pages.admin.staffTimecard.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rpp = env("PAGINATE");
        $time_cards = StaffTimeCard::where("user_id", $id)->paginate($rpp);
        $user = User::find($id);
        $locations = Location::all();
        return view("pages.admin.staffTimecard.cards", compact('time_cards', 'user', 'locations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
