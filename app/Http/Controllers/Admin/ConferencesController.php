<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\ConferenceExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Conference;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Toastr;
use Auth;
use File;
use Validator;

class ConferencesController extends Controller
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
            $conference = Conference::where('title', "LIKE", "%$keyword%")->orWhere('title', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.conference.index', compact('conference'));
        }
        if (request()->has('export')) {
            return (new ConferenceExport)->download('conference.xlsx');
        }
        $conference = Conference::latest()->paginate($paginate);
        return view('pages.admin.conference.index', compact('conference'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.conference.create');
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
                'title' => 'required|unique:conferences|max:255',
                'name' => 'required|unique:conferences|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = new Conference();
            $tag->name = $request->name;
            $tag->title = $request->title;
            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';
            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Conference created successfully.', 'status' => 201], 201);
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
        $conference = Conference::find($id);

        // return view('pages.admin.conference.edit',compact('conference'));
        $conference->update_url = route("admin.conference.update", $conference->id);
        return $conference;
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
                $tag =  Conference::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Conference Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [
                'title' => 'required|max:255',
                'name' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = Conference::find($id);
            $tag->name = $request->name;
            $tag->title = $request->title;
            $tag->status = $request->status;
            $tag->sort_order = $request->sort_order ?? '1';
            $tag->save();

            // Toastr::success('message', 'Conference Updated successfully.');
            // return redirect()->back();
            return response()->json(['message' => "Confrence Updated Succesfully", 'status' => 201], 201);
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
        $dlt = Conference::find($id);
        $dlt->delete();

        Toastr::success('message', 'Conference deleted successfully.');
        return redirect()->back();
    }
}
