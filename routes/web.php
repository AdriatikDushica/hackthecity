<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/{provider}', 'ExternalAuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'ExternalAuthController@handleProviderCallback');

Auth::routes();

Route::resource('home', 'HomeController');

Route::get('locations/{location}', function($id)
{
    $view = view('locations.detail');

    $view->location = \App\Location::with('usersLike')->where('id', '=', $id)->first();

    return $view;
});

Route::get('locations/{location}/like', function(\App\Location $location, \Illuminate\Http\Request $request)
{

    $likes = \Auth::user()->likes->where('id', '=', $location->id);
    if($likes->count()) {
        $request->user()->likes()->detach($likes);
    } else {
        $request->user()->likes()->attach($location);
    }

    return back();
});


Route::get('more/{id}', function($id)
{
    return \App\User::find($id)->locations;
});