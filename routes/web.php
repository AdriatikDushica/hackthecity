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
Route::get('create/{location}/next', 'HomeController@createNext');

Route::post('create/{location}/next', 'HomeController@storeNext');

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

Route::post('locations/{location}/comment', function($id, \App\Http\Requests\CreateCommentRequest $request)
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
    $view = view('more');

    $user = \App\User::find($id);

    $view->user = $user;
    $view->locations = \App\Location::where('user_id', '=', $user->id)->whereNotNull('type_id')->paginate(9);

    return $view;
});

Route::get('liked', function(\Illuminate\Http\Request $request)
{
    $view = view('locations.liked');
    $view->locations = $request->user()->likes()->whereNotNull('type_id')->paginate(9);
    return $view;
});

Route::get('ex', function(\Illuminate\Http\Request $request)
{
    $filePath = storage_path('app/demo/test.JPG');

    $reader = \PHPExif\Reader\Reader::factory(\PHPExif\Reader\Reader::TYPE_NATIVE);

    $exif = $reader->read($filePath);

    return $exif->getGPS() ? $exif->getGPS() : ['latitute'=>null, 'longitude'=>null];
});