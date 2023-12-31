<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\UserClubAccess;
use App\Models\UserNotification;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Validator;

class UserNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = env('PAGINATE');

        if (request()->has('start_date') || request("end_date")) {
            $userNotifications = UserNotification::where("status", 1);
            if (request("start_date") != "") {
                $userNotifications =  $userNotifications->where('created_at', ">=", request("start_date"));
            }
            if (request("end_date") != "") {
                $userNotifications =  $userNotifications->where('created_at', "<=", request("end_date"));
            }
            $userNotifications =   $userNotifications->paginate($paginate);
            return view('pages.admin.userNotification.index', compact('userNotifications'));
        }
        $userNotifications = UserNotification::paginate($paginate);
        return view("pages.admin.userNotification.index", compact('userNotifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view("pages.admin.userNotification.create", compact('users'));
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
                'subject' => 'required|unique:user_notifications|max:255',
                'notification' => 'required||min:5',
            ];



            $validator = Validator::make($request->all(), $arr);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $users = [];

            $tag =  new UserNotification();
            $tag->subject = $request->subject;
            $tag->notification = $request->notification;
            $tag->status = 1;

            $user_ids = $request->users;
            if ($request->has("users") && is_array($user_ids)) {
                if (count($user_ids)) {
                    $tag->object_type = implode(",", $user_ids);
                    foreach ($user_ids as $id) {
                        $users[] = User::find($id);
                    }
                }
            }

            if ($request->has('all')) {
                $users = User::where("user_type", "active")->get();
                $tag->object_type = "all";
            }
            $tag->save();

            $this->sendNotification($users);

            return response()->json(['message' => 'notification created successfully.', 'status' => 201], 201);
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
    public function sendNotification($users)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
