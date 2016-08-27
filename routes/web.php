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

Route::get('locations/{location}', function(\App\Location $location)
{
    $view = view('locations.detail');
    $view->location = $location;
    return $view;
});

Route::get('more/{id}', function($id)
{
    return \App\User::find($id)->locations;
});