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

    $view->location = \App\Location::with('usersLike', 'comments')->where('id', '=', $id)->first();

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

Route::post('locations/{location}/comment', function($id, \Illuminate\Http\Request $request)
{
    \App\Comment::create([
        'text' => $request->get('text'),
        'user_id' => $request->user()->id,
        'location_id' => $id
    ]);

    return back();
});

Route::get('locations/{comment}/delete', function($id)
{
    \App\Comment::find($id)->delete();

    return back()->with('success', 'Commento eliminato con successo');
});

Route::get('more/{id}', function($id)
{
    return \App\User::find($id)->locations;
});

Route::get('liked', function(\Illuminate\Http\Request $request)
{
    $view = view('locations.liked');
    $view->locations = $request->user()->likes()->paginate(10);
    return $view;
});