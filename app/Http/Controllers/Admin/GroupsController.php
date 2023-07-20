<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\GroupExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Conference;
use App\Models\Group;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Toastr;
use Auth;
use File;
use Validator;

class GroupsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $guard = 'admin';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

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
            $groups = Group::where('name', "LIKE", "%$keyword%")->orWhere('short_name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.groups.index', compact('groups'));
        }
        if (request()->has('export')) {
            return (new GroupExport)->download('groups.xlsx');
        }
        $groups = Group::orderBy("sort_order")->paginate($paginate);


        return view('pages.admin.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
                'short_name' => 'required|unique:groups|max:255',
                'name' => 'required|unique:groups|max:255',
                'sort_order' => 'unique:groups|numeric'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = new Group();
            $tag->name = $request->name;
            $tag->short_name = $request->short_name;

            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';
            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Group created successfully.', 'status' => 201], 201);
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
                $tag =  Group::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Group Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [
                'short_name' => 'required|max:255',
                'name' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = Group::find($id);
            $tag->name = $request->name;
            $tag->short_name = $request->short_name;

            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';
            $tag->save();

            return response()->json(['message' => 'Group updated successfully.', 'status' => 201], 201);
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
        $dlt = Group::find($id);
        $dlt->delete();

        Toastr::success('message', 'Group deleted successfully.');
        return redirect()->back();
    }
}
