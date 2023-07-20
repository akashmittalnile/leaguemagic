<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\RegionExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Conference;
use App\Models\Reagion;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Toastr;
use Auth;
use File;
use Validator;

class RegionsController extends Controller
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
        $conference = Conference::latest()->get();
        if (request()->has('search')) {
            $keyword = request("search");
            $regions = Reagion::where('name', "LIKE", "%$keyword%")->orWhere('code', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.regions.index', compact('regions', 'conference'));
        }
        if (request()->has('export')) {
            return (new RegionExport)->download('regions.xlsx');
        }
        $regions = Reagion::orderBy("sort_order")->paginate($paginate);


        return view('pages.admin.regions.index', compact('regions', 'conference'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $conference = Conference::latest()->get();

        return view('pages.admin.region.create', compact('conference'));
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
                'code' => 'required|unique:reagions|max:255',
                'name' => 'required|unique:reagions|max:255',
                'sort_order' => 'unique:reagions|numeric'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = new Reagion();
            $tag->name = $request->name;
            $tag->code = $request->code;
            $tag->confefrence_id = $request->confefrence_id ?? '';
            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';
            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Region created successfully.', 'status' => 201], 201);
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
        $region = Reagion::find($id);
        $conference = Conference::latest()->get();

        return view('pages.admin.region.edit', compact('region', 'conference'));
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
                $tag =  Reagion::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Reagion Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [
                'code' => 'required|max:255',
                'name' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = Reagion::find($id);
            $tag->name = $request->name;
            $tag->code = $request->code;
            $tag->confefrence_id = $request->confefrence_id ?? '';
            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';
            $tag->save();

            return response()->json(['message' => 'Region updated successfully.', 'status' => 201], 201);
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
        $dlt = Reagion::find($id);
        $dlt->delete();

        Toastr::success('message', 'Region deleted successfully.');
        return redirect()->back();
    }
}
