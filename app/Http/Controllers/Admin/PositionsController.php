<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\PositionExport;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Positions;
use Exception;
use Illuminate\Http\Request;
use Toastr;
use Validator;

class PositionsController extends Controller
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
            $positions = Positions::where('name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.positions.index', compact('positions'));
        }
        if (request()->has('export')) {
            return (new PositionExport)->download('positions.xlsx');
        }
        $positions = Positions::orderBy("sort_order")->paginate($paginate);
        return view('pages.admin.positions.index', compact('positions'));
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

                'name' => 'required|max:255',
                'sort_order' => 'unique:positions|numeric'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag   = new Positions();
            $tag->name = $request->name;

            $tag->account_access = $request->account_access;
            $tag->admin_badge = $request->admin_badge;
            $tag->badge_color = "$request->RED,$request->BLUE,$request->GREEN";
            $tag->position_ratio = "$request->left_position_ratio/$request->right_position_ratio";
            $tag->badge_color_hex = $request->badge_color_hex;
            $tag->text_color = $request->text_color;
            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';

            $tag->save();
            if ($tag->save()) {
                return response()->json(['message' => 'Positions Updated successfully.', 'status' => 201], 201);
            }
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
                $tag =  Positions::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Positions Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [

                'name' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag   = Positions::find($id);
            $tag->name = $request->name;

            $tag->account_access = $request->account_access;
            $tag->admin_badge = $request->admin_badge;
            $tag->badge_color = "$request->RED,$request->BLUE,$request->GREEN";
            $tag->position_ratio = "$request->left_position_ratio/$request->right_position_ratio";
            $tag->badge_color_hex = $request->badge_color_hex;
            $tag->text_color = $request->text_color;
            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';

            $tag->save();
            if ($tag->save()) {
                return response()->json(['message' => 'Positions Updated successfully.', 'status' => 201], 201);
            }
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
        $dlt = Positions::find($id);
        $dlt->delete();

        Toastr::success('message', 'Positions deleted successfully.');
        return redirect()->back();
    }
}
