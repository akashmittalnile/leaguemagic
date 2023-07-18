<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\ProgramExport;
use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Program;
use App\Models\ProgramClub;
use App\Models\Seasons;
use App\Models\Sport;
use Exception;
use Illuminate\Http\Request;
use Validator;
use Toastr;

class ProgramController extends Controller
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
        $seasons = Seasons::all();
        $clubs = Club::all();
        $sports = Sport::all();
        if (request()->has('search')) {
            $keyword = request("search");
            $programs = Program::where('name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.programs.index', compact('programs', 'seasons', 'clubs', 'sports'));
        }
        if (request()->has('export')) {
            return (new ProgramExport)->download('programs.xlsx');
        }
        $programs = Program::latest()->paginate($paginate);
        return view('pages.admin.programs.index', compact('programs', 'seasons', 'clubs', 'sports'));
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

                'name' => 'required|unique:programs|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag   = new Program();
            $tag->name = $request->name;

            $tag->season_id = $request->season_id;
            $tag->sport_id = $request->sport_id;
            $tag->league_age_date = $request->league_age_date;
            $tag->program_fee = $request->program_fee;
            $tag->jersey_fee = $request->jersey_fee;

            $tag->status = $request->status;


            $tag->save();

            foreach ($request->participating_clubs as $club_id) {
                $program   = new ProgramClub();
                $program->program_id = $tag->id;
                $program->club_id = $club_id;
                $program->status = 1;
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
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        try {
            if ($request->has('toggle')) {
                $tag =  $program;
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Program Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [

                'name' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag   = $program;
            $tag->name = $request->name;

            $tag->season_id = $request->season_id;
            $tag->sport_id = $request->sport_id;
            $tag->league_age_date = $request->league_age_date;
            $tag->program_fee = $request->program_fee;
            $tag->jersey_fee = $request->jersey_fee;

            $tag->status = $request->status;


            $tag->save();

            foreach ($request->participating_clubs as $club_id) {
                $data = ProgramClub::where('program_id', $tag->id)->where('program_id', $club_id)->count();
                if (!$data) {
                    $ProgramClub   = new ProgramClub();
                    $ProgramClub->program_id = $tag->id;
                    $ProgramClub->club_id = $club_id;
                    $ProgramClub->status = 1;
                    $ProgramClub->save();
                }
            }

            return response()->json(['message' => 'Program Updated successfully.', 'status' => 201], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 200], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {

        $program->delete();

        Toastr::success('message', 'Programs deleted successfully.');
        return redirect()->back();
    }
}
