<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\StaffTimeCard;
use App\Models\StaffTimeCardExpense as ModelsStaffTimeCardExpense;
use App\Models\UserClubAccess;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

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
        try {



            $arr = [
                'user_id' => 'required|max:255',
                'mileage' => 'required|numeric|max:255',
                'workdate' => 'required|unique:staff_time_cards|max:255',



            ];



            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }


            $tag =  new StaffTimeCard();
            $tag->workdate = $request->workdate;
            $tag->start_time = $request->start_time;
            $tag->end_time = $request->end_time;
            $tag->work_units = $request->work_units;
            $tag->comments = $request->comments;
            $tag->email_address = $request->email;
            $tag->user_id = $request->user_id;
            $tag->mileage = $request->mileage;

            $tag->status = 0;



            $total_amount = 0;
            for ($i = 1; $i <= $request->expense_count; $i++) {
                $total_amount += request("amount$i");
            }
            $user = User::find($request->user_id);
            $total_amount += $user->hourly_rate * $request->work_units;
            $total_amount += $user->mileage_rate * $request->mileage;

            $tag->total_amount = $total_amount;
            $tag->location = $request->location;

            $tag->save();
            // inserting the expensese
            for ($i = 1; $i <= $request->expense_count; $i++) {
                $staffTimeCardExpense = new ModelsStaffTimeCardExpense();
                $staffTimeCardExpense->staff_time_card_id = $tag->id;
                $staffTimeCardExpense->expenses_type = request("expense$i");
                $staffTimeCardExpense->expenses = request("amount$i");
                $staffTimeCardExpense->save();
            }

            return response()->json(['message' => 'User Expensed  Recorded successfully successfully.', 'status' => 201], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 200], 200);
        }
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
        $user = User::find($id);
        if (request()->has('start_date') || request()->has('end_date') || request()->has('status')) {
            $time_cards =    StaffTimeCard::where("user_id", $id);
            if (request("start_date") != "") {
                $time_cards =  $time_cards->where('created_at', ">=", request("start_date"));
            }
            if (request("end_date") != "") {
                $time_cards =  $time_cards->where('created_at', "<=", request("end_date"));
            }
            if (request("status") != "") {
                $time_cards =  $time_cards->where('status', request("status"));
            }
            $time_cards =   $time_cards->paginate($rpp);
            return view("pages.admin.staffTimecard.cards", compact('time_cards', 'user'));
        }

        $time_cards = StaffTimeCard::where("user_id", $id)->paginate($rpp);


        return view("pages.admin.staffTimecard.cards", compact('time_cards', 'user'));
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
