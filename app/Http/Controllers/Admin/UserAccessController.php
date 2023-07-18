<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Division;
use App\Models\Group;
use App\Models\Level;
use App\Models\Sport;
use App\Models\UserAccess as ModelsUserAccess;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAccessController extends Controller
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
            $users = User::where('name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.userAccess.index', compact('users'));
        }

        $users = User::paginate($paginate);
        return view('pages.admin.userAccess.index', compact('users'));
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
        $userAccess = [];
        $user = User::find($id);
        $clubs = Club::all();
        $sports = Sport::all();
        $divisions = Division::all();
        $groups = Group::all();
        $levels = Level::all();

        $access = DB::table("user_accesses")->where("user_id", $id)->get();
        foreach ($access as $item) {
            $userAccess[$item->access_key] = $item->access_value;
        }

        $html = view("pages.admin.userAccess.item", compact('userAccess', 'clubs', 'sports', 'divisions', 'groups', 'levels'))->render();
        return response()->json(['status' => 201, 'data' => $html], 201);
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

        $data = $request->all();
        unset($data["_token"]);
        unset($data["redirect_url"]);
        unset($data["_method"]);
        unset($data["selected"]);
        $data["sports"] = implode(",", $request->sports);
        $data["divisions"] = implode(",", $request->divisions);
        $data["clubs"] = implode(",", $request->clubs);

        foreach ($data as $key => $value) {
            $first = ModelsUserAccess::where("access_key", $key)->where("user_id", $id)->first();
            if ($first) {
                $first->access_key = $key;
                $first->access_value = $value;
                $first->save();
            } else {
                $userAccess = new ModelsUserAccess();
                $userAccess->access_key = $key;
                $userAccess->access_value = $value;
                $userAccess->user_id = $id;
                $userAccess->save();
            }
        }
        return response()->json(['message' => 'Access Updated successfully.', 'status' => 201], 201);
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
