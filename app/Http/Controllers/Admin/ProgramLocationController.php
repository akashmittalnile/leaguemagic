<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Program;
use App\Models\ProgramLocation as ModelsProgramLocation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ProgramLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $guard = 'admin';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        $paginate = env('PAGINATE');
        $programs = Program::all();
        $locations = Location::all();


        $programLocations = ModelsProgramLocation::groupBy("program_id")->paginate($paginate);
        return view('pages.admin.programLocations.index', compact('programLocations', 'programs', 'locations'));
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

                'program_id' => 'required|unique:program_locations|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }


            foreach ($request->locations as $location_id) {
                $program   = new ModelsProgramLocation();

                $program->program_id = $request->program_id;
                $program->location_id = $location_id;
                $program->status = $request->status;
                $program->save();
            }







            return response()->json(['message' => 'Program Created successfully.', 'status' => 201], 201);
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
            $arr = [

                'program_id' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            ModelsProgramLocation::whereNotIn('location_id', $request->locations)->where("program_id", $request->program_id)->delete();
            foreach ($request->locations as $location_id) {

                $count = ModelsProgramLocation::where("program_id", $request->program_id)->where("location_id", $location_id)->count();
                if (!$count) {
                    $program   = new ModelsProgramLocation();
                    $program->program_id = $request->program_id;
                    $program->location_id = $location_id;
                    $program->status = $request->status;
                    $program->save();
                }
            }







            return response()->json(['message' => 'Program Created successfully.', 'status' => 201], 201);
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
        $dlt = ModelsProgramLocation::find($id);
        $dlt->delete();

        Toastr::success('message', 'Positions deleted successfully.');
        return redirect()->back();
    }
}
