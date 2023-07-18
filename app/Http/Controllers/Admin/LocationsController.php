<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\LocationExport;
use App\Http\Controllers\Controller;
use App\Models\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Toastr;

class LocationsController extends Controller
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
            $locations = Location::where('name', "LIKE", "%$keyword%")->orWhere('title', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.locations.index', compact('locations'));
        }
        if (request()->has('export')) {
            return (new LocationExport)->download('locations.xlsx');
        }
        $locations = Location::latest()->paginate($paginate);


        return view('pages.admin.locations.index', compact('locations'));
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
                'code' => 'required|unique:locations|max:255',

            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = new Location();
            $tag->name = $request->name;
            $tag->code = $request->code;
            $tag->title = $request->title;
            $tag->city = $request->city;
            $tag->address = $request->address;
            $tag->state = $request->state;
            $tag->zipcode = $request->zipcode;
            $tag->colortheme = $request->colortheme;
            $tag->homeclub = $request->homeclub;
            $tag->fields = $request->fields;


            $tag->status = $request->status;

            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Location created successfully.', 'status' => 201], 201);
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
                $tag =  Location::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Location Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [
                'code' => 'required|max:255',
                'zipcode' => 'required|max:255',
                'fields' => 'required|max:255',
                'homeclub' => 'required|max:255',
                'city' => 'required|max:255',

            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = Location::find($id);
            $tag->name = $request->name;
            $tag->code = $request->code;
            $tag->title = $request->title;
            $tag->city = $request->city;
            $tag->address = $request->address;
            $tag->state = $request->state;
            $tag->zipcode = $request->zipcode;
            $tag->colortheme = $request->colortheme;
            $tag->homeclub = $request->homeclub;
            $tag->fields = $request->fields;


            $tag->status = $request->status;

            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Location Updated successfully.', 'status' => 201], 201);
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
        $dlt = Location::find($id);
        $dlt->delete();

        Toastr::success('message', 'Location deleted successfully.');
        return redirect()->back();
    }
}
