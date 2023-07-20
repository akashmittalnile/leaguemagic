<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\SportExport;
use App\Http\Controllers\Controller;
use App\Models\Sport;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;

use File;
use Illuminate\Support\Facades\Auth;
use Validator;

class SportsController extends Controller
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
            $sports = Sport::where('name', "LIKE", "%$keyword%")->orWhere('code', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.sports.index', compact('sports'));
        }
        if (request()->has('export')) {
            return (new SportExport)->download('sports.xlsx');
        }
        $sports = Sport::latest()->paginate($paginate);

        return view('pages.admin.sports.index', compact('sports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.sports.create');
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
                'code' => 'required|unique:sports|max:255',
                'name' => 'required|unique:sports|max:255',
                'sort_order' => 'unique:sports|numeric'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = new Sport();
            $tag->name = $request->name;
            $tag->code = $request->code;
            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';
            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Sports Updated successfully.', 'status' => 201], 201);
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
        $sports = Sport::find($id);


        $sports->update_url = route("admin.sports.update", $sports->id);
        return $sports;
        // return view('pages.admin.sports.edit',compact('sports'));

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
                $tag =  Sport::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Sport Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [
                'code' => 'required|max:255',
                'name' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = Sport::find($id);
            $tag->name = $request->name;
            $tag->code = $request->code;
            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';
            $tag->save();

            return response()->json(['message' => 'Sports Updated successfully.', 'status' => 201], 201);
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
        $dlt = Sport::find($id);
        $dlt->delete();

        Toastr::success('message', 'Sports deleted successfully.');
        return redirect()->back();
    }
}
