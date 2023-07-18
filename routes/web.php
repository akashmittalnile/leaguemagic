<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    return '<h1>Cache facade value cleared</h1>';
});

Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return '<h1>migrate success</h1>';
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    // Route::get('login', 'AdminLoginController@showLoginForm')->name('admin.login');
    Route::get('/', 'AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('signin', 'AdminLoginController@login')->name('admin.login.submit');
    Route::post('logout', 'AdminLoginController@logout')->name('admin.logout');
});

Auth::routes();

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('dashboard', 'AdminDashboardController@index')->name('dashboard');
    Route::get('settings', 'AdminDashboardController@getSettings')->name('settings');
    // settings routes
    Route::resource('conference', 'ConferencesController');
    Route::resource('seasons', 'SeasonsController');
    Route::resource('sports', 'SportsController');
    Route::resource('regions', 'RegionsController');
    Route::resource('clubs', 'ClubsController');
    Route::resource('divisions', 'DivisionsController');
    Route::resource('levels', 'LevelsController');
    Route::resource('groups', 'GroupsController');
    Route::resource('positions', 'PositionsController');
    Route::resource('uniforms', 'UniformsController');
    Route::resource('locations', 'LocationsController');
    Route::resource('certificates', 'CertificationsController');


    // programs routes
    Route::resource('programs', 'ProgramController');
    Route::resource('programLocations', 'ProgramLocationController');
    Route::resource('programDates', 'ProgramDateController');
    Route::resource('programSlots', 'ProgramSlotController');
    Route::resource('programClubDivisions', 'ProgramClubDivisionController');
    Route::resource('programClubDivisionSettings', 'ProgramClubDivisionSettingController');
    Route::get('clubRegistrations', 'ClubsController@registrations')->name("clubs.registrations");


    // users
    Route::get('userAccount', 'UserController@account')->name("users.account");
    Route::resource('users', 'UserController');
    Route::resource('userAccess', 'UserAccessController');
});

Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth', 'user']], function () {
    Route::get('dashboard', 'UserDashboardController@index')->name('dashboard');
});
