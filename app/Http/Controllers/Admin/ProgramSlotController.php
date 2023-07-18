<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramSlot;
use Brian2694\Toastr\Facades\Toastr;
use Validator;
use Exception;
use Illuminate\Http\Request;

class ProgramSlotController extends Controller
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

        $programSlots = ProgramSlot::groupBy("program_id")->paginate($paginate);
        return view('pages.admin.programSlots.index', compact('programSlots', 'programs'));
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

                'program_id' => 'required|unique:program_slots|max:255',

            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }


            $programSlot   = new ProgramSlot();
            $programSlot->program_id = $request->program_id;
            $programSlot->from_time = $request->from_time;
            $programSlot->to_time = $request->to_time;
            $programSlot->apply_time = $request->apply_time;
            $slots = "";
            foreach ($request->custom_slots as $i => $slot) {
                if ($i < count($request->custom_slots) - 1) {
                    $slots .= $slot . ",";
                } else {
                    $slots .= $slot;
                }
            }
            $programSlot->custom_slots = $slots;
            $programSlot->save();


            return response()->json(['message' => 'Game Times Created successfully.', 'status' => 201], 201);
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

            if ($request->has('toggle')) {
                $tag =  ProgramSlot::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Game Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [

                'program_id' => 'required|max:255',

            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }


            $programSlot   =  ProgramSlot::find($id);
            $programSlot->program_id = $request->program_id;
            $programSlot->from_time = $request->from_time;
            $programSlot->to_time = $request->to_time;
            $programSlot->apply_time = $request->apply_time;
            $slots = "";
            foreach ($request->custom_slots as $i => $slot) {
                if ($i < count($request->custom_slots) - 1) {
                    $slots .= $slot . ",";
                } else {
                    $slots .= $slot;
                }
            }
            $programSlot->custom_slots = $slots;
            $programSlot->save();


            return response()->json(['message' => 'Game Times Updated successfully.', 'status' => 201], 201);
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
        $dlt = ProgramSlot::find($id);
        $dlt->delete();

        Toastr::success('message', 'Game Times  deleted successfully.');
        return redirect()->back();
    }
}
