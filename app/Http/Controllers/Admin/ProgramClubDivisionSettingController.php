<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Division;
use App\Models\Group;
use App\Models\Level;
use App\Models\Program;
use App\Models\ProgramClubDivision;
use App\Models\ProgramClubDivisionSetting;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Validator;

class ProgramClubDivisionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = env('PAGINATE');
        $programs = Program::all();
        $clubs = Club::all();


        $programClubDivisions = ProgramClubDivision::groupBy("program_id")->paginate($paginate);
        return view('pages.admin.programClubDivisionSettings.index', compact('programClubDivisions', 'programs', 'clubs'));
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
                'program_id' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $program = Program::find($request->program_id);
            // dd($program->programClubDivisions);
            $count = 0;
            foreach ($program->programClubDivisions as $B) {
                $count += 1;
            }
            for ($i = 0; $i < $count; $i++) {
                $program_club_division_id = request("program_club_division_id$i");

                $age_group = implode(",", request("age_group$i"));
                $playdown_age_group = implode(",", request("playdown_age_group$i"));

                $program   = new ProgramClubDivisionSetting();

                $program->program_club_division_id = $program_club_division_id;
                $program->age_group = $age_group;
                $program->playdown_age_group = $playdown_age_group;
                $program->save();
            }



            return response()->json(['message' => 'Playoff Divisions  Created successfully.', 'status' => 201], 201);
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
        $programClubDivisions = ProgramClubDivision::where("program_id", $id)->get();

        if (request()->has("edit")) {
            $html = view("pages.admin.programClubDivisionSettings.item", compact('programClubDivisions'))->render();
            return response()->json(['status' => 201, 'data' => $html], 201);
        }
        foreach ($programClubDivisions as $pc) {

            $pc->combinedDivision =   $pc->combinedDivision();
        }

        return response()->json(['status' => 201, 'data' => $programClubDivisions], 201);
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
            $program = Program::find($request->program_id);
            // dd($program->programClubDivisions);
            $count = 0;
            foreach ($program->programClubDivisions as $B) {
                $count += 1;
            }
            for ($i = 0; $i < $count; $i++) {
                $program_club_division_id = request("program_club_division_id$i");

                $age_group = implode(",", request("age_group$i"));
                $playdown_age_group = implode(",", request("playdown_age_group$i"));

                $program   =  ProgramClubDivisionSetting::where("program_club_division_id", $program_club_division_id)->first();

                $program->age_group = $age_group;
                $program->playdown_age_group = $playdown_age_group;
                $program->save();
            }



            return response()->json(['message' => 'Playoff Divisions Updated successfully.', 'status' => 201], 201);
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
        $dlt = ProgramClubDivisionSetting::where("program_club_division_id", $id);
        $dlt->delete();
        Toastr::success('message', 'Divisions Settings deleted successfully.');
        return redirect()->back();
    }
}
