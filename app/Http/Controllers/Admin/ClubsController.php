<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\ClubExport;
use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Conference;
use App\Models\Reagion;
use Illuminate\Http\Request;
use Toastr;
use Auth;
use File;
use Validator;

class ClubsController extends Controller
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

        $regions = Reagion::latest()->get();
        $conference = Conference::latest()->get();
        if (request()->has('search')) {
            $keyword = request("search");
            $clubs = Club::where("status", "!=", 2)->where('title', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.clubs.index', compact('clubs', 'regions', 'conference'));
        }

        if (request()->has('export')) {
            return (new ClubExport)->download('clubs.xlsx');
        }
        $clubs = Club::latest()->where("status", "!=", 2)->paginate($paginate);

        return view('pages.admin.clubs.index', compact('clubs', 'regions', 'conference'));
    }
    public function registrations()
    {

        $paginate = env('PAGINATE');

        $regions = Reagion::latest()->get();
        $conference = Conference::latest()->get();
        if (request()->has('search')) {
            $keyword = request("search");
            $clubs = Club::where("status", 2)->where('title', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.clubs.registrations', compact('clubs', 'regions', 'conference'));
        }
        $clubs = Club::where("status", 2)->paginate($paginate);

        return view('pages.admin.clubs.registrations', compact('clubs', 'regions', 'conference'));
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
                'schedule_code' => 'required|unique:clubs|max:255',
                'title' => 'required|unique:clubs|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = new Club();
            $tag->title = $request->title;
            $tag->schedule_code = $request->schedule_code;
            $tag->conference_id = $request->conference_id ?? '';
            $tag->region_id = $request->region_id ?? '';

            $tag->status = $request->status;
            $tag->player_import = $request->player_import ?? 0;
            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Clubs created successfully.', 'status' => 201], 201);
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
                $tag =  Club::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Club Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [
                'schedule_code' => 'required|max:255',
                'title' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag =  Club::find($id);
            $tag->title = $request->title;
            $tag->schedule_code = $request->schedule_code;
            $tag->conference_id = $request->conference_id ?? '';
            $tag->region_id = $request->region_id ?? '';

            $tag->status = $request->status;
            $tag->player_import = $request->player_import ?? 0;
            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Clubs updated successfully.', 'status' => 201], 201);
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
        $dlt = Club::find($id);
        $dlt->delete();

        Toastr::success('message', 'Region deleted successfully.');
        return redirect()->back();
    }
}
