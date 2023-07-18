<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\SeasonExport;
use App\Http\Controllers\Controller;
use App\Models\Seasons;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeasonsController extends Controller
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
            $seasons = Seasons::where('name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.seasons.index', compact('seasons'));
        }
        if (request()->has('export')) {
            return (new SeasonExport)->download('seasons.xlsx');
        }
        $seasons = Seasons::latest()->paginate($paginate);
        return view('pages.admin.seasons.index', compact('seasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.seasons.create');
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

                'name' => 'required|unique:seasons|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = new Seasons();
            $tag->name = $request->name;

            $tag->status = $request->status;

            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Seasons created successfully.', 'status' => 201], 201);
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
        $seasons = Seasons::find($id);



        $seasons->update_url = route("admin.seasons.update", $seasons->id);
        return $seasons;
        // return view('pages.admin.sports.edit',compact('sports'));

        // return view('pages.admin.seasons.edit',compact('season'));

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
                $tag =  Seasons::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Seasons Status Updated successfully.', 'status' => 201], 201);
            }
            if ($request->has('toggle')) {
                $tag =  Seasons::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Seasons Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [

                'name' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = Seasons::find($id);
            $tag->name = $request->name;

            $tag->status = $request->status;

            $tag->save();

            return response()->json(['message' => 'Seasons Updated successfully.', 'status' => 201], 201);
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
        $dlt = Seasons::find($id);
        $dlt->delete();

        Toastr::success('message', 'Season deleted successfully.');
        return redirect()->back();
    }
}
