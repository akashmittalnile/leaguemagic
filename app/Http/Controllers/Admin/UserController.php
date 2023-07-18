<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Positions;
use App\User;
use Validator;
use Exception;
use Brian2694\Toastr\Toastr;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $positions = Positions::all();
        $clubs = Club::all();

        if (request()->has('search')) {
            $keyword = request("search");
            $users = User::where('name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.users.index', compact('users', 'states', 'positions', 'clubs'));
        }
        $users = User::paginate($paginate);
        return view('pages.admin.users.index', compact('users', 'states', 'positions', 'clubs'));
    }
    public function account()
    {

        $users = User::where("id", Auth::guard('admin')->id())->paginate();
        $switch = User::all();
        $states = DB::table("states")->get();

        return view('pages.admin.users.account', compact('users', 'switch', 'states'));
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
        //
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
                return response()->json(['message' => 'User Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [
                'email' => 'required|max:255',
            ];


            if ($request->password != "") {
                $arr['password'] = 'min:6';
            }
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

            if ($request->has('status')) {
                $tag->status = $request->status;
            }
            if ($request->password != "" && strlen($request->password) >= 6) {
                $tag->password = $request->password;
            }
            $tag->save();

            return response()->json(['message' => 'User Updataed successfully.', 'status' => 201], 201);
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
        //
    }
}
