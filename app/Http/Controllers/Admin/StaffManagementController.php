<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\userExport;
use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class StaffManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = env('PAGINATE');
        $states = DB::table("states")->get();


        if (request()->has('search')) {
            $keyword = request("search");
            $staffManagement = User::where("user_type", "staff")->where('first_name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.staffManagement.index', compact('staffManagement', 'states'));
        }

        if (request()->has('export')) {
            return (new userExport("staff"))->download('staff.xlsx');
        }

        $staffManagement = User::where("user_type", "staff")->paginate($paginate);
        return view('pages.admin.staffManagement.index', compact('staffManagement', 'states'));
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
                'email' => 'required|unique:users|max:255',
                'contact_number' => 'required|unique:users|max:15',
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag =  new User();
            $tag->first_name = $request->first_name;
            $tag->last_name = $request->last_name;
            $tag->city = $request->city;
            $tag->state_id = $request->state_id;
            $tag->role_id = 3;
            $tag->username = explode("@", $request->email)[0];
            $tag->user_type = "staff";
            $tag->address_line1 = $request->address_line1;
            $tag->address_line2 = $request->address_line2;
            $tag->email = $request->email;
            $tag->contact_number = $request->contact_number;
            $tag->hourly_rate = $request->hourly_rate;
            $tag->mileage_rate = $request->mileage_rate;
            $tag->status = 1;
            $tag->save();

            return response()->json(['message' => 'Staff created successfully.', 'status' => 201], 201);
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
        //
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
        try {


            if ($request->has('toggle')) {
                $tag =  User::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Staff Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [
                'email' => 'required|max:255',
            ];


            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag =  User::find($id);
            $tag->first_name = $request->first_name;
            $tag->last_name = $request->last_name;
            $tag->city = $request->city;
            $tag->state_id = $request->state_id;
            $tag->address_line1 = $request->address_line1;
            $tag->address_line2 = $request->address_line2;
            $tag->email = $request->email;
            $tag->contact_number = $request->contact_number;
            $tag->hourly_rate = $request->hourly_rate;
            $tag->mileage_rate = $request->mileage_rate;

            if ($request->has('status')) {
                $tag->status = $request->status;
            }

            if ($request->has("password")) {
                if ($request->password != "" && strlen($request->password) >= 6) {
                    $tag->password = $request->password;
                }
            }

            $tag->save();

            return response()->json(['message' => 'staff Updataed successfully.', 'status' => 201], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 200], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dlt = User::find($id);
        $dlt->delete();

        Toastr::success('message', 'staff deleted successfully.');
        return redirect()->back();
    }
}
