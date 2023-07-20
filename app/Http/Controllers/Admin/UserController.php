<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\userExport;
use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Positions;
use App\Models\UserClubAccess;
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
            $users = User::where('first_name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.users.index', compact('users', 'states', 'positions', 'clubs'));
        }
        if (request()->has('export')) {
            return (new userExport("user"))->download('users.xlsx');
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
    public function pending()
    {
        $paginate = env('PAGINATE');
        $states = DB::table("states")->get();
        $positions = Positions::all();
        $clubs = Club::all();

        if (request()->has('search')) {
            $keyword = request("search");
            $users = User::where("isActive", "pending")->where('first_name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.users.pending', compact('users', 'states', 'positions', 'clubs'));
        }

        $users = User::where("isActive", "pending")->paginate($paginate);
        return view('pages.admin.users.pending', compact('users', 'states', 'positions', 'clubs'));
    }
    public function reject()
    {
        $paginate = env('PAGINATE');
        $states = DB::table("states")->get();
        $positions = Positions::all();
        $clubs = Club::all();
        $users = User::where("isActive", "pending");

        if (request()->has('search')) {
            $keyword = request("search");
            if (request("search") != "") {
                $users =  $users->where('first_name', "LIKE", "%$keyword%")->where('last_name', "LIKE", "%$keyword%");
            }
            if (request("start_date") != "") {
                $users =  $users->where('created_at', ">", request("start_date"));
            }
            if (request("end_date") != "") {
                $users =  $users->where('created_at', "<", request("start_date"));
            }
            $users =   $users->paginate($paginate);
            return view('pages.admin.users.pending', compact('users', 'states', 'positions', 'clubs'));
        }

        $users = User::where("isActive", "reject")->paginate($paginate);
        return view('pages.admin.users.rejected', compact('users', 'states', 'positions', 'clubs'));
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


            if ($request->password != "") {
                $arr['password'] = 'min:6';
            }
            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag =  new User();
            $tag->first_name = $request->first_name;
            $tag->last_name = $request->last_name;
            $tag->city = $request->city;
            $tag->state_id = $request->state_id;
            $tag->position_id = $request->position_id;
            $tag->role_id = 3;

            $tag->address_line1 = $request->address_line1;
            $tag->address_line2 = $request->address_line2;
            $tag->email = $request->email;
            $tag->contact_number = $request->contact_number;
            $tag->status = 1;


            if ($request->password != "" && strlen($request->password) >= 6) {
                $tag->password = $request->password;
            }
            $tag->save();
            if ($request->has("clubs")) {
                foreach ($request->clubs as $club_id) {
                    $userAccess = new UserClubAccess();
                    $userAccess->user_id = $tag->id;
                    $userAccess->club_id = $club_id;
                    $userAccess->save();
                }
            }

            return response()->json(['message' => 'User created successfully.', 'status' => 201], 201);
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
            if ($request->has('isActive')) {
                $tag->isActive = $request->isActive;
            }
            if ($request->has("password")) {
                if ($request->password != "" && strlen($request->password) >= 6) {
                    $tag->password = $request->password;
                }
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
        $dlt = User::find($id);
        $dlt->delete();

        Toastr::success('message', 'user deleted successfully.');
        return redirect()->back();
    }
}
