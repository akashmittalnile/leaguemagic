<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\UniformExport;
use App\Http\Controllers\Controller;
use App\Models\Uniform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Toastr;

class UniformsController extends Controller
{
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
            $uniforms = Uniform::where('name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.uniforms.index', compact('uniforms'));
        }
        if (request()->has('export')) {
            return (new UniformExport)->download('uniforms.xlsx');
        }
        $uniforms = Uniform::latest()->paginate($paginate);


        return view('pages.admin.uniforms.index', compact('uniforms'));
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

                'name' => 'required|unique:uniforms|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = new Uniform();
            $tag->name = $request->name;
            $tag->isleague = $request->isleague;

            $tag->status = $request->status;

            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Uniform created successfully.', 'status' => 201], 201);
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
                $tag =  Uniform::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Uniform Status Updated successfully.', 'status' => 201], 201);
            }
            $arr = [

                'name' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag =  Uniform::find($id);
            $tag->name = $request->name;
            $tag->isleague = $request->isleague;

            $tag->status = $request->status;

            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Uniform Updated successfully.', 'status' => 201], 201);
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
        $dlt = Uniform::find($id);
        $dlt->delete();

        Toastr::success('message', 'Uniform deleted successfully.');
        return redirect()->back();
    }
}
