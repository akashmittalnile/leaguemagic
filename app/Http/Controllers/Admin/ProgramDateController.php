<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramDate;
use App\Models\Program;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Validator;

class ProgramDateController extends Controller
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



        $programDates = ProgramDate::groupBy("program_id")->paginate($paginate);
        return view('pages.admin.programDates.index', compact('programDates', 'programs'));
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

                'program_id' => 'required|unique:program_schedules|max:255',
                'dates_count' => 'required'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            for ($i = 1; $i <= $request->dates_count; $i++) {
                $program   = new ProgramDate();
                $program->program_id = $request->program_id;
                $program->schedule_date = request("game_dates$i");

                $program->type = request("type$i");
                $program->save();
            }

            return response()->json(['message' => 'Game Dates Created successfully.', 'status' => 201], 201);
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
                'dates_count' => 'required'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $dates = [];
            for ($i = 1; $i <= $request->dates_count; $i++) {
                if (key_exists(request("type$i"), $dates)) {
                    array_push($dates[request("type$i")], request("game_dates$i"));
                } else {
                    $dates[request("type$i")] = [];
                    array_push($dates[request("type$i")], request("game_dates$i"));
                }
            }
            for ($i = 1; $i <= $request->dates_count; $i++) {
                $exists = ProgramDate::where("program_id", $request->program_id)->where("schedule_date", request("game_dates$i"))->where("type", request("type$i"))->count();

                if (!$exists) {
                    ProgramDate::where("program_id", $request->program_id)->whereNotIn("schedule_date", $dates[request("type$i")])->where("type", request("type$i"))->delete();
                    $program   = new ProgramDate();
                    $program->program_id = $request->program_id;
                    $program->schedule_date = request("game_dates$i");
                    $program->type = request("type$i");
                    $program->save();
                }
            }

            return response()->json(['message' => 'Game Dates updated successfully.', 'status' => 201], 201);
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
        $dlt = ProgramDate::find($id);
        $dlt->delete();

        Toastr::success('message', 'Programs and Dates deleted successfully.');
        return redirect()->back();
    }
}
