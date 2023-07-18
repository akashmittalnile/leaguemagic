<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\DivisionExport;
use App\Http\Controllers\Controller;
use App\Models\Division;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use function PHPSTORM_META\type;

class DivisionsController extends Controller
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
            $divisions = Division::where('name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.divisions.index', compact('divisions'));
        }
        if (request()->has('export')) {
            return (new DivisionExport)->download('divisions.xlsx');
        }
        $divisions = Division::latest()->paginate($paginate);
        return view('pages.admin.divisions.index', compact('divisions'));
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
                'code' => 'required|unique:divisions|max:255',
                'name' => 'required|unique:divisions|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            // dd(typeOf($request->age_group));
            $tag = new Division();
            $tag->name = $request->name;
            $tag->short_name = $request->short_name;
            $tag->share_field = $request->share_field;
            $tag->sort_order = $request->sort_order;
            $tag->badge_color = "$request->RED,$request->BLUE,$request->GREEN";
            $tag->bedge_color_hex = $request->bedge_color_hex;
            $tag->text_color = $request->text_color;
            $tag->playdown_age = $request->playdown_age;

            $age_group = "";
            foreach ($request->age_group as $i => $age) {
                if ($i < count($request->age_group) - 1) {
                    $age_group .= $age . ",";
                } else {
                    $age_group .= $age;
                }
            }
            $tag->age_group = $age_group;
            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';

            $tag->save();

            return response()->json(['message' => 'Divisions created successfully.', 'status' => 201], 201);
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
                $tag =  Division::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Division Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [
                'code' => 'required|max:255',
                'name' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag =  Division::find($id);
            $tag->name = $request->name;
            $tag->code = $request->code;

            $tag->short_name = $request->short_name;
            $tag->share_field = $request->share_field;
            $tag->sort_order = $request->sort_order;
            $tag->badge_color = "$request->RED,$request->BLUE,$request->GREEN";
            $tag->bedge_color_hex = $request->bedge_color_hex;
            $tag->text_color = $request->text_color;

            $tag->playdown_age = $request->playdown_age;
            $age_group = "";
            foreach ($request->age_group as $i => $age) {
                if ($i < count($request->age_group) - 1) {
                    $age_group .= $age . ",";
                } else {
                    $age_group .= $age;
                }
            }
            $tag->age_group = $age_group;
            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';

            $tag->save();
            if ($tag->save()) {
                return response()->json(['message' => 'Divisions Updated successfully.', 'status' => 201], 201);
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
        $dlt = Division::find($id);
        $dlt->delete();

        Toastr::success('message', 'Conference deleted successfully.');
        return redirect()->back();
    }
}
