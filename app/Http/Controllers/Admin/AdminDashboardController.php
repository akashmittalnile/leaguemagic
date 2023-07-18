<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Request as RequestsUrl;

use App\User;
use Config;
use Validator;
use Mail;
use Auth;
use DB;

class AdminDashboardController extends Controller
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

    public function index()
    {
        return view('pages.admin.dashboard');
    }

    public function getSettings()
    {
        $template = last(RequestsUrl::segments());
        $segments = RequestsUrl::segments();

        return view('pages.admin.settings', compact('template', 'segments'));
    }
}
