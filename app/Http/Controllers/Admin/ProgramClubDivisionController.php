<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Division;
use App\Models\Group;
use App\Models\Level;
use App\Models\Program;
use App\Models\ProgramClubDivision;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Validator;
use Illuminate\Http\Request;

class ProgramClubDivisionController extends Controller
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
        $divisions = Division::all();
        $groups = Group::all();
        $levels = Level::all();

        $programClubDivisions = ProgramClubDivision::groupBy("program_id")->paginate($paginate);
        return view('pages.admin.programClubDivisions.index', compact('programClubDivisions', 'programs', 'clubs', 'divisions', 'groups', 'levels'));
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

                'club_id' => 'required|max:255',
                'program_id' => 'required|max:255'

            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            foreach ($request->club_divisions as $dlg) {
                $program   = new ProgramClubDivision();
                $program->club_id = $request->club_id;
                $program->program_id = $request->program_id;
                $program->description = $dlg;

                $dlg = explode("-", $dlg);
                if (count($dlg) > 2) {
                    $program->division_id = $dlg[0];
                    $program->level_id = $dlg[1];
                    $program->group_id = $dlg[2];
                } else if (count($dlg) > 1) {
                    $program->division_id = $dlg[0];
                    $program->level_id = $dlg[1];
                } else if (count($dlg) > 0) {
                    $program->division_id = $dlg[0];
                }

                $program->save();
            }

            return response()->json(['message' => 'Teams created successfully.', 'status' => 201], 201);
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
            $arr = [

                'club_id' => 'required|max:255',
                'program_id' => 'required|max:255'

            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            ProgramClubDivision::where("program_id", $request->program_id)->where("program_id", $request->program_id)->whereNotIn("description", $request->club_divisions)->delete();
            foreach ($request->club_divisions as $dlg) {
                $exists =    ProgramClubDivision::where("program_id", $request->program_id)->where("program_id", $request->program_id)->where("description", $dlg)->count();
                if (!$exists) {
                    $program   = new ProgramClubDivision();
                    $program->club_id = $request->club_id;
                    $program->program_id = $request->program_id;
                    $program->description = $dlg;

                    $dlg = explode("-", $dlg);
                    if (count($dlg) > 2) {
                        $program->division_id = $dlg[0];
                        $program->level_id = $dlg[1];
                        $program->group_id = $dlg[2];
                    } else if (count($dlg) > 1) {
                        $program->division_id = $dlg[0];
                        $program->level_id = $dlg[1];
                    } else if (count($dlg) > 0) {
                        $program->division_id = $dlg[0];
                    }

                    $program->save();
                }
            }

            return response()->json(['message' => 'Teams updated successfully.', 'status' => 201], 201);
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
        $dlt = ProgramClubDivision::find($id);
        ProgramClubDivision::where("program_id", $dlt->program_id)->delete();
        Toastr::success('message', 'Team deleted successfully.');
        return redirect()->back();
    }
}
