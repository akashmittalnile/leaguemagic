<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Exports\CertificateExport;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Positions;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class CertificationsController extends Controller
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
        $positions = Positions::latest()->get();
        $paginate = env('PAGINATE');
        if (request()->has('search')) {
            $keyword = request("search");
            $certificates = Certificate::where('name', "LIKE", "%$keyword%")->paginate($paginate);
            return view('pages.admin.certificates.index', compact('certificates', 'positions'));
        }
        if (request()->has('export')) {
            return (new CertificateExport)->download('certificates.xlsx');
        }
        $certificates = Certificate::latest()->paginate($paginate);
        return view('pages.admin.certificates.index', compact('certificates', 'positions'));
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

                'name' => 'required|unique:certificates|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag = new Certificate();
            $tag->name = $request->name;
            $tag->group_id = $request->group_id;
            $tag->status = $request->status;
            $tag->duration = $request->duration ?? '1';
            if ($request->hasFile('certificate_format')) {
                $file = $request->file("certificate_format");
                $image = uniqid() . "." . $file->getClientOriginalExtension();
                $file->move("public/uploads/certificates/", $image);
                $tag->upload_format = $image;
            }
            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Certificate created successfully.', 'status' => 201], 201);
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
                $tag =  Certificate::find($id);
                $tag->status = $request->status;
                $tag->save();
                return response()->json(['message' => 'Certificate Status Updated successfully.', 'status' => 201], 201);
            }


            $arr = [

                'name' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $tag =  Certificate::find($id);
            $tag->name = $request->name;
            $tag->group_id = $request->group_id;
            $tag->status = $request->status;
            $tag->duration = $request->duration ?? '1';
            if ($request->hasFile('certificate_format')) {
                $file = $request->file("certificate_format");
                $image = uniqid() . "." . $file->getClientOriginalExtension();
                $file->move("public/uploads/certificates/", $image);
                $tag->upload_format = $image;
            }
            $tag->created_by = Auth::id();
            $tag->save();

            return response()->json(['message' => 'Certificate Updated successfully.', 'status' => 201], 201);
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
        $dlt = Certificate::find($id);
        $dlt->delete();

        Toastr::success('message', 'Certificate deleted successfully.');
        return redirect()->back();
    }
}
